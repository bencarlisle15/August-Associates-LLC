<link rel="stylesheet" type="text/css" href="/css/find-homesDesktop.css">
<link rel="canonical" href="https://www.augustassociatesllc.com/find-homes" />
<title>August Associates LLC - Find Homes</title>
<meta name="description" content="Search for your new home here. August Associates, your valued guide in real estate." />
</head>
<body>
<div id="homesSection" class="section">
<h2 id="findTitle">Find Your New Home</h2>
<form id= "searchForm" method="POST"action="phpRequests/submitSearchForm.php">
	<div id="searchBox">
		<div class="searchFormLine">
			<input name="searchAddresses" type="text" title="Addresses" id="searchAddresses" placeholder="Addresses" class="searchElement">
			<input name="searchCities" type="text" title="Cities" id="searchCities" placeholder="Cities" class="searchElement">
			<input name="searchZips" type="text" title="Zipcodes" id="searchZips" placeholder="Zipcodes" class="searchElement">
			<select name="searchPropertyType" id="searchPropertyType" title="Property Type" class="searchElement">
				<option title="Property Type" value="" selected>Property Type</option>
				<option title="Single Family" value="Single Family">Single Family</option>
				<option title="Rental" value="Rental">Rental</option>
				<option title="Multi Family" value="Multi Family">Multi Family</option>
				<option title="Condo" value="Condominium">Condo</option>
				<option title="Vacant Land" value="Vacant Land">Vacant Land</option>
			</select>
		</div>
		<div class="searchFormLine">
			<input name="searchMinPrice" type="text" title="Min Price" id="searchMinPrice" placeholder="Min Price" class="searchElement">
			<input name="searchMaxPrice" type="text" title="Max Price" id="searchMaxPrice" placeholder="Max Price" class="searchElement">
			<input name="searchBeds" type="number" title="Min Bedrooms" id="searchBeds" placeholder="Min Bedrooms" class="searchElement">
			<input name="searchBaths" type="number" title="Min Bathrooms" id="searchBaths" placeholder="Min Bathrooms" class="searchElement">
			<input name="searchMinFeet" type="number" title="Min Square Feet" id="searchMinFeet" placeholder="Min Square Feet" class="searchElement">
			<input name="searchMaxFeet" type="number" title="Max Square Feet" id="searchMaxFeet" placeholder="Max Square Feet" class="searchElement">
		</div>
		<div id="searchSubmitWrapper" class="searchFormLine">
			<button id="searchSubmit" class="searchElement">Search</button>
		</div>
	</div>
	<div id="findButtons">
		<input id="searchAreaInput" name="searchAreaInput">
		<button id="searchThisArea" name="searchThisArea" class="findButton" type="button" onclick="searchArea()" value="">Search This Area</button>
		<select id="sortArray" name="sortArray" class="findButton" onchange="this.form.submit()" title="Sort By">
			<option title="Sort By" value="" selected>Sort By</option>
			<option title="Price (Low to High)" value="plh">Price &#x21C8;</option>
			<option title="Price (High to Low)" value="phl">Price &#x21CA;</option>
			<option title="Size (Low to High)" value="slh">Size &#x21C8;</option>
			<option title="Size (High to Low)" value="shl">Size &#x21CA;</option>
		</select>
		<button id="resetSearchButton" class="findButton" type="button" onclick="resetSearch()">Reset Search</button>
	</div>
</form>
<div id='housesAndMapWrapper'>
	<div id="housesWrapper">
		<div id="houses">
			<?php
				if (isset($_GET['searchCities'])) {
					switch (strtolower($_GET['searchCities'])) {
						case "jamestown":
							$name = "Jamestown";
							$img = "https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/Claiborne_Pell_Newport_Bridge.jpg/220px-Claiborne_Pell_Newport_Bridge.jpg";
							$text = "Jamestown is a town in Newport County, Rhode Island in the United States. The population was 5,405 at the 2010 census. Jamestown is situated almost entirely on Conanicut Island, the second largest island in Narragansett Bay. It also includes the uninhabited Dutch Island and Gould Island. Jamestown is ranked as the 444th wealthiest place to live in the United States as of 2016, with a median home sale price of $1,229,039.<br/><br/>According to the United States Census Bureau, the town has an area of 35.3 square miles (91 km2), of which 9.7 square miles (25 km2) is land and 25.6 square miles (66 km2) is water. The total area is 72.55% water.";
							break;
					}
					if ($name) {
						echo "<div id='additionalInfo'><h2 id='additionalTitle'>Homes in " . $name . "</h2><div id='additionalImageAndText'><img id='additionalImage' src='" . $img . "'/><p id='additionalText'>" . $text .  "</p></div></div>";
					}
				}
				$rets = getNextSet(0);
			?>
		</div>
		<h2 id="loadingHomes">Loading More Homes...</h2>
	</div>
	<div id="map">
	</div>
</div>
<div id="mapHouseWrapper" onclick="removeHouseOverlay()">
</div>
<h6 id="useInfo">“IDX information is provided exclusively for consumers’ personal, non-commercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. Information is deemed reliable but is not guaranteed.  © 2018 State-Wide Multiple Listing Service. All rights reserved.”</h6>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTXHu0_banpDsOMFQSDHOxoqdooVQxreI"></script>
<script src="/js/find-homesDesktop.js"></script>
<script>
//parses houses to json
var json = JSON.parse(<?php echo json_encode(json_encode($rets)); ?>);
//inits map from json
initMap(json);
if (!json || json.length < 40) {
	//either error or query too specific
	document.getElementById("loadingHomes").innerHTML = 'No More Properties Found. Try Changing Your Search Parameters';
}
</script>
</body>
