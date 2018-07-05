var res;

var formatter = new Intl.NumberFormat('en-US', {
	style: 'currency',
	currency: 'USD',
});

// $.ajax({
// 	url: "https://api.simplyrets.com/properties",
// 	type: 'GET',
// 	dataType: 'json',
// 	beforeSend: function(xhr) {
// 		auth = "c2ltcGx5cmV0czpzaW1wbHlyZXRz";
// 		xhr.setRequestHeader("Authorization", "Basic  " + auth);
// 	},
// 	success: function(r) {
// 		res = r;
// 		editSettings();
// 		setGridHouses();
// 		initMap();
// 	}
// });
$.ajax({
	url:'phpRequests/getRets.php',
	complete: function (r) {
		res = JSON.parse(r.responseJSON);
		editSettings();
		setGridHouses();
		initMap();
	}
});

function editSettings() {
	var url = window.location.href;
	if (url.indexOf("?") >= 0) {
		var queryUrl = url.substring(url.indexOf("?") + 1).replace("-", " ");
		var queries = queryUrl.split("&")
		for (var i = 0; i < queries.length; i++) {
			var key = queries[i].substring(0, queries[i].indexOf("="));
			var val = queries[i].substring(queries[i].indexOf("=") + 1);
			$("#" + key).val(val);
		}
	}
}

function getProperties() {
	if ($("#mapGridSwitch").val() == "grid") {
		setGridHouses();
	} else {
		setMapHouses()
	}
}

function setGridHouses() {
	$("#houses").empty();
	for(var i=0; i < res.length; i++) {
		if (invalidHouse(res[i])) {
			continue;
		}
		var id = res[i].mlsId;
		var houseId = "#" + id;
		createHouse(id, i);
	}
}

var markers = {};
var idLookup = {};
var map;
var markerArray = []

function initMap(address) {
	map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: -34.397, lng: 150.644},
		zoom: 7
	});
	$("#map").width("100%")
	$("#map").height($("#map").width()/2);
	setMapHouses();
}

function removeAllMarkers() {
	for (var i = 0; i < markerArray.length; i++) {
		markerArray[i].setMap(null);
	}
	markerArray = [];
	markers = {};
}

function setMapHouses() {
	var marker;
	var latMax=0;
	var latMin=0;
	var longMax=0;
	var longMin=0;
	removeAllMarkers();
	for(var i=0; i < res.length; i++) {
		if (invalidHouse(res[i])) {
			continue;
		}
		var address = res[i].address.streetNumberText + " " + res[i].address.streetName + ", " + res[i].address.city + ", " + res[i].address.state + ", " + res[i].address.postalCode;
		var id = res[i].mlsId;
		idLookup[id] = i;
		marker = new google.maps.Marker({
			map: map,
			icon: {
				url: "/images/marker.png",
				scaledSize: new google.maps.Size(75,50),
				labelOrigin: new google.maps.Point(37.5, 18)
			},
			position: {lat: res[i].geo.lat, lng: res[i].geo.lng},
			label: { color: 'black', fontSize: '16px', fontFamily: "open sans", text: ''}
		});
		marker.addListener('click', function() {
			if (map.getZoom() >= 14 && Math.abs(map.getCenter().lat() - this.getPosition().lat()) < 0.0000000000001 && Math.abs(map.getCenter().lng() - this.getPosition().lng()) < 0.0000000000001) {
				showOverlay(this)
			} else {
				map.panTo(this.getPosition());
				if (map.getZoom() < 14) {
					map.setZoom(14);
				}

			}
		});
		if (latMin == 0 || res[i].geo.lat < latMin) {
			latMin = res[i].geo.lat;
		}
		if (latMax == 0 || res[i].geo.lat > latMax) {
			latMax = res[i].geo.lat;
		}
		if (longMin == 0 || res[i].geo.lng < longMin) {
			longMin = res[i].geo.lng;
		}
		if (longMax == 0 || res[i].geo.lng > longMax) {
			longMax = res[i].geo.lng;
		}
		markers[marker] = id;
		markerArray.push(marker);
		marker.getLabel().text = roundToLetter(res[idLookup[id]].listPrice);
	}

		map.setCenter(new google.maps.LatLng(
		((latMax + latMin) / 2.0),
		((longMax + longMin) / 2.0)
	));
	if (map.getZoom() < 8) {
		map.setZoom(8)
	}
}

function roundToLetter(num) {
	if (num > 1000000) {
		return String(Math.round(num / 10000)/100) + "M";
	}
	return String(Math.round(num / 100000)) + "K"
}

