// addTestimonialsText()

/*"<div class='testimonialFrame'><p class='testimonialText'><i>\"I was incredibly impressed with Pam's goal oriented action. She obtained a full asking price cash offer on my house within DAYS of listing, just as she hoped to when I signed on with Benefit.\"</i></p><p class='testimonialName'>-Karin</p></div>"*/

function addTestimonials() {
	var frameWidth = (document.body.clientWidth - 20)/2-40;
	if (frameWidth < 200) {
		frameWidth =  document.body.clientWidth;-20;
	}
	if (frameWidth > 750) {
		frameWidth = 750;
	}
	frameWidth = Math.round(frameWidth);
	var loading = document.createElement("p");
	loading.id="loading";
	loading.style.textAlign = "center";
	loading.style.fontSize = "20pt";
	loading.style.position = "absolute";
	loading.innerHTML = "Loading testimonials...";
	var testimonialSlideshow = document.getElementById("testimonialSlideshow");
	testimonialSlideshow.insertBefore(loading, testimonialSlideshow.firstChild);
	testimonialSlideshow.style.maxWidth = frameWidth + "px";
	var testimonials = ["https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2FYronelis%2Fposts%2F1989657454379754%3A0&width=", "https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fgeorgina.kalwak%2Fposts%2F10211519031843485%3A0&width=","https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fphoebea.zuromski%2Fposts%2F1480339765332976%3A0&width=","https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fjacqueline.leroux%2Fposts%2F10209053628479961%3A0&width=", "https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fmichele.l.caprio%2Fposts%2F10155114566912277%3A0&width=",  "https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fdrjohndemello%2Fposts%2F10206646836329813%3A0&width="]
	var dots = document.getElementById("dots");
	var testimonial;
	var dot;
	for (var i = 0; i < testimonials.length; i++) {
		testimonial = document.createElement("iframe");
		testimonial.title = "Facebook Testimonial";
		testimonial.classList.add("testimonialFrame");
		testimonial.src = testimonials[i] + frameWidth;
		testimonial.setAttribute("scrolling", "no");
		testimonial.setAttribute("frameborder", "0");
		testimonial.setAttribute("allowTransparency", "true");
		testimonial.setAttribute("allow", "encrypted-media");
		if (!i) {
			testimonial.setAttribute("onload", "removeLoading()");
		}
		testimonialSlideshow.append(testimonial);
		dot = document.createElement("span");
		dot.classList.add("dot");
		dot.setAttribute("onclick", "showSlides(" + i + ")");
		dots.appendChild(dot);
	}
	showSlides(0);
}

function removeLoading() {
	document.getElementById("testimonialSlideshow").removeChild(document.getElementById("loading"));
}

var currentSlide = 0;
function plusSlides(n) {
	showSlides(currentSlide+n);
}

function showSlides(n) {
	var i;
	var slideIndex;
	var slides = document.getElementsByClassName("testimonialFrame");
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
		dots[i].className = dots[i].className.replace(" active", "");
	}
	slides[currentSlide].style.display = "block";
	dots[currentSlide].className += " active";
}

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
