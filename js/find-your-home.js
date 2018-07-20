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

var xhr = new XMLHttpRequest();
xhr.open("POST", '/phpRequests/apiRequests.php', true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xhr.onreadystatechange = function () {
	if (this.readyState == 4) {
		if (!sessionStorage.houseNumber) {
			sessionStorage.houseNumber = 1;
		} else if (this.responseText) {
			var xhr = new XMLHttpRequest();
			xhr.open("POST", '/phpRequests/apiRequests.php', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.send("functionname=ipReturned");
			sessionStorage.houseNumber = 1;
		} else if (sessionStorage.houseNumber < 2) {
			sessionStorage.houseNumber++;
		} else {
			addInformationForm();
		}
	}
}
xhr.send("functionname=ipCheck");

showSlides(0);

window.addEventListener("resize", function() {
	setImageHeight();
})

function addInformationForm() {
	var infoWrapper = document.getElementById("infoWrapper");
	document.getElementById("infoOverlay").style.display = "block";
	infoWrapper.style.color = "transparent";
	infoWrapper.style.textShadow = "0 0 20px rgba(0,0,0,5)";
	infoWrapper.style.userSelect = "none";
	infoWrapper.style.cursor = "default";
	document.getElementById("map").style.visibility = "hidden";
	var links = document.getElementById("descriptionAndContact").getElementsByTagName("a");
	for (var i = 0; i < links.length; i++) {
		links[i].style.visibility = "hidden";
	}
}

function removeInformationForm() {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/apiRequests.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send("functionname=addIP&name=" + document.getElementById("infoFormName").value.replace(" ", "+") + "&email=" + document.getElementById("infoFormEmail").value.replace(" ", "+"));
	var infoWrapper = document.getElementById("infoWrapper");
	document.getElementById("infoOverlay").style.display = "none";
	infoWrapper.style.color = "inherit";
	infoWrapper.style.userSelect = "inherit";
	infoWrapper.style.cursor = "inherit";
	infoWrapper.style.textShadow = "inherit";
	document.getElementById("map").style.visibility = "inherit";
	var links = document.getElementById("descriptionAndContact").getElementsByTagName("a");
	for (var i = 0; i < links.length; i++) {
		links[i].style.visibility = "visible";
	}
}

function submitInfoForm() {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/apiRequests.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send("functionname=sendEmail&body=" + createBody());
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

function setImageHeight() {
	var maxRatio = 0;
	var max;
	var images = document.getElementsByClassName("houseImage");
	var imageArray = [];
	var loaded = 0;
	for (var i = 0; i < images.length; i++) {
		imageArray.push(new Image());
		imageArray[i].onload = function() {
			loaded++;
			var height = this.naturalHeight/this.naturalWidth;
			if (maxRatio < height) {
				maxRatio = height;
			}
		};
		imageArray[i].src = images[i].src;
	}
	(function checkLoaded() {
		if (loaded == images.length) {
			max = maxRatio * getWidth("#houseSlideshow");
			max = Math.round(max);
			if (!max) {
				return;
			}
			var wrappers = document.getElementsByClassName("houseWrapper");
			for (var i = 0; i < wrappers.length; i++) {
				wrappers[i].style.height = max + "px";
			}
			document.getElementById("houseSlideshow").style.height = max + "px";
		} else {
			window.setTimeout(checkLoaded, 1);
		}
	})();
}

function addAttribute(keyName, value) {
	if (value == null || value == "None" || value == 0 || value == "0") {
		return;
	}
	var row = document.createElement("tr");
	var header = document.createElement("th");
	var data = document.createElement("td");
	header.classList.add("keys");
	header.innerHTML = keyName;
	data.classList.add("values");
	data.innerHTML = String(value).replace(",", ", ");
	row.append(header);
	row.append(data);
	document.getElementById("table").append(row);
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
