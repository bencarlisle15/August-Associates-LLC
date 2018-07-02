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
					<div id="searchFirstLine">
					<input type="text" id="searchAddresses" placeholder="Addresses">
					<input type="text" id="searchCities" placeholder="Cities">
					<input type="text" id="searchZips" placeholder="Zipcodes">
					<select id="searchPropertyType">
						<option value="" selected>Property Type</option>
						<option value="resedential">Resedential</option>
						<option value="rental">Rental</option>
						<option value="multifamily">Multifamily	</option>
						<option value="condominium">Condo</option>
						<option value="commerical">Commerical</option>
						<option value="land">Land</option>
						<option value="farm">Farm</option>
					</select>
					</div>
					<div id="searchSecondLine">
						<input type="number" id="searchMinPrice" placeholder="Min Price">
						<input type="number" id="searchMaxPrice" placeholder="Max Price">
						<input type="number" id="searchBeds" placeholder="Min Bedrooms">
						<input type="number" id="searchBaths" placeholder="Min Bathrooms">
						<input type="number" id="searchMinFeet" placeholder="Min Square Feet">
						<input type="number" id="searchMaxFeet" placeholder="Max Square Feet">
					</div>
					<div id="searchSubmitWrapper">
						<button id="searchSubmit">Search</button>
					</div>
				</form>
			</div>
			<button id="mapGridSwitch" value = "grid" onclick="switchView()">Switch to Map View</button>
			<div id="houses">
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
		include('bin/jquery.js');
		include('js/load.js');
		include('js/find-homes.js');
	?>
</script>