function createHouse(id, i) {
	$("#houses").append("<div class='house' onclick='openHouse(" + id + ")'><img class='houseElement houseImage' width='300px' alt='Picture of House' src='" + res[i].photos[0] + "'><div class='houseInformation'><h4 align='right' class='houseElement'>" + formatter.format(res[i].listPrice) + "</h4><p class='houseElement'>" + res[i].address.streetNumberText + " " + res[i].address.streetName + "</p><p class='houseElement'>" + res[i].address.city + "</p><p class='houseElement'><b>" + res[i].property.bedrooms + " beds, " + res[i].property.bathsHalf + " bathroom" + (res[i].property.bathsHalf != 1 ? 's':'') + "</b></p></div></div>");
}

function showOverlay(marker) {
	var id = markers[marker];
	var i = idLookup[id];
	$("#mapHouseWrapper").append("<div id='mapHouse' onclick='openHouse(" + id + ")'><img class='houseElement houseImage' width='300px' alt='Picture of House' src='" + res[i].photos[0] + "'><div class='houseInformation'><h4 align='right' class='houseElement'>" + formatter.format(res[i].listPrice) + "</h4><p class='houseElement'>" + res[i].address.streetNumberText + " " + res[i].address.streetName + "</p><p class='houseElement'>" + res[i].address.city + "</p><p class='houseElement'><b>" + res[i].property.bedrooms + " beds, " + res[i].property.bathsHalf + " bathroom" + (res[i].property.bathsHalf != 1 ? 's':'') + "</b></p></div></div>");
	$("#mapHouseWrapper").css("display","block");
}

function removeHouseOverlay() {
	$("#mapHouseWrapper").css("display","none");
}

function switchView() {
	if ($("#mapGridSwitch").val() =="grid") {
		$("#mapGridSwitch").val("map")
		$("#mapGridSwitch").html("Switch to Grid View")
		$("#houses").css("display", "none");
		$("#map").css("display", "block");

	} else {
		$("#mapGridSwitch").val("grid");
		$("#mapGridSwitch").html("Switch to Map View");
		$("#map").css("display", "none");
		$("#houses").css("display", "flex");
	}
}

function emptyForm() {
	var ids = ["searchAddresses", "searchCities", "searchZips", "searchPropertyType", "searchMinPrice", "searchMaxPrice", "searchBeds", "searchBaths", "searchMinFeet", "searchMaxFeet"]
	for (id in ids) {
		if ($("#" + ids[id]).val() != '' && $("#" + ids[id]).val() != null) {
			return false;
		}
	}
	return true;
}

function invalidHouse(res) {
	var ids = {"searchPropertyType": "type", "searchMinPrice": "minprice", "searchMaxPrice": "maxprice", "searchMinFeet": "minarea", "searchMaxFeet": "maxarea", "searchBaths": "minbaths", "searchBeds": "minbeds"}

	if ($("#searchPropertyType").val() != "") {
		if ($("#searchPropertyType").val().toLowerCase != res.property.type) {
			return true;
		}
	}

	if ($("#searchMinPrice").val() != "") {
		if (parseInt($("#searchMinPrice").val()) > res.listingPrice) {
			return true;
		}
	}

	if ($("#searchMaxPrice").val() != "") {
		if (parseInt($("#searchMaxPrice").val()) < res.listingPrice) {
			return true;
		}
	}

	if ($("#searchMinFeet").val() != "") {
		if (parseInt($("#searchMinFeet").val()) > res.property.area) {
			return true;
		}
	}

	if ($("#searchMaxFeet").val() != "") {
		if (parseInt($("#searchMaxFeet").val()) < res.property.area) {
			return true;
		}
	}

	if ($("#searchBeds").val() != "") {
		if (parseInt($("#searchBeds").val()) > res.property.bedrooms) {
			return true;
		}
	}

	if ($("#searchBaths").val() != "") {
		if (parseInt($("#searchBaths").val()) > res.property.bathsHalf) {
			return true;
		}
	}

	if ($("#searchAddresses").val() != "") {
		if (!$("#searchAddresses").val().toLowerCase().includes(res.address.streetNumberText + " " + res.address.streetName.toLowerCase())) {
			return true;
		}
	}

	if ($("#searchCities").val() != "") {
		if (!$("#searchCities").val().toLowerCase().includes(res.address.city.toLowerCase())) {
			return true;
		}
	}

	if ($("#searchZips").val() != "") {
		if (!$("#searchZips").val().includes(res.address.postalCode)) {
			return true;
		}
	}
	return false;
}

function openHouse(id) {
	window.location.href = "/find-your-home?id="+id;
}
