var formatter = new Intl.NumberFormat('en-US', {
	style: 'currency',
	currency: 'USD',
});

$("#formLine").ready(changeFormSize);
$("#formLine").resize(changeFormSize);

function changeFormSize() {
	if (parseInt($("#formLine").css('width')) < 300) {
		$("#formLine, #formCity, #formZip, #formState").css('display', "block");
		$("#formCity, #formZip, #formState").css('width', "100%");
		$("#formZip").css('margin-left', '0');
		$("#formZip").css('margin-right', '0');
	} else {
		$("#formLine, #formCity, #formZip, #formState").css('display', 'default');
		$("#formCity, #formZip, #formState").css('width', "default");
		$("#formZip").css('margin-left', '8px');
		$("#formZip").css('margin-right', '8px');
	}
}

function submitContactForm() {
	$.post({
		url: '../phpRequests/apiRequests.php',
		data: {functionname: 'sendEmail', body: createBody()}
	});
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
	var totalAddress = addPluses(address) + "&citystatezip=" + zip+"&rentzestimate=true";
	createCloudCMA();
	document.getElementById("sellAverage").innerHTML = "Price not found";
	document.getElementById("sellRange").innerHTML = "Price not found";
	document.getElementById("sellAddress").innerHTML = address;
	document.getElementById("sellCity").innerHTML = city + ", " + state + ", " + zip;
	getHouseSellingInfo(totalAddress);
	submitContactForm();
}

function createAddress() {
	var address = document.getElementById("formAddress").value;
	var city = document.getElementById("formCity").value;
	var zip = document.getElementById("formZip").value;
	var state = document.getElementById("formState").value;
	return addPluses(address) + ",+" + addPluses(city) + ",+" + state + "+" + zip;
}

function createCloudCMA() {
	$.post({
		url: '../phpRequests/apiRequests.php',
		data: {functionname: "sendCMA", sellerName: addPluses(document.getElementById("formName").value), address: createAddress(), email: addPluses(document.getElementById("formEmail").value)},
		complete: function(data) {
			console.log(data)
		}
	});
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

function constructHouseSellingInfo(xml) {
	var xmlText = xml.responseText;
		if (xmlText.indexOf("<zestimate>") >= 0) {
			var zestimateText = xmlText.substring(xmlText.indexOf("<zestimate>"), xmlText.indexOf("</zestimate>"));
			var average = zestimateText.substring(zestimateText.indexOf("<amount currency=\"USD\">")+23, zestimateText.indexOf("</amount>"));
			var low = zestimateText.substring(zestimateText.indexOf("<low currency=\"USD\">")+20, zestimateText.indexOf("</low>"));
			var high = zestimateText.substring(zestimateText.indexOf("<high currency=\"USD\">")+21, zestimateText.indexOf("</high>"));
			document.getElementById("sellAverage").innerHTML = "Average Price: " + formatter.format(average);
			document.getElementById("sellRange").innerHTML = "Price Range: " + formatter.format(low) +" - " + formatter.format(high);
		}
	addSellOverlay();
}
function getHouseSellingInfo(totalAddress) {
	$.post({
		url: '../phpRequests/apiRequests.php',
		data: {functionname: 'getEstimate', address: totalAddress},
		complete: function(data) {
			constructHouseSellingInfo(data);
		}
	});
}

function addSellOverlay() {
	document.getElementById("sellOverlay").style.display = "block";
}

function removeSellOverlay() {
	document.getElementById("sellOverlay").style.display = "none";
}
