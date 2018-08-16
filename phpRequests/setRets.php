<?php
ini_set('memory_limit', '-1');
set_time_limit(0);
require_once("../vendor/autoload.php");
require_once("keys.php");
$config = new \PHRETS\Configuration;
$config->setLoginUrl('http://ris-matrix.retsiq.com/rets/login');
$config->setUsername(getRetsUser());
$config->setPassword(getRetsPassword());
$config->setUserAgent(getRetsUserAgent());
$config->setUserAgentPassword(getRetsPasswordAgent());
$config->setRetsVersion('1.7.2');
$config->setOption('use_post_method', true);
$rets = new \PHRETS\Session($config);
$bulletin = $rets->Login();
echo "Start Search\n";
$limit = $argc == 1 ? 99999999 : $argv[1];
$results = $rets->Search('Property', 'Listing', '(Status=AA,AU,CS),(CurrentPrice=299999-)',  ['Limit' => $limit/2]);
$results2 = $rets->Search('Property', 'Listing', '(Status=AA,AU,CS),(CurrentPrice=300000+)',  ['Limit' => $limit/2]);
echo "End Search\n";
$conn = new mysqli("localhost", getDBUser(), getDBPassword(), getDBName());
// $data = $results->toJSON();
$ar = array_merge($results->toArray(), $results2->toArray());
echo "Start Photos\n";
for ($q = 0; $q < sizeof($ar); $q++) {
	echo $q . " of " . count($ar) . "\n";
	if (!mysqli_query($conn, "SELECT * FROM `RetsData` WHERE `MLSNumber`='" . $ar[$q]['MLSNumber'] . "'")->num_rows) {
		$databasePosition = getDatabasePosition($ar[$q]['MLSNumber']);
		if ($databasePosition) {
			$ar[$q]["Latitude"] = $databasePosition['latitude'];
			$ar[$q]["Longitude"] = $databasePosition['longitude'];
		} else {
			echo "Does not already exist\n";
			$url = 'http://dev.virtualearth.net/REST/v1/Locations?CountryRegion=US&adminDistrict=' . urlencode($ar[$q]["StateOrProvince"]) . '&postalCode=' . urlencode($ar[$q]["PostalCode"]) . '&addressLine=' . urlencode($ar[$q]["FullStreetNum"]) . '&maxResults=1&key=' . getMapKey();
			$geo = file_get_contents($url);
			$geo = json_decode($geo, true);
			if (!$geo['resourceSets'][0]['resources'][0]['point']['coordinates']) {
				echo 'Geocoding failed\n';
			} else {
				$lat = $geo['resourceSets'][0]['resources'][0]['point']['coordinates'][0];
				$lng = $geo['resourceSets'][0]['resources'][0]['point']['coordinates'][1];
				addDatabasePosition($ar[$q]['MLSNumber'], $lat, $lng);
				$ar[$q]["Latitude"] = $lat;
				$ar[$q]["Longitude"] = $lng;
			}
		}
		$insertQuery = "INSERT INTO RetsData VALUES(" . getValue($ar, $q, 'MLSNumber') . ", " . getValue($ar, $q, "CurrentPrice") . ", " . getValue($ar, $q, 'PropertyType') . ", " . getValue($ar, $q, 'SqFtTotal') . ", " . getValue($ar, $q, 'BathsTotal') . ", " . getValue($ar, $q, 'BedsTotal') . ", " . getValue($ar, $q, 'FullStreetNum') . ", " . getValue($ar, $q, 'PostalCode') . ", " . getValue($ar, $q, 'Latitude') . ", " . getValue($ar, $q, 'Longitude') . ", " . getValue($ar, $q, 'City') . ", " . getValue($ar, $q, 'PhotoCount') . ", " . getValue($ar, $q, 'PublicRemarks') . ", '" . str_replace("'", "\'", getListKey($ar[$q])) . "', " . getValue($ar, $q, 'NumberOfLevels') . ", " . getValue($ar, $q, 'Fireplace') . ", " . getValue($ar, $q, 'HeatingSystem') . ", " . getValue($ar, $q, 'Pool') . ", " . getValue($ar, $q, 'WaterAmenities') . ", " . getValue($ar, $q, 'YearBuilt') . ", " . getValue($ar, $q, 'GarageSpaces') . ", " . getValue($ar, $q, 'PreviousPrice') . ", " . getValue($ar, $q, 'PriceChangeDate') . ", " . getValue($ar,$q,"ApproxLotSquareFoot") . ");";
		if (!mysqli_query($conn, $insertQuery)) {
			var_dump($insertQuery);
			die();
		}
	} else {
		$listPrice = mysqli_query($conn, "SELECT CurrentPrice FROM RetsData WHERE `MLSNumber`='" . $ar[$a]['MLSNumber'] . "';")->fetch_assoc()['CurrentPrice'];
		$date = getdate();
		if ($listPrice != $ar[$q]['CurrentPrice']) {
			$ar[$q]['PreviousPrice'] = $listPrice;
			$ar[$q]['PriceChangeDate'] = $date['mon'] . "/" . $date['mday'];
		} else if (sizeof($ar[$q]['PriceChangeDate']) && substr($date, 0, 1) != substr($ar[$q]['PriceChangeDate'], 0, 1)) {
			$ar[$q]['PreviousPrice'] = "";
			$ar[$q]['PriceChangeDate'] = "";
		}
		$updateQuery = "UPDATE RetsData SET `MLSNumber`=" . getValue($ar, $q, 'MLSNumber')  . ",`CurrentPrice`=" . getValue($ar, $q, 'CurrentPrice') . ",`PropertyType`=" . getValue($ar, $q, 'PropertyType') . ",`SqFtTotal`=" . getValue($ar, $q, 'SqFtTotal') . ",`BathsTotal`=" . getValue($ar, $q, "BathsTotal") . ",`BedsTotal`=" . getValue($ar, $q, 'BedsTotal') . ",`FullStreetNum`=" . getValue($ar, $q, 'FullStreetNum') . ",`PostalCode`=" . getValue($ar, $q, 'PostalCode') . ",`Latitude`=" . getValue($ar, $q, 'Latitude') . ",`Longitude`=" . getValue($ar, $q, 'Longitude') . ",`City`=" . getValue($ar, $q,'City') . ",`PhotoCount`=" . getValue($ar, $q, 'PhotoCount') . ",`PublicRemarks`=" . getValue($ar,$q,'PublicRemarks') . ",`ListOfficeName`='" . str_replace("'", "\'", getListKey($ar[$q])) . "',`NumberOfLevels`=" . getValue($ar, $q, 'NumberOfLevels') . ",`Fireplace`=" . getValue($ar, $q,'Fireplace') . ",`HeatingSystem`=" . getValue($ar, $q, "HeatingSystem") . ",`Pool`=" . getValue($ar, $q,'Pool') . ",`WaterAmenities`=" . getValue($ar,$q, 'WaterAmenities') . ",`YearBuilt`=" . getValue($ar, $q,'YearBuilt') . ",`GarageSpaces`=" . getValue($ar,$q,'GarageSpaces') . ",`PreviousPrice`=" . getValue($ar,$q,'PreviousPrice') . ",`PriceChangeDate`=" . getValue($ar,$q,'PriceChangeDate') . ",`ApproxLotSquareFoot`=" . getValue($ar,$q,'ApproxLotSquareFoot') . " WHERE `MLSNumber`='" . $ar[$q]['MLSNumber'] . "';";
		if (!mysqli_query($conn, $updateQuery)) {
			var_dump($updateQuery);
			die();
		}
	}
	$dir = "../images/rets/" . $ar[$q]['MLSNumber'];
	if (!file_exists($dir)) {
		mkdir($dir);
	} else if (file_exists($dir . "/0.jpg")) {
		// echo "Done\n";
		continue;
	}
	$photos = $rets->GetObject("Property", "Photo", $ar[$q]['Matrix_Unique_ID'], "*", 0);
	for ($i = 0; $i < 1; $i++) {
		file_put_contents($dir . "/" . $i . ".jpg", $photos[$i]->getContent());
	}
	$largeDir = "../images/largeRets/" . $ar[$q]['MLSNumber'];
	if (!file_exists($largeDir)) {
		mkdir($largeDir);
	} else if (iterator_count(new FilesystemIterator($largeDir, FilesystemIterator::SKIP_DOTS)) - 1 == $ar[$q]['PhotoCount']) {
		// echo "Done\n";
		continue;
	}
	echo "Downloading Large " . $ar[$q]['MLSNumber'] . "\n";
	// if (!file_exists($largeDir)) {
	// 	mkdir($largeDir);
	// }
	$largePhotos = $rets->GetObject("Property", "LargePhoto", $ar[$q]['Matrix_Unique_ID'], "*", 0);
	for ($i = 0; $i < count($largePhotos); $i++) {
		file_put_contents($largeDir . "/" . $i . ".jpg", $largePhotos[$i]->getContent());
	}
}
$_POST['functionname'] = 'sendEmail';
$_POST['body'] = "Records Updated";
include('apiRequests.php');

function getListKey($res) {
	return $res['ListOfficeName'] ? $res['ListOfficeName'] : ($res['CoListOfficeName'] ? $res['CoListOfficeName'] : ($res['SellingOfficeName'] ? $res['SellingOfficeName'] : ($res['CoSellingOfficeName'] ? $res['CoSellingOfficeName'] : 'Listing Office Not Found')));
}

function getValue($json, $i, $key) {
	$val = $json[$i][$key];
	$val = $val != NULL ? ("'" . str_replace("'", "\'", $val) . "'") : "''";
	return $val;
}
?>
