function submitContactForm() {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/apiRequests.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send("functionname=sendEmail&body=" + createBody());
	document.getElementById("contactForm").reset();
}

function createBody() {
	var body = "Source: Website Contact Page Form\nName: " + document.getElementById("contactFormName").value + "\nEmail: " + document.getElementById("contactFormEmail").value + "\nPhone: " + document.getElementById("contactFormPhone").value + "\nAddress: \nMLS Number: \nNotes: " + document.getElementById("contactFormText").value
	return body;
}
