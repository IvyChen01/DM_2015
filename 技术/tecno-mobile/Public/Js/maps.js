var markerClusterer = null;

var map_markers = [];
var markerClusterer = null;
var mapCentre = null;

var latlngbounds = null;

$(window).load(function(){
	var countryCenter = new google.maps.LatLng(COUNTRY_LATITUDE, COUNTRY_LONGITUDE);
	var mapOptions = {
		zoom: 6,
		center: countryCenter
	};

	map = new google.maps.Map(document.getElementById('stories_location'), mapOptions);

	var url = BASE_URL_SITE+"loadmap.php?type=1&lang="+CURRENT_LANGUAGE;
	LoadGoogleMap(url);

	$("#select_opening_hours").change(function(){
		var openingHours = $(this).val();
		var town = $("#select_town").val();
		if(typeof openingHours !== 'undefined'){
			openingHours = typeof openingHours !== 'undefined' ? openingHours : "";
			var url = BASE_URL_SITE+"/loadmap.php?c="+COUNTRY_NAME+"&oh="+openingHours;
			LoadGoogleMap(url);
		}
	});

	$("#select_town").change(function(){
		var openingHours = $("#select_opening_hours").val();
		var town = $(this).val();
		if(typeof town !== 'undefined'){
			var townname = $("#select_town option:selected").text();
			$(".town_filter").empty().html('Near '+townname);
			openingHours = typeof openingHours !== 'undefined' ? openingHours : "";

			var url = BASE_URL_SITE+"/loadmap.php?c="+COUNTRY_NAME+"&oh="+openingHours+"&t="+town;
			LoadGoogleMap(url);
		}
	});

	$("#location_search_txt").keyup(function(){
		var filter = $(this).val();
		$(".location_title").each(function () {
			if ($(this).text().search(new RegExp(filter, "i")) < 0) {
				$(this).parent().hide();
			} else {
				$(this).parent().show()
			}
		});
	});
});

function LoadGoogleMap(url) {
	map_markers = [];

	latlngbounds = new google.maps.LatLngBounds();
	google.maps.Map.prototype.clearOverlays = function() {
		if (map_markers) {
			for (var i = 0; i < map_markers.length; i++) {
				map_markers[i].setMap(null);
			}
		}
	}

	google.maps.event.addListener(map, 'zoom_changed', function() {
		var opt = {minZoom: 6, maxZoom: 20};
		map.setOptions(opt);
	});

	var myLatLngArry = [];
	map.clearOverlays();

	var lat = "";
	var long = "";
	var myLatlng = "";

	$.ajax({
		url: url,
        cache: false,
		beforeSend: function(){

		}
	}).success(function(data){
		$(".ajax-preloader").delay(1000).fadeOut("slow");

		var data = $.parseJSON(data);

		var loop = 0;
		var myLatLngArry = [];
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
					mapCentre = myLatlng;

					map.setCenter(mapCentre);

					var marker = new google.maps.Marker({
						position: myLatlng,
						map: map,
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
						marker.info.open(map, marker);
					});

					map_markers.push(marker);
					myLatLngArry.push(myLatlng);

					loopCount++;
				});

				if (map_markers.length > 0) {
					for (var i = 0; i <= myLatLngArry.length - 1; i++) {
						latlngbounds.extend(myLatLngArry[i]);
					}

					map.fitBounds(latlngbounds);
				}

				if (markerClusterer) {
				  markerClusterer.clearMarkers();
				}

				markerClusterer = new MarkerClusterer(map, map_markers);
			}
		}

		google.maps.event.trigger(map, 'resize');
		map.setCenter(latlngbounds.getCenter());
		map.setZoom(6);
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
