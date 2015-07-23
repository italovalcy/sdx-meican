<?php

namespace app\modules\circuits\controllers;

use yii\helpers\Url;
use Yii;
use app\models\Connection;
use app\models\ConnectionPath;
use app\models\Port;
use app\models\Device;
use app\models\Domain;
use app\models\Provider;
use app\controllers\RbacController;


class ConnectionController extends RbacController {
	
	public function actionGetOrderedPaths($id) {
		$paths = ConnectionPath::find()->where(['conn_id'=>$id])->orderBy(['path_order'=> "SORT_ASC"])->all();
		 
		$data = [];
		 
		foreach ($paths as $path) {
			$port = $path->getPort()->select(['id','device_id'])->one();
			$data[] = [
				'path_order' => $path->path_order, 
				'device_id'=> $port ? $port->device_id : null
			];
		}
		 
		$data = json_encode($data);
		Yii::trace($data);
		return $data;
	}

	public function actionGetEndPoints($id) {
    	$conn = Connection::findOne($id);
    	if ($conn->external_id) {
    		$srcPath = $conn->getFirstPath()->one();
	    	$dstPath = $conn->getLastPath()->one();
    	} else {
    		$res = $conn->getReservation()->one();
    		$srcPath = $res->getFirstPath()->one();
	    	$dstPath = $res->getLastPath()->one();
    	}
    	$srcPort = $srcPath->getPort()->one();
    	$dstPort = $dstPath->getPort()->one();
    	$srcVlan = $srcPath->vlan;
    	$dstVlan = $dstPath->vlan;
    	$srcPortUrn = $srcPath->getFullPortUrn();
    	$dstPortUrn = $dstPath->getFullPortUrn();
    	
    	$source = null;
    	$dest = null;

    	$dev = $srcPort ? $srcPort->getDevice()->one() : null;
        $net = $srcPort ? $srcPort->getNetwork()->one() : null;
        $dom = $dev->getDomain()->one();
    	
    	$source["dom"] = $dom->name;
    	$source["net"] = $net ? $net->name: "";
    	$source["dev"] = $dev ? $dev->name: "";
    	$source["port"] = $srcPort ? $srcPort->name : "";
    	$source["vlan"] = $srcVlan;
    	$source["urn"] = $srcPortUrn;

    	$dev = $dstPort ? $dstPort->getDevice()->one() : null;
        $net = $dstPort ? $dstPort->getNetwork()->one() : null;
    	
    	$dest["dom"] = $dom->name;
    	$dest["net"] = $net ? $net->name: "";
    	$dest["dev"] = $dev ? $dev->name: "";
    	$dest["port"] = $dstPort ? $dstPort->name : "";
    	$dest["vlan"] = $dstVlan;
    	$dest["urn"] = $dstPortUrn;
    	
    	$data = json_encode(["src" => $source, "dst" => $dest]);
    	Yii::trace($data);
    	return $data;
    }
	
    public function actionGetStp($id) {
    	$dev = Device::findOneParentLocation($id);
        $dom = $dev->getDomain()->select(['name'])->one()->name;
    	
    	$data = [];
    	$data['id'] = $id;
    	$data["dom"] = $dom;
    	$data["name"] = $dev->name;
    	$data['lat'] = $dev->latitude;
    	$data['lng'] = $dev->longitude;
    	
    	$data = json_encode($data);
    	Yii::trace($data);
    	return $data;
    }

	public function actionCancel($connections) {
		$numDenied = 0;
		
		foreach (json_decode($connections) as $connId) {
			$conn = Connection::findOne($connId);
			if (isset($conn->external_id)){
				$reservation = $conn->getReservation()->one();
				$source = $conn->getFirstPath()->one()->getSourcePort()->one();
				$destination = $conn->getLastPath()->one()->getDestinationPort()->one();
				$permission = false;
				if($source){ //Se tem permissão na origem
					$source = $source->getDevice()->one();
					if($source){
						$domainId = $source->domain_id;
						if(self::can('reservation/delete', $domainId)) $permission = true;
					}
				}
				if($destination){ //Se tem permissão no destino
					$destination = $destination->getDevice()->one();
					if($destination){
						$domainId = $destination->domain_id;
						if(self::can('reservation/delete', $domainId)) $permission = true;
					}
				}
				if(Yii::$app->user->getId() == $reservation->request_user_id) $permission = true; //Se é quem requisitou
				
				if($permission){
					$conn->requestCancel();
					return true;
				}
				else return false;
			}
		}
		
		return true;
	}
}

?>