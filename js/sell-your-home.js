function createBody(name, email, phone, address, city, state, zip) {
	return "Source: Website House Price Page Form -Seller\nName: " + name + "\nEmail: " + email + "\nPhone: " + phone + "\nAddress: " + address + ", " + city + ", " + zip + ", " + document.getElementById("formState").value + "\nMLS Number: \nNotes: Price for address";
}

function submitForm() {
	var address = document.getElementById("formAddress").value;
	var city = document.getElementById("formCity").value;
	var zip = document.getElementById("formZip").value;
	var state = document.getElementById("formState").value;
	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push({
		'event': 'homevalueComplete'
	});
	createCloudCMA(address, city, zip, state);
	getHouseSellingInfo(address, city, state, zip);
	redirectToThankYou();
}

function redirectToThankYou() {
	var url = "https://www.augustassociatesllc.com/content/thank-you/";
	setTimeout(function () {
		window.location.replace(url);
	}, 10000);
}

function createAddress() {
	var address = document.getElementById("formAddress").value;
	var city = document.getElementById("formCity").value;
	var zip = document.getElementById("formZip").value;
	var state = document.getElementById("formState").value;
	return addPluses(address) + ",+" + city.split(' ').join('+') + ",+" + state + "+" + zip;
}

function createCloudCMA(address, city, zip, state) {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/apiRequests.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send("functionname=sendCMA&sellerName=" + document.getElementById("formName").value + "&address=" + address + "&city=" + city + "&zip=" + zip + "&state=" + state + "&email=" + document.getElementById("formEmail").value);
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
		xhr.send("functionname=sendEmail&body=" + createBody(document.getElementById("formName").value, document.getElementById("formEmail").value, document.getElementById("formPhone").value, address, city, state, zip));
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
