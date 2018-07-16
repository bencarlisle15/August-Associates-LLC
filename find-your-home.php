	<?php include('bin/head.php'); ?>
	<style>
		<?php include('css/find-your-home.css'); ?>
	</style>
	<title>August Associates LLC - Find Your Home</title>
	<meta name="description" content="View your new home here. August Associates, your valued guide in real estate." />
</head>
<body>
	<?php include('bin/nav.php'); ?>
	<div id="yourHomeSection" class="section">
		<div id="infoOverlay">
			<div id="infoFormWrapper">
				<h2 id="formTooManyUses">You Have Used Up Your Three Free Views</h2>
				<h2 id="formInfo">Enter Your Name and Email to View this Property</h2>
				<form id="infoForm" align="center" border="1px" action="javascript:submitInfoForm()">
					<input type="text" id="infoFormName" class="infoFormElement" placeholder="Name" required>
					<input type="email" id="infoFormEmail" placeholder="Email" class="infoFormElement" required>
					<input type="tel" id="infoFormPhone" placeholder="Phone Number" class="infoFormElement">
					<button id="infoFormSubmit" class="infoFormElement">Submit</button>
				</form>
			</div>
		</div>
		<div id="infoWrapper">
			<div id="houseSlideshow">
				<a onclick="plusSlides(-1)" id="prev">&#10094;</a>
				<a onclick="plusSlides(1)" id="next">&#10095;</a>
			</div>
			<div style="text-align:center" id="dots">
			</div>
			<h1 id="address" align = "center"></h1>
			<h2 id="price">Price not Found</h2>
			<div id="tableAndDescription">
				<div id="descriptionAndContact">
					<p id="description">Description not Found</p>
					<h2 id="interested" style="font-weight: bold">Interested in this Home?</h2>
					<h2>Call us at <a href="tel:4014610700">(401) 461-0700</a> or Email us at <a href="mailto:jmccarthy@necompass.com">jmccarthy@necompass.com</a> to get in touch with an agent</h2>
				</div>
				<table id="table">
				</table>
			</div>
			<div id="map"></div>
		</div>
	</div>
	<?php include('bin/footer.html'); ?>
</body>
</html>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTXHu0_banpDsOMFQSDHOxoqdooVQxreI"></script>
<script>
	<?php
		include('js/load.js');
		include('js/find-your-home.js');
	?>
</script>
