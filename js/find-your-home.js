var url = window.location.href;
if (url.includes("?id=")) {
	var id = url.substring(url.indexOf("?id=")+4);
} else {
	window.location.replace('/404');
}
var formatter = new Intl.NumberFormat('en-US', {
	style: 'currency',
	currency: 'USD',
});
$.post({
	url: '/phpRequests/apiRequests.php',
	data: {functionname: 'ipCheck'},
	complete: function(data) {
		if (!sessionStorage.houseNumber || data.responseJSON) {
			sessionStorage.houseNumber = 1;
		} else if (sessionStorage.houseNumber < 2) {
			sessionStorage.houseNumber++;
		} else {
			addInformationForm();
		}
	}
})

$.ajax({
	url:'phpRequests/getRets.php',
	complete: function(r) {
		res = findMlsId(JSON.parse(r.responseJSON), id);
		if (res == null) {
			return;
		}
		$("#address").html(res.address.streetNumber + " " + res.address.streetName +", " + res.address.city + ", " + res.address.state + ", " + res.address.postalCode)
		$("#description").html(res.remarks);
		$("#houseImage").attr("src","")
		for (var i = 0; i < res.photos.length; i++) {
			$("#prev").before("<div class='houseWrapper' id='houseWrapper" + i + "'><img src='" + res.photos[i] + "' alt = 'Picture of the House' class = 'houseImage' id='house" + i + "'></div>");
			$("#dots").append("<span class='dot' onclick='showSlides(" + i + ")'></span>");
			$(document).on('ready', setWrapperWidth(i));
		}
		$("#price").html("Price: " + formatter.format(res.listPrice));
		var keys = {"roof": "Roof", "area": "Area (sqft)", "bathsHalf": "Bathrooms", "stories": "Stories", "fireplaces": "Fireplaces", "heating": "Heating", "bedrooms": "Bedrooms", "pool": "Pool", "water": "Water View", "yearBuilt": "Year Built", "additionalRooms": "Additional Rooms"}

		for(var key in keys) {
			addAttribute(key, keys[key], res.property[key]);
		}
		addAttribute("parking", "Parking", res.property.parking.description);
		if (res.association.name != null) {
			addAttribute("association", "Association", res.association.name)
			addAttribute("associationFee", "Association Fee", res.association.fee)
			addAttribute("associationAmenities", "Association Amenities", res.association.amenities)
		}
		initMap(res.address.full +", " + res.address.city + ", " + res.address.state);
		showSlides(0);
	}
});

function findMlsId(r, id) {
	for (var i = 0; i < r.length; i++) {
		if (r[i].mlsId == id) {
			return r[i];
		}
	}
	return null;
}
// $.ajax({
// 	url: "https://api.simplyrets.com/properties/" + id,
// 	type: 'GET',
// 	dataType: 'json',
// 	beforeSend: function(xhr) {
// 		auth = "c2ltcGx5cmV0czpzaW1wbHlyZXRz";
// 		xhr.setRequestHeader("Authorization", "Basic  " + auth);
// 	},
// 	success: function(res) {
// 		$("#address").html(res.address.streetNumber + " " + res.address.streetName +", " + res.address.city + ", " + res.address.state + ", " + res.address.postalCode)
// 		$("#description").html(res.remarks);
// 		$("#houseImage").attr("src","")
// 		for (var i = 0; i < res.photos.length; i++) {
// 			$("#prev").before("<div class='houseWrapper' id='houseWrapper" + i + "'><img src='" + res.photos[i] + "' alt = 'Picture of the House' class = 'houseImage' id='house" + i + "'></div>");
// 			$("#dots").append("<span class='dot' onclick='showSlides(" + i + ")'></span>");
// 			$(document).on('ready', setWrapperWidth(i));
// 		}
//
// 		var keys = {"roof": "Roof", "area": "Area (sqft)", "bathsHalf": "Bathrooms", "stories": "Stories", "fireplaces": "Fireplaces", "heating": "Heating", "bedrooms": "Bedrooms", "pool": "Pool", "water": "Water View", "yearBuilt": "Year Built", "additionalRooms": "Additional Rooms"}
//
// 		for(var key in keys) {
// 			addAttribute(key, keys[key], res.property[key]);
// 		}
// 		addAttribute("parking", "Parking", res.property.parking.description);
// 		if (res.association.name != null) {
// 			addAttribute("association", "Association", res.association.name)
// 			addAttribute("associationFee", "Association Fee", res.association.fee)
// 			addAttribute("associationAmenities", "Association Amenities", res.association.amenities)
// 		}
// 		initMap(res.address.full +", " + res.address.city + ", " + res.address.state);
// 		showSlides(0);
// 		addInformationForm();
// 	}
// });



