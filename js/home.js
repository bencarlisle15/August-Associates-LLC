$("#largeImage").ready(function() {
	$('#smallImage').remove();
	$('#largeImage').css('display', 'block');
});

$(document).ready(function() {
	editArrow();
	setTimeout(function() {
		editArrow();
	}, 1000);
});

$(window).resize(function() {
	editArrow()
});

function editArrow() {
	var top = parseInt($("#bigImage").css('margin-top'));
	if (top > 0 && $("#largeImage").height()*0.12 > 0) {
		$("#arrow").css("top", top + $("#largeImage").height()*0.12);
	} else {
		$("#arrow").css("top", 89 + $("#largeImage").height()*0.12);
		setTimeout(function() {
			editArrow();
		}, 100);
	}
}

function submitSearch() {
	window.location.href = "/find-homes"+buildUrl();
}

function buildUrl() {
	var inputs = document.querySelectorAll("#searchAddresses, #searchCities, #searchZips, #searchPropertyType, #searchMinPrice, #searchMaxPrice, #searchMinFeet, #searchMaxFeet");
	var urlAdd = "";
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].value != '') {
			urlAdd += urlAdd.length > 0 ? "&" : "?" + inputs[i].id + "=" + inputs[i].value;
		}
	}
	return urlAdd;
}

function submitContactForm() {
	$.post({
		url: 'phpRequests/apiRequests.php',
		data: {functionname: 'sendEmail', body: createBody()}
	});
	document.getElementById("contactForm").reset();
}

function createBody() {
	var body = "Source: Website Home Page Contact Form\nName: " + document.getElementById("contactFormName").value + "\nEmail: " + document.getElementById("contactFormEmail").value + "\nPhone: " + document.getElementById("contactFormPhone").value + "\nAddress: \nMLS Number: \nNotes: " + document.getElementById("contactFormText").value
	return body;
}
