<?php
	$URL = "https://$_SERVER[HTTP_HOST]";
	header("Content-type: application/json");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Allow-Origin: *.ampproject.org/*");
	header("AMP-Access-Control-Allow-Source-Origin: " . $URL);
	header("Access-Control-Allow-Origin: ". str_replace('.', '-', $URL . '/*') .".cdn.ampproject.org");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Expose-Headers: AMP-Access-Control-Allow-Source-Origin");
	$inputs = array("searchAddresses", "searchCities", "searchZips", "searchPropertyType", "searchMinPrice", "searchMaxPrice", "searchMinFeet", "searchMaxFeet");
	$urlAdd = "";
	foreach ($inputs as $input) {
		$val = $_POST[$input];
		if ($val != '') {
			$urlAdd = $urlAdd . strlen($urlAdd) > 0 ? "&" : "?" . $input . "=" . $val;
		}
	}
	header('AMP-Redirect-To:' . $URL . '/find-homes.php' . $urlAdd);
	echo json_encode("success");
?>