function addInformationForm() {
	$("#infoOverlay").css("display", "block");
	$("#infoWrapper").css("color", "transparent");
	$("#infoWrapper").css("text-shadow", "0 0 20px rgba(0,0,0,5)");
	$("#infoWrapper").css("user-select", "none");
	$("#infoWrapper a").css("visibility", "hidden");
	$("#infoWrapper").css("cursor", "default");
	$("#map").css("visibility", "hidden");
}

function removeInformationForm() {
	$("#infoOverlay").css("display", "none");
	$("#infoWrapper").css("color", "inherit");
	$("#infoWrapper").css("user-select", "inherit");
	$("#infoWrapper").css("cursor", "inherit");
	$("#infoWrapper").css("text-shadow", "inherit");
	$("#map").css("visibility", "inherit");
	$("#infoWrapper a").css("visibility", "inherit");
}

function submitInfoForm() {
	$.post({
		url: 'phpRequests/apiRequests.php',
		data: {functionname: 'sendEmail', body: createBody()}
	});
	removeInformationForm();
}

function createBody() {
	var body = "Source: Website Property View Page Form\nName: " + document.getElementById("infoFormName").value + "\nEmail: " + document.getElementById("infoFormEmail").value + "\nPhone: " + document.getElementById("infoFormPhone").value + "\nAddress: " + document.getElementById("address").innerHTML + "\nMLS Number: " + id + "\nNotes: Viewed property on website";
	return body;
}

function insideClickHandler(e) {
	if (!e) {
		var e = window.event;
	}
	e.cancelBubble = true;
}

var wrapperWidth = -1;

function setWrapperWidth(num) {
	var wrapper = $("#houseWrapper" + num);
	var house = $("#house" + num);
	if (wrapperWidth == -1) {
		wrapperWidth = wrapper.width();
	}
	var height = 480*wrapperWidth/640;
	house.width(wrapperWidth);
	wrapper.height(height);
	wrapper.width(wrapperWidth);
}

function addAttribute(key, keyName, value) {
	if (value == null || value == "None" || value == 0 || value == "0") {
		return;
	}
	$("#table").append("<tr id = '" + key + "'><th id='key" + key + "' class='keys'>" + keyName + "</th><td id='value" + key + "'  class='values'>" + String(value).replace(",", ", ") + "</td></tr>");
}

function initMap(address) {
	var map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: -34.397, lng: 150.644},
		zoom: 17
	});
	new google.maps.Geocoder().geocode({
		'address': address
	}, function (results, status) {
		map.setCenter(results[0].geometry.location);
		new google.maps.Marker({
			map: map,
			position: results[0].geometry.location
		});
	});
}

var currentSlide = 0;

function plusSlides(n) {
	showSlides(currentSlide+n);
}

function showSlides(n) {
	var i;
	var slideIndex;
	var slides = document.getElementsByClassName("houseWrapper");
	var dots = document.getElementsByClassName("dot");
	if (slides.length == 0 || dots.length == 0) {
		return;
	}
	currentSlide = n;
	if (currentSlide >= slides.length) {
		currentSlide = 0;
	}
	if (currentSlide < 0) {
		currentSlide = slides.length-1;
	}
	for (i = 0; i < slides.length; i++) {
		slides[i].style.display = "none";
	}
	for (i = 0; i < dots.length; i++) {
		dots[i].className = dots[i].className.replace("active", "");
	}
	slides[currentSlide].style.display = "block";
	dots[currentSlide].className += " active";
}
