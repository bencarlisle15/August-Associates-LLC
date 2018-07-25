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

//check if the ip address is already present in the database
var xhr = new XMLHttpRequest();
xhr.open("POST", '/phpRequests/apiRequests.php', true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xhr.onreadystatechange = function () {
	if (this.readyState == 4) {
		//checks if the user has visited a find-your-home page before
		if (!sessionStorage.houseNumber) {
			sessionStorage.houseNumber = 1;
		//if the ip address was found
		} else if (this.responseText) {
			//creates lead alerting that the uesr has returned
			var xhr = new XMLHttpRequest();
			xhr.open("POST", '/phpRequests/apiRequests.php', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.send("functionname=ipReturned");
			sessionStorage.houseNumber = 1;
		} else if (sessionStorage.houseNumber < 2) {
			//increases the views the user has
			sessionStorage.houseNumber++;
		} else {
			//requires user to make a lead
			addInformationForm();
		}
	}
}
xhr.send("functionname=ipCheck");

//show the first slide
showSlides(0);

//reset the images on resize
window.addEventListener("resize", function() {
	setImageHeight();
})

//adds the lead maker overlay
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

//removes the lead maker overlay
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

//submits lead
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

//prevents clicking from outside the lead maker when it is present
function insideClickHandler(e) {
	if (!e) {
		var e = window.event;
	}
	e.cancelBubble = true;
}

//resets the image height so they all have the same height
function setImageHeight() {
	var maxRatio = 0;
	var max;
	var images = document.getElementsByClassName("houseImage");
	var imageArray = [];
	var loaded = 0;
	//finds the maximum height and width ratio between all the images
	for (var i = 0; i < images.length; i++) {
		//adds the image to the array to get it later
		imageArray.push(new Image());
		//when the image is loaded and has dimensions
		imageArray[i].onload = function() {
			//increases the amount of pictures that have loaded
			loaded++;
			var ratio = this.naturalHeight/this.naturalWidth;
			if (maxRatio < ratio) {
				maxRatio = ratio;
			}
			//updates the maxRatio if apllicable
		};
		//sets the src to the correct one
		imageArray[i].src = images[i].src;
		//this is done after the onload is set so that there is not possible of the src being loaded before the onload is set (therefore keep it this way)
	}
	//starts checkLoaded immediatly after the loop
	(function checkLoaded() {
		//checks if all the images have loaded
		if (loaded == images.length) {
			//determines what the height should be for the slideshow
			max = maxRatio * getWidth("#houseSlideshow");
			max = Math.round(max);
			if (!max) {
				return;
			}
			//updates wrapper heights and slideshow height
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

//inits the map
function initMap(location) {
	var pos = JSON.parse(location);
	var map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: pos[0], lng: pos[1]},
		zoom: 17
	});
	new google.maps.Marker({
		map: map,
		position: {lat: pos[0], lng: pos[1]}
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
