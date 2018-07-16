window.onscroll = function(ev) {
	if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight && document.getElementById("mapGridSwitch").value == "grid") {
		initAllHomes(++pageNumber);
	}
};

var formatter = new Intl.NumberFormat('en-US', {
	style: 'currency',
	currency: 'USD',
});

var pageNumber = 0;
editSettings();
initAllHomes(0);

function loadMoreHomes() {
	initAllHomes(++pageNumber);
}

function editSettings() {
	var url = window.location.href;
	if (url.indexOf("?") >= 0) {
		var queryUrl = url.substring(url.indexOf("?") + 1).replace("-", " ");
		var queries = queryUrl.split("&");
		for (var i = 0; i < queries.length; i++) {
			var key = queries[i].substring(0, queries[i].indexOf("="));
			var val = queries[i].substring(queries[i].indexOf("=") + 1);
			document.getElementById(key).value = val;
		}
	}
}

function getProperties() {
	var node = document.getElementById("houses");
	removeChildren(node);
	function removeChildren(node) {
		while (node.firstChild) {
			removeChildren(node.firstChild);
			node.removeChild(node.firstChild);
		}
	}
	removeAllMarkers();
	initAllHomes(0);
}

function initAllHomes(pageNumber) {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/getAllRets.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function () {
		if (this.readyState == 4) {
			res = JSON.parse(JSON.parse(this.responseText));
			if (!res || !res.length) {
				document.getElementById("loadingHomes").innerHTML = 'No Houses Found';
			} else {
				document.getElementById("loadingHomes").innerHTML = 'Loading More Homes...';
				setGridHouses(res);
				if (!pageNumber) {
					initMap(res);
				} else {
					setMapHouses(res);
				}
			}
		}
	}
	var query = getQuery();
	xhr.send("pageNumber=" + pageNumber + (query.length > 0 ? ("&" + query) : ""));
}

function setGridHouses(res) {
	for(var i=0; i < res.length; i++) {
		document.getElementById("houses").append(createHouse(res[i], i));
	}
}

var idLookup = {};
var map;
var markerArray = []
var mapInited = false;

function initMap(res) {
	var mapElement = document.getElementById("map");
	map = new google.maps.Map(mapElement, {
		center: {lat: -34.397, lng: 150.644},
		zoom: 7
	});
	mapElement.style.width =  document.body.clientWidth + "px";
	mapElement.style.height =  document.body.clientWidth/2 + "px";
	removeAllMarkers();
	setMapHouses(res);
}

function removeAllMarkers() {
	for (var i = 0; i < markerArray.length; i++) {
		markerArray[i].setMap(null);
	}
	markerArray = [];
}

function setMapHouses(res) {
	var marker;
	var latMax=0;
	var latMin=0;
	var longMax=0;
	var longMin=0;
	var loaded = 0;
	var i = 0;
	res.forEach(function(resHouse) {
		var address = resHouse.FullStreetNum + " " +  resHouse.City + ", " + resHouse.StateOrProvince + ", " + resHouse.PostalCode;
		var id = resHouse.MLSNumber;
		idLookup[id] = i++;
		var lat = resHouse.Latitude;
		var lng = resHouse.Longitude;
		if (lat == null || lng == null) {
			return;
		}
		marker = new google.maps.Marker({
			map: map,
			zIndex: id/1,
			icon: {
				url: "/images/marker.png",
				scaledSize: new google.maps.Size(75,50),
				labelOrigin: new google.maps.Point(37.5, 18)
			},
			position: {lat: lat, lng: lng},
			label: { color: 'black', fontSize: '16px', fontFamily: "open sans", text: ''}
		});
		marker.addListener('click', function() {
			if (map.getZoom() >= 14 && Math.abs(map.getCenter().lat() - this.getPosition().lat()) < 0.0000000000001 && Math.abs(map.getCenter().lng() - this.getPosition().lng()) < 0.0000000000001) {
				showOverlay(this, res)
			} else {
				map.panTo(this.getPosition());
				if (map.getZoom() < 14) {
					map.setZoom(14);
				}

			}
		});
		if (latMin == 0 || lat < latMin) {
			latMin = lat;
		}
		if (latMax == 0 || lat > latMax) {
			latMax = lat;
		}
		if (longMin == 0 || lng < longMin) {
			longMin = lng;
		}
		if (longMax == 0 || lng > longMax) {
			longMax = lng;
		}
		marker.id = id;
		markerArray.push(marker);
		marker.getLabel().text = roundToLetter(resHouse.ListPrice);
	});
	map.setCenter(new google.maps.LatLng(
		((latMax + latMin) / 2.0),
		((longMax + longMin) / 2.0)
	));
	if (map.getZoom() < 8) {
		map.setZoom(8)
	}
	document.getElementById("loadingMap").style.display = "none";
	if (document.getElementById("mapGridSwitch").value == "map") {
		document.getElementById("map").style.display = "block";
	}
	mapInited = true;
}

function roundToLetter(num) {
	if (num > 1000000) {
		return String(Math.round(num / 1000000)) + "M";
	}
	return String(Math.round(num / 1000)) + "K"
}

function createHouse(resToUse, i) {
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

function showOverlay(marker, res) {
	var id = marker.id
	var i = idLookup[id];
	var house = createHouse(res[i]);
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
		if (mapInited) {
			document.getElementById("map").style.display = "block";
		} else {
			document.getElementById("loadingMap").style.display = "block";
		}
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

function openHouse(id) {
	window.location.href = "/find-your-home?id="+id;
}
