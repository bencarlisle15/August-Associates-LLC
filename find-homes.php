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
				$key = "ApproxLotSquareFoot";
				$change = 1;
				break;
			case "searchMaxFeet":
				$key = "ApproxLotSquareFoot";
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

	function getNextSet($pageNumber) {
		$dir = "images/largeRets/";
		if (!file_exists($dir)) {
			$dir = "testing/images/largeRets/";
		}
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
			if (@getimagesize($dir . $row['MLSNumber'] . '/0.jpg')) {
				echo "<img class='houseElement houseImage' alt='Picture of House' src='" . $dir . htmlspecialchars($row['MLSNumber']) . "/0.jpg'/>";
			} else {
				echo "<img class='houseElement houseImage' alt='House not Found' src='images/compass.png'/>";
			}
			$hasPrevious = $row['PreviousPrice'];
			echo "</div><div class='houseInformation'><div class='pricesSection'><h3 class='previousPrice'>" . ($hasPrevious ? ("$" . number_format((float) $row['PreviousPrice'])) : "") . "</h3><h3 class='currentPrice " . ($hasPrevious ? "hasPrevious" : "") . "'>$" . number_format((float) $row['CurrentPrice']) . "</h3></div><p class='houseElement'>" . htmlspecialchars(ucwords(strtolower($row['FullStreetNum']))) . "</p><p class='houseElement'>" . htmlspecialchars($row['City']) ."</p><p class='houseElement'>" . getPropertyType($row['PropertyType']) . "</h4><p class='houseElement'>" . htmlspecialchars(squareFeet($row)) . "</p></div></div>";
		}
		return $json;
	}

	function squareFeet($row) {
		$returnVal = number_format((float) $row['SqFtTotal']) . "  Square Feet";
		if ($returnVal <= 0) {
			$returnVal = "Lot Size Not Listed";
		}
		return $returnVal;
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

		<?php
			include('bin/nav.php');
			if ($detect->isMobile() || substr($_SERVER[HTTP_HOST], 0, 5) == "www.m" || $_SERVER[HTTP_HOST][0] == 'm') {
				include('find-homesMobile.php');
			} else {
				include('find-homesDesktop.php');
			}
			include('bin/footer.html');
		?>
</html>
