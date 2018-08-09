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
// $data = $results->toJSON();
$ar = array_merge($results->toArray(), $results2->toArray());
echo "Start Photos\n";
for ($q = 0; $q < sizeof($ar); $q++) {
	echo $q . " of " . count($ar) . "\n";
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
	$dir = "../images/rets/" . $ar[$q]['MLSNumber'];
	// if (file_exists($dir)) {
	// 	// echo 'Already exists' . "\n";
	// 	continue;
	// } else {
	// 	echo "New Folder\n";
	// }
	if (!file_exists($dir)) {
		mkdir($dir);
	} else if (iterator_count(new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS)) - 1 == $ar[$q]['PhotoCount']) {
		// echo "Done\n";
		continue;
	}
	echo "Downloading " . $ar[$q]['MLSNumber'] . "\n";
	// if (!file_exists($dir)) {
	// 	mkdir($dir);
	// }
	$photos = $rets->GetObject("Property", "Photo", $ar[$q]['Matrix_Unique_ID'], "*", 0);
	for ($i = 0; $i < count($photos); $i++) {
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
$data = json_encode($ar);
$conn = new mysqli("localhost", getDBUser(), getDBPassword(), getDBName());
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error . "\n");
}
if (mysqli_query($conn, "SELECT COUNT(*) FROM RetsData")) {
	$query = "UPDATE RetsData SET json_data='" . $conn->real_escape_string($data) . "'";
} else {
	$query = "INSERT INTO RetsData json_data='" . $conn->real_escape_string($data) . "'";
}
mysqli_query($conn, $query);
echo "Successfully updated\n";
$_POST['functionname'] = 'sendEmail';
$_POST['body'] = "Records Updated";
include('apiRequests.php');
?>
