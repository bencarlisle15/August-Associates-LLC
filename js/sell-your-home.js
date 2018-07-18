function submitContactForm() {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/apiRequests.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send("functionname=sendEmail&body=" + createBody());
}

function createBody() {
	var body = "Source: Website House Price Page Form\nName: " + document.getElementById("formName").value + "\nEmail: " + document.getElementById("formEmail").value + "\nPhone: \nAddress: " + document.getElementById("formAddress").value + ", " + document.getElementById("formCity").value + ", " + document.getElementById("formZip").value + ", " + document.getElementById("formState").value + "\nMLS Number: \nNotes: Price for address"
	return body;
}

function submitForm() {
	var address = document.getElementById("formAddress").value;
	var city = document.getElementById("formCity").value;
	var zip = document.getElementById("formZip").value;
	var state = document.getElementById("formState").value;
	createCloudCMA(address, city, zip, state);
	getHouseSellingInfo(address, city, state, zip);
	submitContactForm();
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
			var sellAverage = document.createElement("h3");
			var sellRange = document.createElement("h4");
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
			sellInfo.append(sellAddress);
			sellInfo.append(sellCity);
			sellInfo.append(sellAverage);
			sellInfo.append(sellRange);
			sellOverlay.append(sellInfo);
			document.getElementById("sellSection").insertBefore(sellOverlay, document.getElementById("sellHouseForm"));
			document.getElementById("formSubmit").focus();
			document.getElementById("formSubmit").blur();
		}
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
