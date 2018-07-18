		<?php include('bin/head.php'); ?>
		<style>
			<?php include('css/contact.css'); ?>
		</style>
		<title>August Associates LLC - Contact Us</title>
		<meta name="description" content="Contact us for any questions or concerns. August Associates, your valued guide in real estate." />
	</head>
	<body>
		<?php include('bin/nav.php'); ?>
		<div id="contactSection" class="section">
			<div id="contactWrapper">
				<div id="imageInfoWrapper" class="contactWrapperSection">
					<div id="imageWrapper">
						<img id="contactLogo" alt="August Associates Logo" src="/images/august%20splash.png"/>
					</div>
					<div id="infoWrapper">
						<h1 id="infoTitle">Our Info</h1>
						<div id="infoText">
							<p class="infoElement"><b>Phone: </b> (401) 487-1510</p>
							<p class="infoElement"><b>Email: </b><a href="mailto:jmccarthy@necompass.com">jmccarthy@necompass.com</a></p>
							<p class="infoElement"><b>Address: </b><a href="https://www.google.com/maps/place/946+Park+Ave,+Cranston,+RI+02910/@41.7808564,-71.4423498,17z/data=!3m1!4b1!4m5!3m4!1s0x89e44f0e74f416a7:0x9bb4c58a58a98e90!8m2!3d41.7808564!4d-71.4401611">946 Park Avenue, Cranston, RI</a></p>
						</div>
					</div>
				</div>
				<div id="contactFormWrapper" class="contactWrapperSection">
					<h1 id="contactUsTitle">Contact Us</h1>
					<form id="contactForm" action="javascript:submitContactForm()">
						<input type="text" title="Name" id="contactFormName" placeholder="Name" class="contactFormElement" required>
						<input type="email" title="Email" id="contactFormEmail" placeholder="Email" class="contactFormElement">
						<input type="tel" title="Phone" id="contactFormPhone" placeholder="Phone Number" class="contactFormElement">
						<textarea rows="10" title="Text" id="contactFormText" placeholder="Enter your Message Here" class="contactFormElement" required></textarea>
						<button id="contactFormSubmit" class="contactFormElement">Submit</button>
					</form>
				</div>
			</div>
		</div>
		<?php include('bin/footer.html'); ?>
	</body>
</html>

<script>
	<?php
		include('js/load.js');
		include('js/contact.js');
	?>
</script>
