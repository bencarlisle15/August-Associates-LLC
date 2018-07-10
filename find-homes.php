		<?php include('bin/head.php'); ?>
		<style>
			<?php include('css/find-homes.css'); ?>
		</style>
		<title>August Associates LLC - Find Homes</title>
		<meta name="description" content="Search for your new home here. August Associates, your valued guide in real estate." />
	</head>
	<body>
		<?php include('bin/nav.php'); ?>
		<div id="homesSection" class="section">
			<h1 id="findTitle">Find Your New Home</h1>
			<div id="searchBox">
				<form id= "searchForm" action="javascript:getProperties()">
					<div class="searchFormLine">
						<input type="text" id="searchAddresses" placeholder="Addresses" class="searchElement">
						<input type="text" id="searchCities" placeholder="Cities" class="searchElement">
						<input type="text" id="searchZips" placeholder="Zipcodes" class="searchElement">
						<select id="searchPropertyType" class="searchElement">
							<option value="" selected>Property Type</option>
							<option value="RES">Resedential</option>
							<option value="RNT">Rental</option>
							<option value="MLF">Multifamily	</option>
							<option value="CND">Condo</option>
							<option value="CRE">Commerical</option>
							<option value="LND">Land</option>
							<option value="FRM">Farm</option>
						</select>
					</div>
					<div class="searchFormLine">
						<input type="number" id="searchMinPrice" placeholder="Min Price" class="searchElement">
						<input type="number" id="searchMaxPrice" placeholder="Max Price" class="searchElement">
						<input type="number" id="searchBeds" placeholder="Min Bedrooms" class="searchElement">
						<input type="number" id="searchBaths" placeholder="Min Bathrooms" class="searchElement">
						<input type="number" id="searchMinFeet" placeholder="Min Square Feet" class="searchElement">
						<input type="number" id="searchMaxFeet" placeholder="Max Square Feet" class="searchElement">
					</div>
					<div id="searchSubmitWrapper" class="searchFormLine">
						<button id="searchSubmit" class="searchElement">Search</button>
					</div>
				</form>
			</div>
			<button id="mapGridSwitch" value = "grid" onclick="switchView()">Switch to Map View</button>
			<div id="housesWrapper">
				<div id="houses">
				</div>
			</div>
			<div id="mapHouseWrapper" onclick="removeHouseOverlay()">
			</div>
			<div id="map">
			</div>
		</div>
		<?php include('bin/footer.html'); ?>
	</body>
</html>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTXHu0_banpDsOMFQSDHOxoqdooVQxreI"></script>
<script>
	<?php
		include('js/load.js');
		include('js/find-homes.js');
	?>
</script>
