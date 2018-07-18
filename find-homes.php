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
						ini_set('memory_limit', '-1');
						require_once("phpRequests/keys.php");
						$conn = new mysqli("localhost", getDBUser(), getDBPassword(), getDBName());
						$query = "SELECT json_data FROM RetsData";
						$resultQuery = mysqli_query($conn, $query);
						$result = $resultQuery->fetch_assoc()['json_data'];
						$json = json_decode($result, true);
						foreach ($_GET as $key => $val) {
							$change = 0;
							switch ($key) {
								case "searchPropertyType":
									$key = "ListPrice";
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
									for ($q = 0; $q < sizeof($json); $q++) {
										$dist = distanceBetween($_GET['lat'], $_GET['lng'], $json[$q]['Latitude'], $json[$q]['Longitude']);
										if ($dist >= $val*0.79863) {
											unset($json[$q]);
											$q--;
											$json = array_values($json);
										}
									}
									continue;;
								case "lat":
									continue;
								case "lng":
									continue;
								case "map":
									continue;
								case "sortby":
									switch ($val) {
										case "plh":
											usort($json, function($a, $b) {
												return $a['ListPrice'] < $b['ListPrice'] ? -1 : 1;
											});
											break;
										case "phl":
											usort($json, function($a, $b) {
												return $a['ListPrice'] > $b['ListPrice'] ? -1 : 1;
											});
											break;
										case "slh":
											usort($json, function($a, $b) {
												return (int)($a['SqFtTotal'] ? $a['SqFtTotal'] : $a['ApproxLotSquareFoot']) < (int)($b['SqFtTotal'] ? $b['SqFtTotal'] : $b['ApproxLotSquareFoot']) ? -1 : 1;
											});
											break;
										case "shl":
											usort($json, function($a, $b) {
												return (int)($a['SqFtTotal'] ? $a['SqFtTotal'] : $a['ApproxLotSquareFoot']) > (int)($b['SqFtTotal'] ? $b['SqFtTotal'] : $b['ApproxLotSquareFoot']) ? -1 : 1;
											});
											break;
									}
									continue;

							}
							for ($q = 0; $q < sizeof($json); $q++) {
								if ($change == 0 && (is_int($json[$q][$key]) ? ($json[$q][$key] != $val) : (strtolower($json[$q][$key]) != strtolower($val) && $json[$q][$key] && $val && strpos(strtolower($val), strtolower($json[$q][$key])) === false)) || $change == -1 && $json[$q][$key] > $val || $change == 1 && $json[$q][$key] < $val) {
									unset($json[$q]);
									$q--;
									$json = array_values($json);
								}
							}
						}
						$first = array_slice($json, 0, 40);
						for ($i = 0; $i < sizeof($first); $i++) {
							echo "<div class='house' onclick='openHouse(" . $first[$i]['MLSNumber'] . ")'><img class='houseElement houseImage' width='300px' alt='Picture of House' src='images/rets/" . $first[$i]['MLSNumber'] . "/0.jpg'/><div class='houseInformation'><h4 class='houseElement' align='right'>$" . number_format((float) $first[$i]['ListPrice']) . "</h4><p class='houseElement'>" . ucwords(strtolower($first[$i]['FullStreetNum'])) . "</p><p class='houseElement'>" . $first[$i]['City'] ."</p><p class='houseElement'>" . number_format((float) ($first[$i]['SqFtTotal'] ? $first[$i]['SqFtTotal'] : $first[$i]['ApproxLotSquareFoot'])) . " Square Feet</p></div></div>";
						}

						function distanceBetween($lat1,$lon1,$lat2,$lon2) {
							$pi180 = M_PI / 180;
							$dLat =  ($lat2-$lat1) * $pi180;
							$dLon = ($lon2-$lon1) * $pi180;
							$a = sin($dLat/2) * sin($dLat/2) + cos($lat1 * $pi180) * cos($lat2 * $pi180) * sin($dLon/2) * sin($dLon/2);
							return 12742 * atan2(sqrt($a), sqrt(1-$a));
						}
					?>
				</div>
				<h2 id="loadingHomes" style="text-align: center">Loading More Homes...</h2>
			</div>
			<div id="mapHouseWrapper" onclick="removeHouseOverlay()">
			</div>
			<h3 id="loadingMap" style="display: none; text-align: center" width="100%">Loading Map...</h3>
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
var json = JSON.parse(<?php echo json_encode(json_encode($first)); ?>);
initMap(json);
if (!json || !json.length) {
	//either error or query too specific
	document.getElementById("loadingHomes").innerHTML = 'No More Houses Found';
}
</script>
