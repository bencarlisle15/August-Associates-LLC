document.addEventListener('DOMContentLoaded', beginFunctions());
//when the user scrolls to the bottom while in grid mode
var pageNumber = 0;
var houseWrapper = document.getElementById("housesWrapper");
var houses = document.getElementById("houses");
houseWrapper.onscroll = function(ev) {
	if (houses.getBoundingClientRect().bottom <= window.innerHeight + 50) {
		console.log("Adding more")
		var xhr = new XMLHttpRequest();
		xhr.open("POST", window.location.href, true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function () {
			if (this.readyState == 4) {
				//gets the next set of houses
				//parses to an array of json and echoed data
				var parsed = JSON.parse(this.responseText)
				var json = JSON.parse(JSON.parse(parsed[0]));
				var echoed = parsed[1];
				setMapHouses(json);
				//adds echoed to the houses
				document.getElementById("houses").innerHTML += echoed;
				if (!json || json.length < 40) {
					//either error or query too specific
					document.getElementById("loadingHomes").innerHTML = 'No More Properties Found. Try Changing Your Search Parameters';
				}
			}
		}
		xhr.send("pageNumber=" + (++pageNumber));
	}
};
document.getElementById("searchThisArea").style.display = "block";
document.getElementById("map").style.visibility = "visible";
document.getElementById("map").style.position = "relative";
document.getElementById("loadingHomes").style.display = "block";
document.getElementById("sortArray").style.display = "block";
document.getElementById("houses").style.display = "grid";
document.getElementById("housesWrapper").style.maxHeight = document.body.clientWidth/2 + "px";

function beginFunctions() {
	//edits settings
	var url = window.location.href;
	//checks for params
	if (url.indexOf("?") >= 0) {
		var queryUrl = url.substring(url.indexOf("?") + 1).split('+').join(' ').split("-").join(" ");
		var queries = queryUrl.split("&");
		//splits into key and params and updates the search bar
		for (var i = 0; i < queries.length; i++) {
			var key = queries[i].substring(0, queries[i].indexOf("="));
			var val = queries[i].substring(queries[i].indexOf("=") + 1);
			if (key == "searchMinPrice" || key == "searchMaxPrice") {
				val = formatCurrency(val);
			}
			if (document.getElementById(key)) {
				document.getElementById(key).value = val;
			}
		}
	}
	//all currency input
	var vals = ["searchMinPrice","searchMaxPrice"];
	for (var i in vals) {
		document.getElementById(vals[i]).addEventListener("keyup", function() {
			this.value = formatCurrency(this.value);
		});
	}
}

//automatically updates currency input
function formatCurrency(oldVal) {
	var num = oldVal.replace(/(,)/g, '');
	var val = num.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	if (val.slice(0,1)!='$' && val != '') {
		val = '$'+ val;
	}
	return val;
}

function resetSearch() {
	window.location.href = "/find-homes";
}

function searchArea() {
	var radius = document.getElementById("map").clientWidth * 156543.03392 * Math.cos(map.getCenter().lat() * Math.PI / 180) / Math.pow(2, map.getZoom())
	var extra = "radius=" + radius + "&lat=" + map.getCenter().lat() + "&lng=" + map.getCenter().lng() + "&map=true";
	document.getElementById("searchAreaInput").value = extra;
	document.getElementById("searchForm").submit();
}

//array of all google map markers REQUIRED
var markerArray = []
var map;
//locations bounds
var bounds = new google.maps.LatLngBounds();
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
	if (window.location.href.includes("radius")) {
		//find sets zoom from radius
		var url = window.location.href;
		var r = parseFloat(url.substring(url.indexOf("radius=") + 7, url.indexOf("&", url.indexOf("radius="))));
		var zoom = Math.log2(document.getElementById("map").clientWidth * 156543.03392 * Math.cos(map.getCenter().lat() * Math.PI / 180)/(r));
		var lat = parseFloat(url.substring(url.indexOf("lat=") + 4, url.indexOf("&", url.indexOf("lat="))));
		var lng = parseFloat(url.substring(url.indexOf("lng=") + 4, url.includes("map") ? url.indexOf("&", url.indexOf("lng=")) : url.length));
		map.setZoom(zoom);
		map.setCenter(new google.maps.LatLng(lat, lng));
	} else if (map.getZoom() < 8) {
		map.setZoom(8);
	}
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
	res.forEach(function (resHouse) {
		//get last and lng from house
		var lat = parseFloat(resHouse.Latitude);
		var lng = parseFloat(resHouse.Longitude);
		//geocding errors are entirely possible
		if (!lat || !lng) {
			return;
		}
		//creates new marker
		var marker = new google.maps.Marker({
			map: map,
			//cannot have same zIndex some zIndex is created by id
			//why does I have resHouse.MLSNumber/1 you ask? because for some reason using just resHouse.MLSNumber draws an error  ¯\_(ツ)_/¯
			zIndex: parseInt(resHouse.MLSNumber),
			icon: {
				url: "/images/marker.png",
				scaledSize: new google.maps.Size(75,50),
				labelOrigin: new google.maps.Point(37.5, 18)
			},
			//positioned to coordinates
			position: {lat: lat, lng: lng},
			//sets bubble text;
			label: { color: 'black', fontSize: '16px', fontFamily: "Open Sans", text: roundToLetter(resHouse.CurrentPrice)}
		});
		//when a marker is clicked
		marker.addListener('click', function() {
			//checks if the map is centered on the marker already and is zoomed in significantly
			if (map.getZoom() >= 14 && Math.abs(map.getCenter().lat() - this.getPosition().lat()) < 0.0000000000001 && Math.abs(map.getCenter().lng() - this.getPosition().lng()) < 0.0000000000001) {
				showOverlay(resHouse);
			} else {
				//moves to the marker and somes to it
				map.panTo(this.getPosition());
				if (map.getZoom() < 14) {
					map.setZoom(14);
				}
			}
		});
		//updates bounds
		bounds.extend(marker.getPosition());
		//adds marker to the array
		markerArray.push(marker);
	});
	if (!window.location.href.includes("radius")) {
		map.fitBounds(bounds);
	}
}

