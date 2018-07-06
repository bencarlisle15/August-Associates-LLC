addTestimonials()

/*"<div class='testimonialWrapper'><p class='testimonialText'><i>\"I was incredibly impressed with Pam's goal oriented action. She obtained a full asking price cash offer on my house within DAYS of listing, just as she hoped to when I signed on with Benefit.\"</i></p><p class='testimonialName'>-Karin</p></div>"*/

function addTestimonials() {
	var frameWidth = ($("body").width() - 20)/2-40;
	if (frameWidth < 200) {
		frameWidth = $("body").width()-20;
	}
	if (frameWidth > 750) {
		frameWidth = 750;
	}
	frameWidth = Math.round(frameWidth);
	$("#prev").before("<p id='loading' style='text-align:center; font-size: 20pt; position: absolute;'>Loading testimonials...</p>");
	$("#testimonialSlideshow").css("max-width", frameWidth);
	console.log(frameWidth)
	var testimonials = ["https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2FYronelis%2Fposts%2F1989657454379754%3A0&width=", "https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fgeorgina.kalwak%2Fposts%2F10211519031843485%3A0&width=","https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fphoebea.zuromski%2Fposts%2F1480339765332976%3A0&width=","https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fjacqueline.leroux%2Fposts%2F10209053628479961%3A0&width=", "https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fmichele.l.caprio%2Fposts%2F10155114566912277%3A0&width=",  "https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fdrjohndemello%2Fposts%2F10206646836329813%3A0&width="]
	for (var i=0; i < testimonials.length; i++) {
		$("#prev").before("<iframe title='Facebook Testimonial' class='testimonialFrame' src='" + testimonials[i] + frameWidth + "' onload='removeLoading()' style='border:none;overflow:hidden' scrolling='no' frameborder='0' allowTransparency='true' allow='encrypted-media'></iframe>")
		$("#dots").append("<span class='dot' onclick='showSlides(" + i + ")'></span>");
	}
	showSlides(0);
}

function removeLoading() {
	$("#loading").remove();
}

var currentSlide = 0;
function plusSlides(n) {
	showSlides(currentSlide+n);
}

// var interval = setInterval(function() {
// 	plusSlides(1);
// }, 5000);

function showSlides(n) {
	var i;
	var slideIndex;
	var slides = $("iframe, .testimonialWrapper");
	var dots = document.getElementsByClassName("dot");
	// clearInterval(interval);
	// interval = setInterval(function() {
	// 	plusSlides(1);
	// }, 5000);
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

function submitTestimonialsForm() {
	$.post({
		url: 'phpRequests/apiRequests.php',
		data: {functionname: 'sendEmail', body: createBody()}
	});
	document.getElementById("testimonialsForm").reset();
}

function createBody() {
	return "Website Testimonial Page Contact Form\nName: " + document.getElementById("testimonialsFormName").value + "\nTestimonial: " +  document.getElementById("testimonialsFormText").value;
}
