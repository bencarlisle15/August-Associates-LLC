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
							<option title="Multi Family" value="2-4 Units Multi Family">Multifamily	</option>
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
			<div id="findButtons">
				<button id="searchThisArea" class="findButton" onclick="searchArea()">Search This Area</button>
				<select id="sortArray" onchange="sortArray()" title="Sort By">
					<option title="Sort By" value="" selected>Sort By</option>
					<option title="Price (Low to High)" value="plh">Price (Low to High)</option>
					<option title="Price (High to Low)" value="phl">Price (High to Low)</option>
					<option title="Size (Low to High)" value="slh">Size (Low to High)</option>
					<option title="Size (High to Low)" value="shl">Size (High to Low)</option>
				</select>
				<button id="resetSearch" class="findButton" onclick="resetSearch()">Reset Search</button>
				<button id="mapGridSwitch" class="findButton" value = "grid" onclick="switchView()">Switch to Map View</button>
			</div>
			<div id="housesWrapper">
				<div id="houses">
					<?php
						$pageNumber = 0;
						$rets = getSetRets($pageNumber++);
						function getSetRets($pageNumber) {
							//gets the rets data from the database
							ini_set('memory_limit', '-1');
							require_once("phpRequests/keys.php");
							$conn = new mysqli("localhost", getDBUser(), getDBPassword(), getDBName());
							$query = "SELECT json_data FROM RetsData";
							$resultQuery = mysqli_query($conn, $query);
							$result = $resultQuery->fetch_assoc()['json_data'];
							$json = json_decode($result, true);
							//uses the keys and vals from the params
							foreach ($_GET as $key => $val) {
								//change shows that this all vals need to be higher than it (1), lower than it (-1) or the same as or include it (0)
								$change = 0;
								//updates key to the correct one
								switch ($key) {
									case "searchPropertyType":
										$key = "PropertyType";
										break;
									case "searchMinPrice":
										$key = "ListPrice";
										$change = 1;
										break;
									case "searchMaxPrice":
										$key = "ListPrice";
										$change = -1;
										break;
									case "searchMinFeet":
										$key = "SqFtTotal";
										$change = 1;
										break;
									case "searchMaxFeet":
										$key = "SqFtTotal";
										$change = -1;
										break;
									case "searchBeds":
										$key = "BedsTotal";
										$change = 1;
										break;
									case "searchBaths":
										$key = "BathsTotal";
										$change = 1;
										break;
									case "searchAddresses":
										$key = "FullStreetNum";
										break;
									case "searchCities":
										$key = "City";
										break;
									case "searchZips":
										$key = "PostalCode";
										break;
									case "radius":
										//rempoves all
										for ($i = 0; $i < sizeof($json); $i++) {
											//determines the distanceBetween the points
											$dist = distanceBetween($_GET['lat'], $_GET['lng'], $json[$i]['Latitude'], $json[$i]['Longitude']);
											//removes the house if it is too far away
											if ($dist >= $val*0.79863) {
												unset($json[$i]);
												$i--;
												$json = array_values($json);
											}
										}
										continue;
									//only used for radius
									case "lat":
										continue;
									//only used for radius
									case "lng":
										continue;
									//only used for js
									case "map":
										continue;
									//sorts the houses
									case "sortby":
										//what to sort by
										switch ($val) {
											//price low to high
											case "plh":
												usort($json, function($a, $b) {
													return $a['ListPrice'] < $b['ListPrice'] ? -1 : 1;
												});
												break;
											//price high to low
											case "phl":
												usort($json, function($a, $b) {
													return $a['ListPrice'] > $b['ListPrice'] ? -1 : 1;
												});
												break;
											//square feet low to high
											case "slh":
												usort($json, function($a, $b) {
													return (int)($a['SqFtTotal'] ? $a['SqFtTotal'] : $a['ApproxLotSquareFoot']) < (int)($b['SqFtTotal'] ? $b['SqFtTotal'] : $b['ApproxLotSquareFoot']) ? -1 : 1;
												});
												break;
											//square feet high to low
											case "shl":
												usort($json, function($a, $b) {
													return (int)($a['SqFtTotal'] ? $a['SqFtTotal'] : $a['ApproxLotSquareFoot']) > (int)($b['SqFtTotal'] ? $b['SqFtTotal'] : $b['ApproxLotSquareFoot']) ? -1 : 1;
												});
												break;
										}
										continue;
								}
								//removes dashes
								$val = str_replace("-", " ", $val);
								for ($i = 0; $i < sizeof($json); $i++) {
									//checks if the house matches the requirements
									//if change is 0 then check if its an int and they vals are not equal, if its not an int then it checks if the two vals are not equal and the houseval is not in the paramsval, if change is -1 then checks if the houseval is greater than the paramval, if change is 1 then it checks if the houseval is less than the paramsval
									if ($change == 0 && (is_int($json[$i][$key]) ? ($json[$i][$key] != $val) : (strtolower($json[$i][$key]) != strtolower($val) && $json[$i][$key] && $val && strpos(strtolower($val), strtolower($json[$i][$key])) === false)) || $change == -1 && $json[$i][$key] > $val || $change == 1 && $json[$i][$key] < $val) {
										//removes from json by unsetting it;
										unset($json[$i]);
									}
								}
								//resets the array values;
								$json = array_values($json);
							}
							//gets the first 40 houses
							$pageSize = 40;
							$first = array_slice($json, $pageSize * $pageNumber, $pageSize * ($pageNumber + 1));
							for ($i = 0; $i < sizeof($first); $i++) {
								echo "<div class='house' onclick='openHouse(" . $first[$i]['MLSNumber'] . ")'><div class='houseImageWrapper'>";
								//checks if the image is valid and only adds it if it is
								if (@getimagesize('images/rets/' . $first[$i]['MLSNumber'] . '/0.jpg') || @getimagesize('testing/images/rets/' . $first[$i]['MLSNumber'] . '/0.jpg')) {
									echo "<img class='houseElement houseImage' alt='Picture of House' src='images/rets/" . $first[$i]['MLSNumber'] . "/0.jpg'/>";
								} else {
									echo "<img class='houseElement houseImage' alt='House not Found' src='images/compass.png'/>";
								}
								echo "</div><div class='houseInformation'><h4 class='housePrice houseElement'>$" . number_format((float) $first[$i]['ListPrice']) . "</h4><p class='houseElement'>" . ucwords(strtolower($first[$i]['FullStreetNum'])) . "</p><p class='houseElement'>" . $first[$i]['City'] ."</p><p class='houseElement'>" . number_format((float) ($first[$i]['SqFtTotal'] ? $first[$i]['SqFtTotal'] : $first[$i]['ApproxLotSquareFoot'])) . " Square Feet</p></div></div>";
							}
							return $first;
						}

						//determines the fistance between two lat and lng vals
						function distanceBetween($lat1,$lng1,$lat2,$lng2) {
							$pi180 = M_PI / 180;
							//distance between lats converts to rad
							$dLat =  ($lat2-$lat1) * $pi180;
							//distance between lang converts to rad
							$dLon = ($lng2-$lng1) * $pi180;
							//uses Haversine formula to calculate distance between
							$a = sin($dLat/2) * sin($dLat/2) + cos($lat1 * $pi180) * cos($lat2 * $pi180) * sin($dLon/2) * sin($dLon/2);
							return 12742 * atan2(sqrt($a), sqrt(1-$a));
						}
					?>
				</div>
				<h2 id="loadingHomes" style="text-align: center">Loading More Homes...</h2>
			</div>
			<div id="mapHouseWrapper" onclick="removeHouseOverlay()">
			</div>
			<div id="map">
			</div>
			<div id="useInfoWrapper">
				<h6 id="useInfo">“IDX information is provided exclusively for consumers’ personal, non-commercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. Information is deemed reliable but is not guaranteed.  © 2018 State-Wide Multiple Listing Service. All rights reserved.”</h6>
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
//parses houses to json
var json = JSON.parse(<?php echo json_encode(json_encode($rets)); ?>);
//inits map from json
initMap(json);
if (!json || !json.length) {
	//either error or query too specific
	document.getElementById("loadingHomes").innerHTML = 'No More Houses Found';
}

function initAllHomes(pageNumber) {
	document.getElementById("houses").innerHTML += "<?php $rets = getSetRets($pageNumber++) ?>";
	//parses houses to json
	var json = JSON.parse(<?php echo json_encode(json_encode($rets)); ?>);
	//inits map from json
	setMapHouses(json);
	if (!json || !json.length) {
		//either error or query too specific
		document.getElementById("loadingHomes").innerHTML = 'No More Houses Found';
	}
}
</script>
