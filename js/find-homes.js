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
var xhr = new XMLHttpRequest();
xhr.open("POST", '/phpRequests/getRets.php', true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xhr.onreadystatechange = function () {
	if (this.readyState == 4) {
		res = JSON.parse(JSON.parse(this.responseText));
		editSettings();
		setGridHouses();
		initMap();
	}
}
xhr.send();

function editSettings() {
	var url = window.location.href;
	if (url.indexOf("?") >= 0) {
		var queryUrl = url.substring(url.indexOf("?") + 1).replace("-", " ");
		var queries = queryUrl.split("&")
		for (var i = 0; i < queries.length; i++) {
			var key = queries[i].substring(0, queries[i].indexOf("="));
			var val = queries[i].substring(queries[i].indexOf("=") + 1);
			document.getElementById(key).value = val;
		}
	}
}

function getProperties() {
	if (document.getElementById("mapGridSwitch").value == "grid") {
		setGridHouses();
	} else {
		setMapHouses()
	}
}

function setGridHouses() {
	var node = document.getElementById("houses");
	for (var child = node.firstChild; child; child = node.firstChild) {
		node.removeChild(child);
	}
	for(var i=0; i < res.length; i++) {
		if (invalidHouse(res[i])) {
			continue;
		}
		var id = res[i].mlsId;
		var houseId = id;
		document.getElementById("houses").append(createHouse(id, i));
	}
}

var markers = {};
var idLookup = {};
var map;
var markerArray = []

function initMap(address) {
	var mapElement = document.getElementById("map");
	map = new google.maps.Map(mapElement, {
		center: {lat: -34.397, lng: 150.644},
		zoom: 7
	});
	mapElement.style.width =  document.body.clientWidth + "px";
	mapElement.style.height =  document.body.clientWidth/2 + "px";
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
	var house = document.createElement("div");
	var houseImage = document.createElement("img");
	var houseInfo = document.createElement("div");
	var price = document.createElement("h4");
	var address = document.createElement("p");
	var city = document.createElement("p");
	var bb = document.createElement("p");
	house.classList.add("house");
	house.setAttribute("onclick", "openHouse(" + id + ")");
	houseImage.classList.add("houseElement");
	houseImage.classList.add("houseImage");
	houseImage.style.width = "300px";
	houseImage.alt = "Picture of House";
	houseImage.src = res[i].photos[0];
	houseInfo.classList.add("houseInformation");
	price.classList.add("houseElement");
	price.align = "right";
	price.innerHTML = formatter.format(res[i].listPrice);
	address.classList.add("houseElement");
	address.innerHTML = res[i].address.streetNumberText + " " + res[i].address.streetName;
	city.classList.add("houseElement");
	city.innerHTML = res[i].address.city;
	bb.classList.add("houseElement");
	bb.innerHTML = res[i].property.bedrooms + " beds, " + res[i].property.bathsHalf + " bathroom" + (res[i].property.bathsHalf != 1 ? 's':'');
	houseInfo.append(price);
	houseInfo.append(address);
	houseInfo.append(city);
	houseInfo.append(bb);
	house.append(houseImage);
	house.append(houseInfo);
	return house;
}

function showOverlay(marker) {
	var id = markers[marker];
	var i = idLookup[id];
	var house = createHouse(id, i);
	house.id = "mapHouse";
	document.getElementById("mapHouseWrapper").append(house);
	document.getElementById("mapHouseWrapper").style.display = "block";
}

function removeHouseOverlay() {
	document.getElementById("mapHouseWrapper").style.display = "none";
}

function switchView() {
	var mapGridSwitch = document.getElementById("mapGridSwitch");
	if (mapGridSwitch.value =="grid") {
		mapGridSwitch.value = "map";
		mapGridSwitch.innerHTML = "Switch to Grid View";
		document.getElementById("houses").style.display = "none";
		document.getElementById("map").style.display = "block";

	} else {
		mapGridSwitch.value = "grid";
		mapGridSwitch.innerHTML = "Switch to Map View";
		document.getElementById("map").style.display = "none";
		document.getElementById("houses").style.display = "flex";
	}
}

function emptyForm() {
	var ids = ["searchAddresses", "searchCities", "searchZips", "searchPropertyType", "searchMinPrice", "searchMaxPrice", "searchBeds", "searchBaths", "searchMinFeet", "searchMaxFeet"];
	for (id in ids) {
		if (document.getElementById(ids[id]).value != '' && document.getElementById(ids[id]).value != null) {
			return false;
		}
	}
	return true;
}

function invalidHouse(res) {
	if (document.getElementById("searchPropertyType").value != "") {
		if (document.getElementById("searchPropertyType").value != res.property.type) {
			return true;
		}
	}
	if (document.getElementById("searchMinPrice").value != "") {
		if (parseInt(document.getElementById("searchMinPrice").value) > res.listPrice) {
			return true;
		}
	}

	if (document.getElementById("searchMaxPrice").value != "") {
		if (parseInt(document.getElementById("searchMaxPrice").value) < res.listPrice) {
			return true;
		}
	}

	if (document.getElementById("searchMinFeet").value != "") {
		if (parseInt(document.getElementById("searchMinFeet").value) > res.property.area) {
			return true;
		}
	}

	if (document.getElementById("searchMaxFeet").value != "") {
		if (parseInt(document.getElementById("searchMaxFeet").value) < res.property.area) {
			return true;
		}
	}

	if (document.getElementById("searchBeds").value != "") {
		if (parseInt(document.getElementById("searchBeds").value) > res.property.bedrooms) {
			return true;
		}
	}

	if (document.getElementById("searchBaths").value != "") {
		if (parseInt(document.getElementById("searchBaths").value) > res.property.bathsHalf) {
			return true;
		}
	}

	if (document.getElementById("searchAddresses").value != "") {
		if (!document.getElementById("searchAddresses").value.toLowerCase().includes(res.address.streetNumberText + " " + res.address.streetName.toLowerCase())) {
			return true;
		}
	}

	if (document.getElementById("searchCities").value != "") {
		if (!document.getElementById("searchCities").value.toLowerCase().includes(res.address.city.toLowerCase())) {
			return true;
		}
	}

	if (document.getElementById("searchZips").value != "") {
		if (!document.getElementById("searchZips").value.includes(res.address.postalCode)) {
			return true;
		}
	}
	return false;
}

function openHouse(id) {
	window.location.href = "/find-your-home?id="+id;
}
