var markerClusterer_two = null;

var map_markers_two = [];
var markerClusterer_two = null;
var mapCentre_two = null;

var latlngbounds_two = null;
var map_two = null;

$(window).load(function(){
	var countryCenter = new google.maps.LatLng(COUNTRY_LATITUDE, COUNTRY_LONGITUDE);
	var mapOptions_two = {
		zoom: 6,
		center: countryCenter
	};

	map_two = new google.maps.Map(document.getElementById('services_location'), mapOptions_two);

	var url = BASE_URL_SITE+"loadmap.php?type=2&lang="+CURRENT_LANGUAGE;
	LoadGoogleMapTwo(url);
});

function LoadGoogleMapTwo(url) {
	map_markers_two = [];

	latlngbounds_two = new google.maps.LatLngBounds();
	google.maps.Map.prototype.clearOverlays = function() {
		if (map_markers_two) {
			for (var i = 0; i < map_markers_two.length; i++) {
				map_markers_two[i].setMap(null);
			}
		}
	}

	google.maps.event.addListener(map, 'zoom_changed', function() {
		var opt = {minZoom: 6, maxZoom: 20};
		map_two.setOptions(opt);
	});

	var myLatLngArry_two = [];
	map_two.clearOverlays();

	var lat = "";
	var long = "";
	var myLatlng = "";

	$.ajax({
        cache: false,
		url: url,
		beforeSend: function(){

		}
	}).success(function(data){
		var data = $.parseJSON(data);

		var loop = 0;
		var myLatLngArry_two = [];
		if (data !== '') {
			if ($.isArray(data.markers) && data.markers.length > 0) {
				var loopCount = 0;
				$.each(data.markers, function(i, m) {
					if (m.type == 'Stories') {
						image = STORIES_IMAGE;
					} else if(m.type == 'Service Locations') {
						image = SERVICE_IMAGE;
					}

					myLatlng = new google.maps.LatLng(m.locationlatitude, m.locationlongitude);
					mapCentre_two = myLatlng;

					map_two.setCenter(mapCentre);

					var marker = new google.maps.Marker({
						position: myLatlng,
						map: map_two,
						icon: image
					});

					var markerDetails = '<div class="noscrollbar"><table width="200" cellspacing="0" cellpadding="0">' +
					'  <tr><td width="451" style="border:1px solid #f1f1f1; padding:10px;">Location: <b>' + m.locationname + '</b></td></tr>' +
					' <tr><td valign="top" style="color:#9c9b9b;  padding:10px 0px 5px 0px;"><b>Address:</b> ' + m.locationphysicaladdress + ' </td></tr>' +
					'<tr><td style="color: #9c9b9b;  padding:0px 0px 5px 0px;"><b>Email:</b> ' + m.locationemailaddress + '</td></tr>' +
					'<tr><td style="color: #9c9b9b;  padding:0px 0px 5px 0px;"><b>Weekday Open Hours:</b> ' + m.locationweekdayopeninghours + ' - '+m.locationweekdayclosinghours+'</td></tr>' +
					'<tr><td style="color: #9c9b9b;  padding:0px 0px 5px 0px;"><b>Weekend Opening Hours:</b> ' + m.locationweekendopeninghours + ' - '+m.locationweekendclosinghours+'</td></tr>' +
					' </table></div>';

					marker.info = new google.maps.InfoWindow({content: markerDetails, maxWidth: 800,buttons:{close:{show:4}}});
					google.maps.event.addListener(marker, 'click', function() {
						marker.info.open(map_two, marker);
					});

					map_markers_two.push(marker);
					myLatLngArry_two.push(myLatlng);

					loopCount++;
				});

				if (map_markers_two.length > 0) {
					for (var i = 0; i <= myLatLngArry_two.length - 1; i++) {
						latlngbounds_two.extend(myLatLngArry_two[i]);
					}

					map_two.fitBounds(latlngbounds_two);
				}

				if (markerClusterer_two) {
				  markerClusterer_two.clearMarkers();
				}

				markerClusterer_two = new MarkerClusterer(map_two, map_markers_two);
			}
		}

		google.maps.event.trigger(map_two, 'resize');
		map_two.setCenter(latlngbounds_two.getCenter());
		map_two.setZoom(6);
	});
}

function panTo(lat, long, elem){
	if(DEVICE == 'desktop'){
		$('.location-row').removeClass('active');
		$(elem).addClass('active');

		var position = new google.maps.LatLng(parseFloat(lat), parseFloat(long));
		map.panTo(position);
		map.setCenter(position);
		map.setZoom(20);

		if(typeof map_markers !== 'undefined' && $.isArray(map_markers)){
			var closestMarker = null;
			var mapCenter = map.getCenter();

			$.each(map_markers, function(index, elem){
				var latitude = elem.position.lat();
				var longitude = elem.position.lng();

				if(parseFloat(latitude) === parseFloat(mapCenter.lat()) && parseFloat(longitude) === parseFloat(mapCenter.lng())){
					closestMarker = elem;
				}
			});

			if(typeof closestMarker !== 'undefined'){
				google.maps.event.trigger(closestMarker, 'click', {
					latLng: position
				});
			}
		}
	}else{
		var url = 'https://www.google.com/maps/place//@'+parseFloat(lat)+','+parseFloat(long)+',15z/data=!3m1!4b1!4m2!3m1!1s0x0:0x0';
		var win = window.open(url, '_blank');
  		win.focus();
	}
}
