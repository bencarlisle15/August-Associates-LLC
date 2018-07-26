document.addEventListener('DOMContentLoaded', beginFunctions());

//when the user scrolls to the bottom while in grid mode
var pageNumber = 0;
window.onscroll = function(ev) {
	if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight && document.getElementById("mapGridSwitch").value == "grid") {
		//gets the next set of houses
		initAllHomes(++pageNumber);
	}
};

function beginFunctions() {
	//all currency input
	var vals = ["searchMinPrice","searchMaxPrice"];
	for (var i in vals) {
		document.getElementById(vals[i]).addEventListener("keyup", function() {
			this.value = formatCurrency(this.value);
		});
	}
}

//edits search bar info
(function editSettings() {
	var url = window.location.href;
	//checks for params
	if (url.indexOf("?") >= 0) {
		var queryUrl = url.substring(url.indexOf("?") + 1).replace("-", " ");
		var queries = queryUrl.split("&");
		//splits into key and params and updates the search bar
		for (var i = 0; i < queries.length; i++) {
			var key = queries[i].substring(0, queries[i].indexOf("="));
			var val = queries[i].substring(queries[i].indexOf("=") + 1);
			if (key == "searchMinPrice" || key == "searchMaxPrice") {
				val = formatter.format(val);
			} else if (key == "map" && val =="true") {
				switchView();
			} else if (key == "sortby") {
				document.getElementById("sortArray").value = val;
			} else if (document.getElementById(key)) {
				document.getElementById(key).value = removePluses(val);
			}
		}
	}
})();

//automatically updates currency input
function formatCurrency(oldVal) {
	var num = oldVal.replace(/(,)/g, '');
	var val = num.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	if (val.slice(0,1)!='$' && val != '') {
		val = '$'+ val;
	}
	return val;
}

//styles currency
var formatter = new Intl.NumberFormat('en-US', {
	style: 'currency',
	currency: 'USD',
});

function resetSearch() {
	window.location.href = "/find-homes";
}

function searchArea() {
	var radius = 156543.03392 * Math.cos(map.getCenter().lat() * Math.PI / 180) / Math.pow(2, map.getZoom());
	var extra = "radius=" + radius + "&lat=" + map.getCenter().lat() + "&lng=" + map.getCenter().lng() + "&map=true";
	var url = buildUrl();
	url += url.length > 0 ? "&" : "?";
	window.location.href = "/find-homes" + url + extra;
}

function sortArray() {
	var val = document.getElementById("sortArray").value;
	var url = buildUrl();
	url += url.length > 0 ? "&" : "?";
	window.location.href = "/find-homes" + url + "sortby=" + val;
}

function removePluses(str) {
	return str.split('+').join(' ');
}

function getProperties() {
	window.location.href = "/find-homes"+buildUrl();
}

function buildUrl() {
	var inputs = document.querySelectorAll("#searchAddresses, #searchCities, #searchZips, #searchPropertyType, #searchMinPrice, #searchMaxPrice, #searchMinFeet, #searchMaxFeet, #searchBeds, #searchBaths");
	var urlAdd = "";
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].value != '') {
			var val = inputs[i].value;
			if (inputs[i].id == "searchMinPrice" || inputs[i].id == "searchMaxPrice") {
				val = val.replace(/(,)/g, '').substr(1);
			}
			urlAdd += (urlAdd.length > 0 ? "&" : "?") + inputs[i].id + "=" + addPluses(val);
		}
	}
	return urlAdd;
}

function addPluses(str) {
	return str.split(' ').join('+');
}

//array of all google map markers REQUIERD
var markerArray = []
var map;
function initMap(res) {
	var mapElement = document.getElementById("map");
	map = new google.maps.Map(mapElement, {
		center: {lat: 41.780856, lng: -71.440161},
		zoom: 7
	});
	mapElement.style.width =  "100%";
	mapElement.style.height =  document.body.clientWidth/2 + "px";
	//sets houses and markers
	setMapHouses(res);
}

