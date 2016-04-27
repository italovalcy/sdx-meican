<?php 
/**
 * @copyright Copyright (c) 2012-2016 RNP
 * @license http://github.com/ufrgs-hyman/meican#license
 */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

use meican\base\grid\Grid;
use meican\base\grid\IcheckboxColumn;
use meican\base\grid\GridButtons;

\meican\topology\assets\provider\Index::register($this);

$this->params['header'] = ["Providers", ['Home', 'Topology']];

?>

<div class="box box-default">
    <div class="box-header with-border">
        <?= GridButtons::widget(); ?>
    </div>
    <div class="box-body">

<?php
    $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['delete'],
        'id' => 'provider-form',  
        'enableClientScript'=>false,
        'enableClientValidation' => false,
    ]);
    echo Grid::widget([
        'dataProvider' => $providers,
        'columns' => array(
                array(
                    'class'=>IcheckboxColumn::className(),
                    'name'=>'delete',         
                    'multiple'=>false,
                    'headerOptions'=>['style'=>'width: 2%;'],
                ),
        		[
	        		'class' => 'yii\grid\ActionColumn',
	        		'template'=>'{update}',
	        		'buttons' => [
	        				'update' => function ($url, $model) {
	        					return Html::a('<span class="fa fa-pencil"></span>', $url);
	        				}
	        		],
	        		'headerOptions'=>['style'=>'width: 2%;'],
        		],
        		[
	        		'class' => 'yii\grid\ActionColumn',
	        		'template'=>'{view}',
	        		'buttons' => [
	        				'view' => function ($url, $model) {
	        					return Html::a('<span class="fa fa-eye"></span>', $url, [ 'title'=>Yii::t("topology",'Show details and services of this provider')]);
	        				}
	        		],
	        		'headerOptions'=>['style'=>'width: 2%;'],
        		],
                'name',
                [
                    'attribute'=> 'type',
                    'value' => function($model) {
                        return $model->getType();
                    },
                ],
                'nsa',
                'latitude',
                'longitude',
            ),
    ]);

    ActiveForm::end();
?>

    </div>
</div>