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
		if (xmlText.indexOf("<zestimate>") >= 0) {
			var formatter = new Intl.NumberFormat('en-US', {
				style: 'currency',
				currency: 'USD',
			});
			var zestimateText = xmlText.substring(xmlText.indexOf("<zestimate>"), xmlText.indexOf("</zestimate>"));
			var average = zestimateText.substring(zestimateText.indexOf("<amount currency=\"USD\">")+23, zestimateText.indexOf("</amount>"));
			var low = zestimateText.substring(zestimateText.indexOf("<low currency=\"USD\">")+20, zestimateText.indexOf("</low>"));
			var high = zestimateText.substring(zestimateText.indexOf("<high currency=\"USD\">")+21, zestimateText.indexOf("</high>"));
			var sellOverlay = document.createElement("div");
			var sellInfo = document.createElement("div");
			var sellAddress = document.createElement("h2");
			var sellCity = document.createElement("h2");
			var sellAverage = document.createElement("h2");
			var sellRange = document.createElement("h3");
			var betterQuote = document.createElement("h3");
			var sellPowered = document.createElement("h6");
			var sellImage = document.createElement("img");
			sellOverlay.id = "sellOverlay";
			sellOverlay.onclick = function() {
				document.getElementById("sellSection").removeChild(document.getElementById("sellOverlay"));
			}
			sellInfo.id = "sellInfo";
			sellInfo.onclick = function(e) {
				var event = e ? e : window.event;
				event.cancelBubble = true;
			}
			sellAddress.id = "sellAddress";
			sellAddress.innerHTML = address;
			sellCity.id = "sellCity";
			sellCity.innerHTML = city + ", " + state + ", " + zip;
			sellAverage.id = "sellAverage";
			sellAverage.innerHTML = "Average Price: " + formatter.format(average);
			sellRange.id = "sellRange";
			sellRange.innerHTML = "Price Range: " + formatter.format(low) +" - " + formatter.format(high);
			betterQuote.id = "sellBetterQuote";
			betterQuote.innerHTML = "Looking for a more accurate estimate? Call us at (401) 461-0700 or email us at <a href='mailto:jmccarthy@necompass.com'>jmccarthy@necompass.com</a> for more information";
			sellPowered.id = "sellPowered";
			var link = xmlText.substring(xmlText.indexOf("<homedetails>") + 13, xmlText.indexOf("</homedetails>"));
			sellPowered.innerHTML = "Zestimate Powered by Zillow, <a href='" + link  + "'> See more details for " + address + " on Zillow</a>";
			sellImage.src = "https://www.zillow.com/widgets/GetVersionedResource.htm?path=/static/logos/Zillowlogo_200x50.gif"
			sellImage.onclick = function() {
				open("http://www.zillow.com/");
			};
			sellImage.alt = "Real Estate on Zillow";
			sellImage.style.height = "50px";
			sellImage.style.width = "200px";
			sellInfo.append(sellAddress);
			sellInfo.append(sellCity);
			sellInfo.append(sellAverage);
			sellInfo.append(sellRange);
			sellInfo.append(betterQuote);
			sellInfo.append(sellPowered);
			sellInfo.append(sellImage);
			sellOverlay.append(sellInfo);
			document.getElementById("sellSection").insertBefore(sellOverlay, document.getElementById("sellHouseForm"));
			document.getElementById("formSubmit").focus();
			document.getElementById("formSubmit").blur();
		}
		var xhr = new XMLHttpRequest();
		xhr.open("POST", '/phpRequests/apiRequests.php', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send("functionname=sendEmail&body=" + createBody(document.getElementById("formName").value, document.getElementById("formEmail").value, address, city, state, zip));
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
