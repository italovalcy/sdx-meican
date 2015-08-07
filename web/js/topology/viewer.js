$(document).ready(function() {
	$('#map-canvas').show();
});

var meicanMap;
var domainsList;
var links = [];
var currentMarkerType = 'network';
var devicesLoaded = false;

$('#marker-type-network').on('change', function() {
    setMarkerType("network");
});
    
$('#marker-type-device').on('change', function() {
    setMarkerType("device");
});

function setMarkerType(markerType) {
    meicanMap.closeWindows();
    currentMarkerType = markerType;
    meicanMap.setMarkerTypeVisible(markerType);
    setLinkTypeVisible(markerType);
    if (markerType == "device") {
        if (!devicesLoaded) {
            loadDeviceMarkers();
            devicesLoaded = true;
        } 
    }
}

function setLinkTypeVisible(markerType) {
    for(var i = 0; i < links.length; i++){ 
        if (links[i].type == markerType) {
            links[i].setVisible(true);
        } else {
            links[i].setVisible(false);
        }
    }
}

////////////// ADICIONA MARCADORES DE DISPOSITIVOS ////////////////

function loadDeviceMarkers() {
    $.ajax({
        url: baseUrl+'/topology/device/get-all',
        dataType: 'json',
        method: "GET",
        data: {
            cols: JSON.stringify(['id','name','latitude','longitude','domain_id'])
        },
        success: function(response) {
            var size = response.length;
            for (var i = 0; i < size; i++) {
                addMarker("device", response[i]);
            };
            $.ajax({
                url: baseUrl+'/topology/viewer/get-device-links',
                dataType: 'json',
                method: "GET",
                success: function(response) {
                    var size = response.length;
                    for (var key in response) {
                        addCircuit('device', response[key][0], response[key][1]);
                    }
                }
            });
        }
    });
}

///////////// DESENHAR LINK NO MAPA ///////////////

function drawCircuit(source, destin) {
	strokeColor = "#0000FF"; 
	strokeOpacity = 0.2;
	
	link = new google.maps.Polyline({
        path: [source.position, destin.position],
        strokeColor: strokeColor,
        strokeOpacity: strokeOpacity,
        strokeWeight: 5,
        geodesic: false,
        type: source.type,
    });
	
	/*google.maps.event.addListener(circuit, 'click', function(event) {
		markerWindow = new google.maps.InfoWindow({
			content: '<div class = "MarkerPopUp" style="width: 230px;"><div class = "MarkerContext">' +
				'what i say?</div></div>'
			});
		markerWindow.position = google.maps.geometry.spherical.interpolate(circuit.path[0], circuit.path[1], 0.5);  
		markerWindow.open(map);
    });*/
	
    link.setMap(meicanMap.getMap());
    links.push(link);
}

//////////// INICIALIZA MAPA /////////////////

function initialize() {
	meicanMap = new MeicanMap;
    meicanMap.buildMap("map-canvas");
    meicanMap.buildSearchBox("search-row", "search-box", 'search-button');

    $.ajax({
        url: baseUrl+'/topology/network/get-all-parent-location',
        dataType: 'json',
        data: {
            cols: JSON.stringify(['id','name','latitude','longitude','domain_id'])
        },
        method: "GET",
        success: function(response) {
            var size = response.length;
            for (var i = 0; i < size; i++) {
                addMarker("network", response[i]);
            };
            $.ajax({
                url: baseUrl+'/topology/viewer/get-network-links',
                dataType: 'json',
                method: "GET",
                success: function(response) {
                    var size = response.length;
                    for (var key in response) {
                        addCircuit('network', response[key][0], response[key][1]);
                    }
                }
            });
        }
    });
}

//////////// ADICIONA MARCADORES NO MAPA /////////////////

function addMarker(type, object) {
    domainName = getDomainName(object.domain_id);
    if (object.name == "") {
        object.name = 'default';
    }

    var network = null;
    if (type == 'device') network = getNetworkMarkerByDomain(object.domain_id);

    var contentString = 'Domain: ' + '<b>' + domainName + '</b><br>' + type.ucFirst() + ': <b>'+object.name+'</b><br><br><br>';

    if (object.latitude != null && object.longitude != null) {
        var myLatlng = new google.maps.LatLng(object.latitude,object.longitude);
    } else if (network) {
        var myLatlng = network.position;
    } else {
        var myLatlng = new google.maps.LatLng(0, 0);
    }

    if (type == "network") {
        var marker = meicanMap.NetworkMarker({
            position: meicanMap.getValidMarkerPosition(type, myLatlng),
            info: contentString,
            id: object.id,
            domainId: object.domain_id,
            type: type,
        });
    } else {
        var marker = meicanMap.DeviceMarker({
            position: meicanMap.getValidMarkerPosition(type, myLatlng),
            type: type,
            id: object.id,
            domainId: object.domain_id,
            info: contentString,
        });
    }
    
    meicanMap.addMarker(marker);
    
    addMarkerListeners(marker);
    
    marker.setMap(meicanMap.getMap());
}

function addCircuit(type, srcId, dstId) {
    srcMarker = meicanMap.getMarker(type, srcId);
    dstMarker = meicanMap.getMarker(type, dstId);

    drawCircuit(srcMarker, dstMarker);
}

//////////// LISTENERS DOS MARCADORES /////////////

function addMarkerListeners(marker) {
	google.maps.event.addListener(marker, 'mouseover', function() {
		meicanMap.closeWindows();
		meicanMap.openWindow(marker);
	});
}

////////// DEFINE ZOOM E LIMITES DO MAPA A PARTIR DE UM CAMINHO ////////

function setMapBounds(path) {
    if (path.length < 2) return;
    polylineBounds = new google.maps.LatLngBounds();
    for (var i = 0; i < path.length; i++) {
    	polylineBounds.extend(path[i]);
    }
    meicanMap.getMap().fitBounds(polylineBounds);
    meicanMap.getMap().setCenter(polylineBounds.getCenter());
    meicanMap.getMap().setZoom(meicanMap.getMap().getZoom() - 1);
}

function getNetworkMarkerByDomain(domainId) {
    return meicanMap.getMarkerByDomain("network", domainId);
}

function getDomainName(id) {
    if (!domainsList) domainsList = JSON.parse($("#domains-list").text());
    for (var i = 0; i < domainsList.length; i++) {
        if(domainsList[i].id == id)
        return domainsList[i].name;
    };
}

google.maps.event.addDomListener(window, 'load', initialize);