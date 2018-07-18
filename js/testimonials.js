function submitTestimonialsForm() {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/apiRequests.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send("functionname=sendEmail&body=" + createBody());
	document.getElementById("testimonialsForm").reset();
}

function createBody() {
	return "Website Testimonial Page Contact Form\nName: " + document.getElementById("testimonialsFormName").value + "\nTestimonial: " +  document.getElementById("testimonialsFormText").value;
}
