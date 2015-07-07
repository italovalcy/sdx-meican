$(document).ready(function() {
	$('#map-canvas').show();
});

var map;
var shift = 0.01;
var markerWindow;
var markers = [];

///////////// DESENHAR CIRCUITO NO MAPA ///////////////

function drawCircuit(source, destin) {
	strokeColor = "#0000FF"; 
	strokeOpacity = 0.2;
	
	circuit = new google.maps.Polyline({
        path: [source.position, destin.position],
        strokeColor: strokeColor,
        strokeOpacity: strokeOpacity,
        strokeWeight: 5,
        geodesic: false,
    });
	
	/*google.maps.event.addListener(circuit, 'click', function(event) {
		markerWindow = new google.maps.InfoWindow({
			content: '<div class = "MarkerPopUp" style="width: 230px;"><div class = "MarkerContext">' +
				'what i say?</div></div>'
			});
		markerWindow.position = google.maps.geometry.spherical.interpolate(circuit.path[0], circuit.path[1], 0.5);  
		markerWindow.open(map);
    });*/
	
    circuit.setMap(map);
}

//////////// INICIALIZA MAPA /////////////////

function initialize() {
	var myLatlng = new google.maps.LatLng(0,0);
	var mapOptions = {
			zoom: 3,
			minZoom: 2,
			maxZoom: 15,
			center: myLatlng,
			streetViewControl: false,
			panControl: false,
			zoomControl: false,
			mapTypeControl: false,
	};
	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	
	google.maps.event.addListener(map, 'click', function() {
		closeWindow();
	});
	
	var markers = [];

    if (false && $("input[name=marker-type]").val() == "net") {
        $.ajax({
            url: baseUrl+'/topology/viewer/get-sdps',
            dataType: 'json',
            method: "GET",
            success: function(response) {
                for (var key in response) {
                    addSdp('network', response[key][0], response[key][1]);
                }
            }
        });
    } else {
        $.ajax({
            url: baseUrl+'/topology/viewer/get-device-links',
            dataType: 'json',
            method: "GET",
            success: function(response) {
                for (var key in response) {
                    addSdp('device', response[key][0], response[key][1]);
                }
            }
        });
    }
}

//////////// ADICIONA MARCADORES NO MAPA /////////////////

function addSdp(type, srcId, dstId) {
    if (type == "device") {
        url = type + '/get-parent-location';
    } else {
        url = type + '/get';
    }

	$.ajax({
		url: baseUrl+'/topology/' + url,
		dataType: 'json',
		method: "GET",
		data: {
			id: srcId,
		},
		success: function(object) {
            marker = getMarker(type, srcId);

            if (marker == null) {
    			var contentString = type + ': <b>'+object.name+'</b><br><br><br>';

    			if (object.latitude != null && object.longitude != null) {
    			var myLatlng = new google.maps.LatLng(object.latitude,object.longitude);
    			} else {
    			var myLatlng = new google.maps.LatLng(0, 0);
    			}

                    colorId = object.domain_id;
    			
    			var marker = new StyledMarker({
    				styleIcon: new StyledIcon(
    					StyledIconTypes.MARKER,
    						{
    							color: generateColor(colorId),
    						}
    				),
    				position: getValidMarkerPosition(myLatlng),
    				info: contentString,
    				id: object.id,
                    type: type,
    			});
    			
    			var length = markers.push(marker);
    			
    			addMarkerListeners(length - 1);
    			
    			marker.setMap(map);
            }

            addMarkerAndCircuit(marker, dstId);
		}
	});
}

function addMarkerAndCircuit(srcMarker, dstId) {
     if (srcMarker.type == "device") {
        url = srcMarker.type + '/get-parent-location';
    } else {
        url = srcMarker.type + '/get';
    }

    $.ajax({
        url: baseUrl+'/topology/' + url,
        dataType: 'json',
        method: "GET",
        data: {
            id: dstId,
        },
        success: function(object) {
            marker = getMarker(srcMarker.type, dstId);

            if (marker == null) {

                var contentString = srcMarker.type + ': <b>'+object.name+'</b><br><br><br>';
    
                if (object.latitude != null && object.longitude != null) {
                var myLatlng = new google.maps.LatLng(object.latitude,object.longitude);
                } else {
                var myLatlng = new google.maps.LatLng(0, 0);
                }

                    colorId = object.domain_id;
                
                var marker = new StyledMarker({
                    styleIcon: new StyledIcon(
                        StyledIconTypes.MARKER,
                            {
                                color: generateColor(colorId),
                            }
                    ),
                    position: getValidMarkerPosition(myLatlng),
                    info: contentString,
                    id: object.id,
                    type: srcMarker.type,
                });
                
                var length = markers.push(marker);
                
                addMarkerListeners(length - 1);
            
                marker.setMap(map);
            }

            drawCircuit(srcMarker, marker);
        }
    });
}

function getValidMarkerPosition(position) {
	for(i = 0; i < markers.length; i++){
		if ((markers[i].position.lat().toString().substring(0,6) == position.lat().toString().substring(0,6)) && 
				(markers[i].position.lng().toString().substring(0,6) == position.lng().toString().substring(0,6))) {
			return getValidMarkerPosition(new google.maps.LatLng(position.lat(), position.lng() + shift));
		}
	}
	
	return position;
}

function closeWindow() {
	if (markerWindow) {
		markerWindow.close();
	}
}

//////////// LISTENERS DOS MARCADORES /////////////

function addMarkerListeners(index) {
	google.maps.event.addListener(markers[index], 'mouseover', function(key) {
		return function(){
			closeWindow();
			
			markerWindow = new google.maps.InfoWindow({
				content: '<div class = "MarkerPopUp" style="width: 230px;"><div class = "MarkerContext">' +
					markers[key].info + '</div></div>'
				});
			
			markerWindow.open(map, markers[key]);
		}
	}(index));
}

////////// DEFINE ZOOM E LIMITES DO MAPA A PARTIR DE UM CAMINHO ////////

function setMapBounds(path) {
    if (path.length < 2) return;
    polylineBounds = new google.maps.LatLngBounds();
    for (i = 0; i < path.length; i++) {
    	polylineBounds.extend(path[i]);
    }
    map.fitBounds(polylineBounds);
    map.setCenter(polylineBounds.getCenter());
    map.setZoom(map.getZoom() - 1);
}

function getMarker(type, id) {
	for(i = 0; i < markers.length; i++){
		if (markers[i].type == type && markers[i].id == parseInt(id)) {
			return markers[i];
		}
	}
	
	return null;
}

function generateColor(domainId) {
    var firstColor = "3a5879";
    if (domainId == 0) {
        return firstColor;
    } else {
        var color = parseInt(firstColor, 16);
        color += (domainId * parseInt("d19510", 16));
        if ((color == "eee") && (color == "eeeeee")) {
            color = "dddddd";
            color = color.toString(16);
        } else if (color > 0xFFFFFF) {
            color = color.toString(16);
            color = color.substring(1, color.length);
            if(color.length > 6) {
                var str = color.split("");
                color = "";
                for (var i=1; i<str.length; i++) {
                    color = color + str[i];
                }
            }
        } else {
            color = color.toString(16);
        }
        return color;
    }
}

google.maps.event.addDomListener(window, 'load', initialize);