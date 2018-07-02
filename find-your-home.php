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
				<h2 id ="formInfo">Enter Your Name and Email to View this Property</h2>
				<form id="infoForm" align="center" border="1px" action="javascript:submitInfoForm()">
					<input type="text" id="infoFormName" placeholder="Name" required>
					<input type="email" id="infoFormEmail" placeholder="Email" required>
					<input type="tel" id="infoFormPhone" placeholder="Phone Number">
					<button id="infoFormSubmit">Submit</button>
				</form>
			</div>
		</div>
		<div id = "infoWrapper">
			<div id="houseSlideshow">
				<a onclick="plusSlides(-1)" id="prev">&#10094;</a>
				<a onclick="plusSlides(1)" id="next">&#10095;</a>
			</div>
			<div style="text-align:center" id="dots">
			</div>
			<h2 id="address" align = "center"></h1>
			<div id="tableAndDescription">
				<table id="table">
				</table>
				<div id="descriptionAndMap">
					<p id="description"></p>
					<div id="map"></div>
				</div>
			</div>
		</div>
	</div>
	<?php include('bin/footer.html'); ?>
</body>
</html>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTXHu0_banpDsOMFQSDHOxoqdooVQxreI"></script>
<script>
	<?php
		include('bin/jquery.js');
		include('js/load.js');
		include('js/find-your-home.js');
	?>
</script>
