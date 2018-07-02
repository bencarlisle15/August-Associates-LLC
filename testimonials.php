		<?php include('bin/head.php'); ?>
		<style>
			<?php include('css/testimonials.css'); ?>
		</style>
		<title>August Associates LLC - Testimonials</title>
		<meta name="description" content="View our testimonials or add your own. August Associates, your valued guide in real estate." />
	</head>
	<body>
		<?php include('bin/nav.php'); ?>
		<div id="testimonialsSection" class="section">
			<h1 id="testimonialsName">Testimonials</h1>
			<div id="testimonialsWrapper">
				<div id="testimonials">
					<div style="text-align:center" id="dots">
					</div>
					<div id="testimonialSlideshow">
						<a onclick="plusSlides(-1)" id="prev">&#10094;</a>
						<a onclick="plusSlides(1)" id="next">&#10095;</a>
					</div>
				</div>
				<div id= "addTestimonialsWrapper">
					<h2 id="testimonialsAddText">Add Your Own</h2>
					<form id="testimonialsForm" align="center" border="1px" action="javascript:submitTestimonialsForm()">
						<input type="text" id="testimonialsFormName" placeholder="Name" required>
						<textarea rows="10" id="testimonialsFormText" placeholder="Enter your Message Here" required></textarea>
						<button id="testimonialsFormSubmit">Submit</button>
					</form>
				</div>
			</div>
		</div>
		<?php include('bin/footer.html'); ?>
	</body>
</html>

<script>
	<?php
		include('bin/jquery.js');
		include('js/load.js');
		include('js/testimonials.js');
	?>
</script>
