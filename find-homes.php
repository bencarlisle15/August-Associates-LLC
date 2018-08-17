		<?php
			$pageNumber = 0;
			//gets the rets data from the database
			ini_set('memory_limit', '-1');
			require_once("phpRequests/keys.php");
			$conn = new mysqli("localhost", getDBUser(), getDBPassword(), getDBName());
			$query = "SELECT * FROM RetsData WHERE ";
			//uses the keys and vals from the params
			foreach ($_GET as $key => $val) {
				//removes dashes
				$val = str_replace("-", " ", $val);
				//change shows that this all vals need to be higher than it (1), lower than it (-1) or the same as or include it (0)
				$change = 0;
				//updates key to the correct one
				switch ($key) {
					case "searchPropertyType":
						$key = "PropertyType";
						if ($val == "Multi Family") {
							$val = "2-4 Units Multi Family";
						}
						break;
					case "searchMinPrice":
						$key = "CurrentPrice";
						$change = 1;
						break;
					case "searchMaxPrice":
						$key = "CurrentPrice";
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
						$lat = $_GET['lat'];
						$lng = $_GET['lng'];
						//uses the haversine formula to calculate the distance between two lat lng values and see if its less tham the radius
						$query .= "(" . $val . " >= 63710000 * atan2(sqrt(sin((`Latitude` - " . $lat . ") * 0.0087222222) * sin((`Latitude` - " . $lat . ") * 0.0087222222) + cos(" . $lat . " * 0.0174444444) * cos(`Latitude` * 0.0174444444) * sin((`Longitude` - " . $lng . ") * 0.0087222222) * sin((`Longitude` - " . $lng . ") * 0.0087222222)), sqrt(1-sin((`Latitude` - " . $lat . ") * 0.0087222222) * sin((`Latitude` - " . $lat . ") * 0.0087222222) + cos(" . $lat . " * 0.0174444444) * cos(`Latitude` * 0.0174444444) * sin((`Longitude` - " . $lng . ") * 0.0087222222) * sin((`Longitude` - " . $lng . ") * 0.0087222222)))) && ";
						continue 2;
					//only used for radius
					case "lat":
						continue 2;
					//only used for radius
					case "lng":
						continue 2;
					//only used for js
					case "map":
						continue 2;
					case "sortArray":
						continue 2;
				}
				switch ($change) {
					case 0:
						//checks for either substring then for equality
						$query .= "(INSTR('" . $val . "', `" . $key . "`) > 0 OR INSTR(`" . $key . "`, '" . $val . "') > 0 OR '" . $val . "' = `" . $key . "`) && ";
						break;
					case -1:
						//uses *1 to convert to int
						$query .= "`" . $key ."`*1 <= " . $val . " && ";
						break;
					case 1:
						//uses *1 to convert to int
						$query .= "`" . $key ."`*1 >= " . $val . " && ";
						break;
				}
				//makes sure the value is not ""
				$query .= "LENGTH(`" . $key . "`) > 0 && ";
			}
			//checks if a requirement exists
			if (!count($_GET)) {
				$query .= "1";
			} else {
				$query = substr($query, 0, strlen($query) - 3);
			}
			//sorting
			$query .= " ORDER BY ";
			if (isset($_GET['sortArray'])) {
				//what to sort by
				switch ($_GET['sortArray']) {
					//price low to high
					case "plh":
						$query .= "CurrentPrice*1 ASC";
						break;
					//price high to low
					case "phl":
						$query .= "CurrentPrice*1 DESC";
						break;
					//square feet low to high
					case "slh":
						$query .= "SqFtTotal*1 ASC";
						break;
					//square feet high to low
					case "shl":
						$query .= "SqFtTotal*1 DESC";
						break;
				}
				$query .= ", ";
			}
			//automatically puts august to the front and then sorts by photo
			$query .= "CASE `ListOfficeName` WHEN 'August Associates, LLC' THEN 1 ELSE 2 END, PhotoCount*1 DESC";
			//post request occurs durring scroll
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				//prevents echo
				ob_start();
				//gets json
				$rets = getNextSet($_POST['pageNumber']);
				//gets echoed content
				$str = ob_get_contents();
				ob_end_clean();
				//creates array from json and echoed content and sends it
				echo json_encode([json_encode(json_encode($rets)), $str]);
				return;
			}
			include('bin/head.php');
		?>
		<link rel="stylesheet" type="text/css" href="/css/find-homes.css">
		<link rel="canonical" href="https://www.augustassociatesllc.com/find-homes" />
		<title>August Associates LLC - Find Homes</title>
		<meta name="description" content="Search for your new home here. August Associates, your valued guide in real estate." />
	</head>
	<body>
		<?php include('bin/nav.php'); ?>
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
					<button id="mapGridSwitch" class="findButton" type="button" value="grid" onclick="switchView()">Switch to Map View</button>
				</div>
			</form>
			<div id="housesWrapper">
				<div id="houses">
					<?php
						$rets = getNextSet(0);
						function getNextSet($pageNumber) {
							//global variables
							global $query, $conn;
							$newQuery = $query . " LIMIT 40 OFFSET " . 40*$pageNumber++;
							// echo $newQuery;
							$json = [];
							$result = mysqli_query($conn, $newQuery);
							while($row = $result->fetch_assoc()) {
								//adds result to json
								array_push($json, $row);
								echo "<div class='house' onclick='openHouse(" . htmlspecialchars($row['MLSNumber']) . ")'><div class='houseImageWrapper'>";
								//checks if the image is valid and only adds it if it is
								//checks both testing and current since for the main branch
								if (@getimagesize('images/rets/' . $row['MLSNumber'] . '/0.jpg') || @getimagesize('testing/images/rets/' . $row['MLSNumber'] . '/0.jpg')) {
									echo "<img class='houseElement houseImage' alt='Picture of House' src='images/rets/" . htmlspecialchars($row['MLSNumber']) . "/0.jpg'/>";
								} else {
									echo "<img class='houseElement houseImage' alt='House not Found' src='images/compass.png'/>";
								}
								$hasPrevious = $row['PreviousPrice'];
								echo "</div><div class='houseInformation'><div class='pricesSection'><h3 class='previousPrice'>" . ($hasPrevious ? ("$" . number_format((float) $row['PreviousPrice'])) : "") . "</h3><h3 class='currentPrice " . ($hasPrevious ? "hasPrevious" : "") . "'>$" . number_format((float) $row['CurrentPrice']) . "</h3></div><p class='houseElement'>" . htmlspecialchars(ucwords(strtolower($row['FullStreetNum']))) . "</p><p class='houseElement'>" . htmlspecialchars($row['City']) ."</p><p class='houseElement'>" . getPropertyType($row['PropertyType']) . "</h4><p class='houseElement'>" . htmlspecialchars(number_format((float) $row['SqFtTotal'])) . " Square Feet</p></div></div>";
							}
							return $json;
						}

						function getPropertyType($type) {
							switch ($type) {
								case "Rental":
									return "Rental";
								case "2-4 Units Multi Family":
									return "Multi Family";
								case "Condominium":
									return "Condo";
								case "Vacant Land":
									return "Land";
								case "Single Family":
									return "Single Family";
								default:
									return "";
							}
						}
					?>
				</div>
				<h2 id="loadingHomes">Loading More Homes...</h2>
			</div>
			<h6 id="useInfo">“IDX information is provided exclusively for consumers’ personal, non-commercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing. Information is deemed reliable but is not guaranteed.  © 2018 State-Wide Multiple Listing Service. All rights reserved.”</h6>
			<div id="mapHouseWrapper" onclick="removeHouseOverlay()">
			</div>
			<div id="map">
			</div>
		</div>
		<?php include('bin/footer.html'); ?>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTXHu0_banpDsOMFQSDHOxoqdooVQxreI"></script>
		<script src="/js/find-homes.js"></script>
		<script>
			//parses houses to json
			var json = JSON.parse(<?php echo json_encode(json_encode($rets)); ?>);
			//inits map from json
			initMap(json);
			if (!json || json.length < 40) {
				//either error or query too specific
				document.getElementById("loadingHomes").innerHTML = 'No More Houses Found';
			}
		</script>
	</body>
</html>
