function submitTestimonialsForm() {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/apiRequests.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send("functionname=sendEmail&body=" + createBody());
	document.getElementById("testimonialsForm").reset();
}

function createBody() {
	return "Source: Website Testimonial Page Add Testimonial Form\nName: " + document.getElementById("testimonialsFormName").value + " \nEmail: " + document.getElementById("testimonialsFormEmail").value + " \nPhone: \nAddress: \nMLS Number: \nNotes: Testimonial: " +  document.getElementById("testimonialsFormText").value;
}
