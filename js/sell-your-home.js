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
	document.getElementById("sellAverage").innerHTML = "Price not found";
	document.getElementById("sellRange").innerHTML = "Price not found";
	document.getElementById("sellAddress").innerHTML = address;
	document.getElementById("sellCity").innerHTML = city + ", " + state + ", " + zip;
	getHouseSellingInfo(address, zip);
	submitContactForm();
}

function createAddress() {
	var address = document.getElementById("formAddress").value;
	var city = document.getElementById("formCity").value;
	var zip = document.getElementById("formZip").value;
	var state = document.getElementById("formState").value;
	return addPluses(address) + ",+" + addPluses(city) + ",+" + state + "+" + zip;
}

function createCloudCMA(address, city, zip, state) {
	// var xhr = new XMLHttpRequest();
	// xhr.open("POST", '/phpRequests/apiRequests.php', true);
	// xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	// xhr.send("functionname=sendCMA&sellerName=" + document.getElementById("formName").value + "&address=" + address + "&city=" + city + "&zip=" + zip + "&state=" + state + "&email=" + document.getElementById("formEmail").value);
}


function insideClickHandler(e) {
	if (!e) {
		var e = window.event;
	}
	e.cancelBubble = true;
}

function addPluses(str) {
	return str.split(' ').join('+');
}

function constructHouseSellingInfo(xmlText) {
		if (xmlText.indexOf("<zestimate>") >= 0) {
			var formatter = new Intl.NumberFormat('en-US', {
				style: 'currency',
				currency: 'USD',
			});
			var zestimateText = xmlText.substring(xmlText.indexOf("<zestimate>"), xmlText.indexOf("</zestimate>"));
			var average = zestimateText.substring(zestimateText.indexOf("<amount currency=\"USD\">")+23, zestimateText.indexOf("</amount>"));
			var low = zestimateText.substring(zestimateText.indexOf("<low currency=\"USD\">")+20, zestimateText.indexOf("</low>"));
			var high = zestimateText.substring(zestimateText.indexOf("<high currency=\"USD\">")+21, zestimateText.indexOf("</high>"));
			document.getElementById("sellAverage").innerHTML = "Average Price: " + formatter.format(average);
			document.getElementById("sellRange").innerHTML = "Price Range: " + formatter.format(low) +" - " + formatter.format(high);
		}
	addSellOverlay();
}
function getHouseSellingInfo(address, zip) {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/apiRequests.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onreadystatechange = function () {
		if (this.readyState == 4) {
			constructHouseSellingInfo(this.responseText);
		}
	}
	xhr.send("functionname=getEstimate&address=" + address + "&zip=" + zip);
}

function addSellOverlay() {
	document.getElementById("sellOverlay").style.display = "block";
}

function removeSellOverlay() {
	document.getElementById("sellOverlay").style.display = "none";
}