//removes all markers
function removeAllMarkers() {
	for (var i = 0; i < markerArray.length; i++) {
		markerArray[i].setMap(null);
	}
	markerArray = [];
}
//location boundaries
var locationPos = {latMax: 0, latMin: 0, lngMax: 0, lngMin: 0};
function setMapHouses(res) {
	//gets the max and min of the lat and lng of the markers in order to frame them
	res.forEach(function(resHouse) {
		//get last and lng from house
		var lat = resHouse.Latitude;
		var lng = resHouse.Longitude;
		//geocding errors are entirely possible
		if (lat == null || lng == null) {
			return;
		}
		//creates new marker
		var marker = new google.maps.Marker({
			map: map,
			//cannot have same zIndex some zIndex is created by id
			//why does I have resHouse.MLSNumber/1 you ask? because for some reason using just resHouse.MLSNumber draws an error  ¯\_(ツ)_/¯
			zIndex: resHouse.MLSNumber/1,
			icon: {
				url: "/images/marker.png",
				scaledSize: new google.maps.Size(75,50),
				labelOrigin: new google.maps.Point(37.5, 18)
			},
			//positioned to coordinates
			position: {lat: lat, lng: lng},
			//sets bubble text;
			label: { color: 'black', fontSize: '16px', fontFamily: "Open Sans", text: roundToLetter(resHouse.ListPrice)}
		});
		//when a marker is clicked
		marker.addListener('click', function() {
			//checks if the map is centered on the marker already and is zoomed in significantly
			if (map.getZoom() >= 14 && Math.abs(map.getCenter().lat() - this.getPosition().lat()) < 0.0000000000001 && Math.abs(map.getCenter().lng() - this.getPosition().lng()) < 0.0000000000001) {
				showOverlay(resHouse)
			} else {
				//moves to the marker and somes to it
				map.panTo(this.getPosition());
				if (map.getZoom() < 14) {
					map.setZoom(14);
				}

			}
		});
		//updates frame
		if (locationPos['latMin'] == 0 || lat < locationPos['latMin']) {
			locationPos['latMin'] = lat;
		}
		if (locationPos['latMax'] == 0 || lat > locationPos['latMax']) {
			locationPos['latMax'] = lat;
		}
		if (locationPos['lngMin'] == 0 || lng < locationPos['lngMin']) {
			locationPos['lngMin'] = lng;
		}
		if (locationPos['lngMax'] == 0 || lng > locationPos['lngMax']) {
			locationPos['lngMax'] = lng;
		}
		//adds marker to the array
		markerArray.push(marker);
	});
	//sets center and zoom from frame
	map.setCenter(new google.maps.LatLng(
		((locationPos['latMax'] + locationPos['latMin']) / 2.0),
		((locationPos['lngMax'] + locationPos['lngMin']) / 2.0)
	));
	if (window.location.href.includes("radius")) {
		var url = window.location.href;
		map.setZoom(Math.log2(156543.03392 * Math.cos(map.getCenter().lat() * Math.PI / 180)/(parseInt(url.substring(url.indexOf("radius=") + 7, url.indexOf("&", url.indexOf("radius=")))))));
	} else if (map.getZoom() < 8) {
		map.setZoom(8)
	}
}

//Adds K and M to create the price
function roundToLetter(num) {
	if (num > 950000) {
		return String(Math.round(num / 1000000)) + "M";
	}
	return String(Math.round(num / 1000)) + "K"
}

