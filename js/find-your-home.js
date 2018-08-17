var url = window.location.href;
if (url.includes("?id=")) {
	var id = url.substring(url.indexOf("?id=")+4);
} else {
	window.location.replace('/404');
}

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
	} else if (this.responseText == 1) {
			//creates lead alerting that the uesr has returned
			var xhr = new XMLHttpRequest();
			xhr.open("POST", '/phpRequests/apiRequests.php', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.send("functionname=ipReturned&MLSNumber=" + id);
			sessionStorage.houseNumber = 1;
		} else if (this.responseText == -1) {
			return;
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

function createBody(name, email, address, city, state, zip, mlsNumber) {
	return "Source: Website House Price Page Form\nName: " + name + "\nEmail: " + email + "\nPhone: \nAddress: " + address + ", " + city + ", " + zip + ", " + document.getElementById("formState").value + "\nMLS Number: " + mlsNumber + "\nNotes: Price for address";
}

//show the first slide
showSlides(0);

//adds the lead maker overlay
function addInformationForm() {
	var infoOverlay = document.createElement("div");
	infoOverlay.id = "infoOverlay";
	infoOverlay.style.display = "block";
	infoOverlay.innerHTML = "<div id='infoFormWrapper'><h2 id='formTooManyUses'>You Have Used Up Your Free Views</h2><h2 id='formInfo'>Enter Your Name and Email to View this Property</h2><form id='infoForm' action='javascript:submitInfoForm()'><input type='text' id='infoFormName' class='infoFormElement' placeholder='Name' required><input type='email' id='infoFormEmail' placeholder='Email' class='infoFormElement' required><input type='tel' id='infoFormPhone' placeholder='Phone Number' class='infoFormElement'><h4 id='chooseAgent' class='infoFormElement'>Choose a Specific Agent(s) to Notify</h4><fieldset id='agentFieldset' class='infoFormElement'><div id='checkAgents'><input type='checkbox' class='agentCheck' id='joseph' name='agent' value='joseph'/><label class='agentLabel' for='joseph'>Joseph McCarthy</label><input type='checkbox' class='agentCheck' id='wendy' name='agent' value='wendy'/><label class='agentLabel' for='wendy'>Wendy Grave</label><input type='checkbox' class='agentCheck' id='bob' name='agent' value='bob'/><label class='agentLabel' for='bob'>Bob Nasiatka</label><input type='checkbox' class='agentCheck' id='rick' name='agent' value='rick'/><label class='agentLabel' for='rick'>Rick Delmastro</label><input type='checkbox' class='agentCheck' id='kari' name='agent' value='kari'/><label class='agentLabel' for='kari'>Kari Hernandez</label><input type='checkbox' class='agentCheck' id='debora' name='agent' value='debora'/><label class='agentLabel' for='debora'>Debora Rotondo</label></div></fieldset><button id='infoFormSubmit' class='infoFormElement'>Submit</button></form></div>";
	document.getElementById("yourHomeSection").prepend(infoOverlay);
	infoWrapper.style.color = "transparent";
	infoWrapper.style.textShadow = "0 0 20px rgba(0,0,0,5)";
	infoWrapper.style.userSelect = "none";
	infoWrapper.style.cursor = "default";
	document.getElementById("map").style.visibility = "hidden";
	var links = document.getElementById("yourHomeSection").getElementsByTagName("a");
	for (var i = 0; i < links.length; i++) {
		links[i].style.visibility = "hidden";
	}
}

//removes the lead maker overlay
function removeInformationForm() {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/apiRequests.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send("functionname=addIP&name=" + document.getElementById("infoFormName").value.split(" ").join("+") + "&email=" + document.getElementById("infoFormEmail").value.split(" ").join("+"));
	var infoWrapper = document.getElementById("infoWrapper");
	document.getElementById("infoOverlay").style.display = "none";
	infoWrapper.style.color = "inherit";
	infoWrapper.style.userSelect = "inherit";
	infoWrapper.style.cursor = "inherit";
	infoWrapper.style.textShadow = "inherit";
	document.getElementById("map").style.visibility = "inherit";
	var links = document.getElementById("yourHomeSection").getElementsByTagName("a");
	for (var i = 0; i < links.length; i++) {
		links[i].style.visibility = "visible";
	}
}

//submits lead
function submitInfoForm() {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/apiRequests.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	var sendTo = "&sendto=";
	var checkboxes = document.getElementsByClassName("agentCheck");
	for (var i in checkboxes) {
		if (checkboxes[i].checked) {
			sendTo += checkboxes[i].value + ",";
		}
	}
	if (sendTo == "&sendTo=") {
		sendTo = "";
	} else {
		sendTo = sendTo.substring(0, sendTo.length - 1);
	}
	xhr.send("functionname=sendEmail&body=" + createBody() + sendTo);
	removeInformationForm();
}

function createBody() {
	var body = "Source: Website Property View Page Form\nName: " + document.getElementById("infoFormName").value + "\nEmail: " + document.getElementById("infoFormEmail").value + "\nPhone: " + document.getElementById("infoFormPhone").value + "\nAddress: " + document.getElementById("address").innerHTML + "\nMLS Number: " + id + "\nNotes: Viewed property on website";
	return body;
}

//inits the map
function initMap(location) {
	if (!location) {
		return;
	}
	var pos = JSON.parse(location);
	var map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: parseFloat(pos[0]), lng: parseFloat(pos[1])},
		zoom: 17
	});
	new google.maps.Marker({
		map: map,
		position: {lat: parseFloat(pos[0]), lng: parseFloat(pos[1])}
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
	if (!slides.length || !dots.length) {
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
	slides[currentSlide].style.display = "flex";
	dots[currentSlide].className += " active";
}