//Adds K and M to create the price
function roundToLetter(num) {
	if (num > 950000) {
		return String(Math.round(num / 1000000)) + "M";
	}
	return String(Math.round(num / 1000)) + "K";
}

//Adds the clicked house to an overlay
function showOverlay(res) {
	var house = document.createElement("div");
	house.classList.add("house");
	house.setAttribute("onclick", "openHouse(" + res.MLSNumber + ")");
	house.id = "mapHouse";
	house.innerHTML = "<div class='houseImageWrapper'><img class='houseElement houseImage' alt='Picture of House' src='images/rets/" + res.MLSNumber + "/0.jpg'/></div><div class='houseInformation'><div class='pricesSection'><h3 class='previousPrice'>" + getPreviousPrice(res) + "</h3><h3 class='currentPrice '>" + formatCurrency(res.CurrentPrice) + "</h3></div><p class='houseElement'>" + toTitleCase(res.FullStreetNum) + "</p><p class='houseElement'>" +toTitleCase(res.City) + "</p><p class='houseElement'>" + parseInt(res.SqFtTotal) + " Square Feet</p></div>";
	document.getElementById("mapHouseWrapper").append(house);
	document.getElementById("mapHouseWrapper").style.display = "block";
}

function getPreviousPrice(res) {
  if (res.PreviousPrice) {
    var currentLength = formatCurrency(res.CurrentPrice).length;
    var previous = formatCurrency(res.PreviousPrice);
    if (currentLength + previous.length > 25) {
      return "";
    }
    return previous;
  }
  return "";
}

function toTitleCase(str) {
	return str.replace(/\w\S*/g, function(txt){
		return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
	});
}

function removeHouseOverlay() {
	document.getElementById("mapHouseWrapper").style.display = "none";
}


//if a grid house is clicked
function openHouse(id) {
	window.location.href = "/find-your-home?id="+id;
}
