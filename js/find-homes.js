//when the user scrolls to the bottom while in grid mode
var pageNumber = 0;
window.onscroll = function(ev) {
	if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight && document.getElementById("mapGridSwitch").value == "grid") {
		//gets the next set of houses
		initAllHomes(++pageNumber);
	}
};

//styles currency
var formatter = new Intl.NumberFormat('en-US', {
	style: 'currency',
	currency: 'USD',
});

//get info from url
editSettings();
//initialize all houses
initAllHomes(0);

//if for some reason it doesn't load automatically
function loadMoreHomes() {
	initAllHomes(++pageNumber);
}

function editSettings() {
	var url = window.location.href;
	//checks for params
	if (url.indexOf("?") >= 0) {
		var queryUrl = url.substring(url.indexOf("?") + 1).replace("-", " ");
		var queries = queryUrl.split("&");
		//splits into key and params and updates the search bar
		for (var i = 0; i < queries.length; i++) {
			var key = queries[i].substring(0, queries[i].indexOf("="));
			var val = queries[i].substring(queries[i].indexOf("=") + 1);
			document.getElementById(key).value = val;
		}
	}
}

//get properties based off of new query
function getProperties() {
	//recusrively removes all children; theres probably a better solution but this one is quick enough and sufficient
	removeChildren(document.getElementById("houses"));
	function removeChildren(node) {
		while (node.firstChild) {
			removeChildren(node.firstChild);
			node.removeChild(node.firstChild);
		}
	};
	//remove the map markers
	removeAllMarkers();
	initAllHomes(0);
}

function initAllHomes(pageNumber) {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/getAllRets.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function () {
		if (this.readyState == 4) {
			if (!this.responseText) {
				//there was an error but the user doesn't need to know that
				document.getElementById("loadingHomes").innerHTML = 'No Houses Found';
			} else {
				res = JSON.parse(JSON.parse(this.responseText));
				if (!res || !res.length) {
					//either error or query too specific
					document.getElementById("loadingHomes").innerHTML = 'No Houses Found';
				} else {
					document.getElementById("loadingHomes").innerHTML = 'Loading More Homes...';
					//set houses with grid and then init map if its the first time
					setGridHouses(res);
					if (!pageNumber) {
						initMap(res);
					} else {
						setMapHouses(res);
					}
				}
			}
		}
	}
	//add params from searchbox so the php can sort it
	var query = getQuery();
	xhr.send("pageNumber=" + pageNumber + (query.length > 0 ? ("&" + query) : ""));
}

function setGridHouses(res) {
	for(var i=0; i < res.length; i++) {
		//creates new house
		document.getElementById("houses").append(createHouse(res[i]));
	}
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
	mapElement.style.width =  document.body.clientWidth + "px";
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

function setMapHouses(res) {
	//gets the max and min of the lat and lng of the markers in order to frame them
	var location = {latMax: 0, latMin: 0, lngMax: 0, lngMin: 0};
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
		if (location['latMin'] == 0 || lat < location['latMin']) {
			location['latMin'] = lat;
		}
		if (location['latMax'] == 0 || lat > location['latMax']) {
			location['latMax'] = lat;
		}
		if (location['lngMin'] == 0 || lng < location['lngMin']) {
			location['lngMin'] = lng;
		}
		if (location['lngMax'] == 0 || lng > location['lngMax']) {
			location['lngMax'] = lng;
		}
		//adds marker to the array
		markerArray.push(marker);
	});
	//sets center and zoom from frame
	map.setCenter(new google.maps.LatLng(
		((location['latMax'] + location['latMin']) / 2.0),
		((location['lngMax'] + location['lngMin']) / 2.0)
	));
	if (map.getZoom() < 8) {
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

//Creates house with html elements
function createHouse(resToUse) {
	var house = document.createElement("div");
	var houseImage = document.createElement("img");
	var houseInfo = document.createElement("div");
	var price = document.createElement("h4");
	var address = document.createElement("p");
	var city = document.createElement("p");
	var sqft = document.createElement("p");
	house.classList.add("house");
	house.setAttribute("onclick", "openHouse(" + resToUse.MLSNumber + ")");
	houseImage.classList.add("houseElement");
	houseImage.classList.add("houseImage");
	houseImage.style.width = "300px";
	houseImage.alt = "Picture of House";
	houseImage.src = "images/rets/" + resToUse.MLSNumber + "/0.jpg";
	houseInfo.classList.add("houseInformation");
	price.classList.add("houseElement");
	price.align = "right";
	price.innerHTML = formatter.format(resToUse.ListPrice);
	address.classList.add("houseElement");
	address.innerHTML = resToUse.FullStreetNum.toProperCase();
	city.classList.add("houseElement");
	city.innerHTML = resToUse.City.toProperCase();
	sqft.classList.add("houseElement");
	sqft.innerHTML = parseInt(resToUse.SqFtTotal ? resToUse.SqFtTotal : resToUse.ApproxLotSquareFoot) + " Square Feet";
	houseInfo.append(price);
	houseInfo.append(address);
	houseInfo.append(city);
	houseInfo.append(sqft);
	house.append(houseImage);
	house.append(houseInfo);
	return house;
}

//Adds the clicked house to an overlay
function showOverlay(res) {
	var house = createHouse(res);
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
		document.getElementById("loadingHomes").style.display = "none";
		document.getElementById("map").style.display = "block";
	} else {
		mapGridSwitch.value = "grid";
		mapGridSwitch.innerHTML = "Switch to Map View";
		document.getElementById("map").style.display = "none";
		document.getElementById("loadingHomes").style.display = "block";
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
		query += "&ListPrice=" + document.getElementById("searchMinPrice").value + ">";
	}

	if (document.getElementById("searchMaxPrice").value != "") {
		query += "&ListPrice=" + document.getElementById("searchMaxPrice").value + "<";
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