//Adds the clicked house to an overlay
function showOverlay(res) {
	var house = document.createElement("div");
	var houseImageWrapper = document.createElement("div");
	var houseImage = document.createElement("img");
	var houseInfo = document.createElement("div");
	var price = document.createElement("h4");
	var address = document.createElement("p");
	var city = document.createElement("p");
	var sqft = document.createElement("p");
	house.classList.add("house");
	house.setAttribute("onclick", "openHouse(" + res.MLSNumber + ")");
	house.id = "mapHouse";
	houseImageWrapper.classList.add('houseImageWrapper');
	houseImageWrapper.append(houseImage);
	houseImage.classList.add("houseElement");
	houseImage.classList.add("houseImage");
	houseImage.alt = "Picture of House";
	houseImage.src = "images/rets/" + res.MLSNumber + "/0.jpg";
	houseInfo.classList.add("houseInformation");
	price.classList.add("houseElement");
	price.align = "right";
	price.innerHTML = formatter.format(res.ListPrice);
	address.classList.add("houseElement");
	address.innerHTML = res.FullStreetNum.toProperCase();
	city.classList.add("houseElement");
	city.innerHTML = res.City.toProperCase();
	sqft.classList.add("houseElement");
	sqft.innerHTML = parseInt(res.SqFtTotal ? res.SqFtTotal : res.ApproxLotSquareFoot) + " Square Feet";
	houseInfo.append(price);
	houseInfo.append(address);
	houseInfo.append(city);
	houseInfo.append(sqft);
	house.append(houseImageWrapper);
	house.append(houseInfo);
	document.getElementById("mapHouseWrapper").append(house);
	document.getElementById("mapHouseWrapper").style.display = "block";
}

function removeHouseOverlay() {
	document.getElementById("mapHouseWrapper").style.display = "none";
}

function switchView() {
	//swtich from map to grid view
	var mapGridSwitch = document.getElementById("mapGridSwitch");
	if (mapGridSwitch.value =="grid") {
		mapGridSwitch.value = "map";
		mapGridSwitch.innerHTML = "Switch to Grid View";
		document.getElementById("houses").style.display = "none";
		document.getElementById("loadingHomes").style.display = "none";
		document.getElementById("sortArray").style.display = "none";
		document.getElementById("searchThisArea").style.display = "block";
		document.getElementById("map").style.display = "block";
	} else {
		mapGridSwitch.value = "grid";
		mapGridSwitch.innerHTML = "Switch to Map View";
		document.getElementById("map").style.display = "none";
		document.getElementById("searchThisArea").style.display = "none";
		document.getElementById("loadingHomes").style.display = "block";
		document.getElementById("sortArray").style.display = "block";
		document.getElementById("houses").style.display = "flex";
	}
}

//checks the values of the search in order to generate a query
function getQuery() {
	var query = "";
	if (document.getElementById("searchPropertyType").value != "") {
		query += "&PropertyType=" + document.getElementById("searchPropertyType").value;
	}
	if (document.getElementById("searchMinPrice").value != "") {
		query += "&ListPrice=" + document.getElementById("searchMinPrice").value.replace(/(,)/g, '').substr(1) + ">";
	}
	if (document.getElementById("searchMaxPrice").value != "") {
		var key = "&ListPrice=";
		if (query.includes(key)) {
			key = "&ListPrice2=";
		}
		query += key + document.getElementById("searchMaxPrice").value.replace(/(,)/g, '').substr(1) + "<";
	}

	if (document.getElementById("searchMinFeet").value != "") {
		query += "&SqFtTotal=" + document.getElementById("searchMinFeet").value + ">";
	}

	if (document.getElementById("searchMaxFeet").value != "") {
		query += "&SqFtTotal=" + document.getElementById("searchMinFeet").value + "<";
	}

	if (document.getElementById("searchBeds").value != "") {
		query += "&BedsTotal=" + document.getElementById("searchBeds").value + ">";
	}

	if (document.getElementById("searchBaths").value != "") {
		query += "&BathsTotal=" + document.getElementById("searchBaths").value + ">";
	}

	if (document.getElementById("searchAddresses").value != "") {
		query += "&FullStreetNum=" + document.getElementById("searchAddresses").value;
	}

	if (document.getElementById("searchCities").value != "") {
		query += "&City=" + document.getElementById("searchCities").value;
	}

	if (document.getElementById("searchZips").value != "") {
		query += "&PostalCode=" + document.getElementById("searchZips").value;
	}
	return query.length == 0 ? "" : query.substring(1);
}

//if a grid house is clicked
function openHouse(id) {
	window.location.href = "/find-your-home?id="+id;
}
