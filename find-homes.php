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
						<input type="text" title="Addresses" id="searchAddresses" placeholder="Addresses" class="searchElement">
						<input type="text" title="Cities" id="searchCities" placeholder="Cities" class="searchElement">
						<input type="text" title="Zipcodes" id="searchZips" placeholder="Zipcodes" class="searchElement">
						<select id="searchPropertyType" title="Property Type" class="searchElement">
							<option title="Property Type" value="" selected>Property Type</option>
							<option title="Single Family" value="Single Family">Single Family</option>
							<option title="Rental" value="Rental">Rental</option>
							<option title="Multi Family" value="	2-4 Units Multi Family">Multifamily	</option>
							<option title="Condo" value="Condominium">Condo</option>
							<option title="Vacant Land" value="Vacant Land">Vacant Land</option>
						</select>
					</div>
					<div class="searchFormLine">
						<input type="text" title="Min Price" id="searchMinPrice" placeholder="Min Price" class="searchElement">
						<input type="text" title="Max Price" id="searchMaxPrice" placeholder="Max Price" class="searchElement">
						<input type="number" title="Min Bedrooms" id="searchBeds" placeholder="Min Bedrooms" class="searchElement">
						<input type="number" title="Min Bathrooms" id="searchBaths" placeholder="Min Bathrooms" class="searchElement">
						<input type="number" title="Min Square Feet" id="searchMinFeet" placeholder="Min Square Feet" class="searchElement">
						<input type="number" title="Max Square Feet" id="searchMaxFeet" placeholder="Max Square Feet" class="searchElement">
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
				<h2 id="loadingHomes" style="text-align: center">Loading More Homes...</h2>
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
