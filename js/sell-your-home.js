function createBody(name, email, address, city, state, zip) {
	return "Source: Website House Price Page Form\nName: " + name + "\nEmail: " + email + "\nPhone: \nAddress: " + address + ", " + city + ", " + zip + ", " + document.getElementById("formState").value + "\nMLS Number: \nNotes: Price for address";
}

function submitForm() {
	var address = document.getElementById("formAddress").value;
	var city = document.getElementById("formCity").value;
	var zip = document.getElementById("formZip").value;
	var state = document.getElementById("formState").value;
	createCloudCMA(address, city, zip, state);
	getHouseSellingInfo(address, city, state, zip);
}

function createAddress() {
	var address = document.getElementById("formAddress").value;
	var city = document.getElementById("formCity").value;
	var zip = document.getElementById("formZip").value;
	var state = document.getElementById("formState").value;
	return addPluses(address) + ",+" + city.replace(' ', '+') + ",+" + state + "+" + zip;
}

function createCloudCMA(address, city, zip, state) {
	// var xhr = new XMLHttpRequest();
	// xhr.open("POST", '/phpRequests/apiRequests.php', true);
	// xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	// xhr.send("functionname=sendCMA&sellerName=" + document.getElementById("formName").value + "&address=" + address + "&city=" + city + "&zip=" + zip + "&state=" + state + "&email=" + document.getElementById("formEmail").value);
}

function constructHouseSellingInfo(xmlText, address, city, state, zip) {
		var formatter = new Intl.NumberFormat('en-US', {
			style: 'currency',
			currency: 'USD',
		});
		var average = xmlText.substring(xmlText.indexOf("<amount currency=\"USD\">")+23, xmlText.indexOf("</amount>"));
		var low = xmlText.substring(xmlText.indexOf("<low currency=\"USD\">")+20, xmlText.indexOf("</low>"));
		var high = xmlText.substring(xmlText.indexOf("<high currency=\"USD\">")+21, xmlText.indexOf("</high>"));
		var sellOverlay = document.createElement("div");
		sellOverlay.id = "sellOverlay";
		sellOverlay.onclick = function() {
			document.getElementById("sellSection").removeChild(document.getElementById("sellOverlay"));
		}
		sellOverlay.innerHTML = "<div id='sellInfo'><h2 id='sellAddress'> " + address + "</h2><h2 id='sellCity'>" + city + ", " + state + ", " + zip + "</h2><h2 id='sellAverage'>Average Price: " + (isFinite(average) ? formatter.format(average) : "Price Not Found") + "</h2><h3 id='sellRange'>" + (isFinite(low) && isFinite(high) ? ("Price Range: " + formatter.format(low) +" - " + formatter.format(high)) : "Price Range Not Found") + "</h3><h3 id='sellBetterQuote'>Looking for a more accurate estimate? Call us at <a href='tel:4014610700'>(401) 461-0700</a> or email us at <a href='mailto:jmccarthy@necompass.com'>jmccarthy@necompass.com</a> for more information</h3><h6 id='sellPowered'>Zestimate Powered by Zillow, <a href='" + xmlText.substring(xmlText.indexOf("<homedetails>") + 13, xmlText.indexOf("</homedetails>"))  + "'> See more details for " + address + " on Zillow</a></h6><img id='sellImage' src='https://www.zillow.com/widgets/GetVersionedResource.htm?path=/static/logos/Zillowlogo_200x50.gif' alt='Real Estate on Zillow' height='50px' width='200px'/></div>";
		document.getElementById("sellSection").insertBefore(sellOverlay, document.getElementById("sellHouseForm"));
		document.getElementById("sellInfo").onclick = function(e) {
			var event = e ? e : window.event;
			event.cancelBubble = true;
		}
		document.getElementById("sellImage").onclick = function() {
			open("http://www.zillow.com/");
		};
		document.getElementById("formSubmit").focus();
		document.getElementById("formSubmit").blur();
		var xhr = new XMLHttpRequest();
		xhr.open("POST", '/phpRequests/apiRequests.php', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send("functionname=sendEmail&body=" + createBody(document.getElementById("formName").value, document.getElementById("formEmail").value, address, city, state, zip));
}	//sets center and zoom from frame
	map.setCenter(new google.maps.LatLng(((locationPos['latMax'] + locationPos['latMin']) / 2.0), ((locationPos['lngMax'] + locationPos['lngMin']) / 2.0)));
	if (window.location.href.includes("radius")) {
		var url = window.location.href;
		map.setZoom(Math.log2(156543.03392 * Math.cos(map.getCenter().lat() * Math.PI / 180)/(parseInt(url.substring(url.indexOf("radius=") + 7, url.indexOf("&", url.indexOf("radius=")))))));
	} else if (map.getZoom() < 8) {
		map.setZoom(8);
	}

function getHouseSellingInfo(address, city, state, zip) {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/apiRequests.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function () {
		if (this.readyState == 4) {
			constructHouseSellingInfo(this.responseText, address, city, state, zip);
		}
	}
	xhr.send("functionname=getEstimate&address=" + address + "&zip=" + zip);
}
