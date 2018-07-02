		<?php include('bin/head.php'); ?>
		<style>
			<?php include('css/contact.css'); ?>
		</style>
		<title>August Associates LLC - Contact Us</title>
		<meta name="description" content="Contact us for any questions or concerns. August Associates, your valued guide in real estate." />	</head>
	<body>
		<?php include('bin/nav.php'); ?>
		<div id="contactSection" class="section">
			<div id="contactWrapper">
				<div id="imageInfoWrapper">
					<div id="imageWrapper">
						<img class="image" id="contactLogo" alt="August Associates Logo" src="/images/august splash.png"/>
					</div>
					<div id="infoWrapper">
						<h1 id="infoTitle">Our Info</h1>
						<div id="infoText">
							<p><b>Phone: </b> (401) 487-1510</p>
							<p><b>Email: </b><a href="mailto:jmccarthy@necompass.com">jmccarthy@necompass.com</a></p>
							<p><b>Address: </b><a href="https://www.google.com/maps/place/946+Park+Ave,+Cranston,+RI+02910/@41.7808564,-71.4423498,17z/data=!3m1!4b1!4m5!3m4!1s0x89e44f0e74f416a7:0x9bb4c58a58a98e90!8m2!3d41.7808564!4d-71.4401611">946 Park Avenue, Cranston, RI</a></p>
						</div>
					</div>
				</div>
				<div id="contactFormWrapper">
					<h1 id="contactUsTitle">Contact Us</h1>
					<form id="contactForm" align="center" border="1px" action="javascript:submitContactForm()">
						<input type="text" id="contactFormName" placeholder="Name" required>
						<input type="email" id="contactFormEmail" placeholder="Email">
						<input type="tel" id="contactFormPhone" placeholder="Phone Number">
						<textarea rows="10" id="contactFormText" placeholder="Enter your Message Here" required></textarea>
						<button id="contactFormSubmit">Submit</button>
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
		include('js/contact.js');
	?>
</script>
