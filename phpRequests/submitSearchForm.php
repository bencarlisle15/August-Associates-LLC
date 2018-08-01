<?php
	$URL = "https://$_SERVER[HTTP_HOST]";
	header("Content-type: application/json");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Allow-Origin: *.ampproject.org/*");
	header("AMP-Access-Control-Allow-Source-Origin: " . $URL);
	header("Access-Control-Allow-Origin: ". str_replace('.', '-', $URL . '/*') .".cdn.ampproject.org");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Expose-Headers: AMP-Access-Control-Allow-Source-Origin");
	$inputs = ["searchAddresses", "searchCities", "searchZips", "searchPropertyType", "searchMinPrice", "searchMaxPrice", "searchMinFeet", "searchMaxFeet", "searchBeds", "searchBaths", "sortArray", "searchAreaInput"];
	$urlAdd = "";
	foreach ($inputs as $input) {
		$val = $_POST[$input];
		if ($val != '') {
			if ($input == "searchMinPrice" || $input == "searchMaxPrice") {
				$val = str_replace(",", "", str_replace("$", "", $val));
			}
			if ($input == "searchAreaInput") {
				$urlAdd .= (strlen($urlAdd) > 0 ? "&" : "?") . $val;
			} else {
				$urlAdd .= (strlen($urlAdd) > 0 ? "&" : "?") . $input . "=" .  str_replace(' ', '-', $val);
			}
		}
	}
	if (!$detect) {
		require_once '../vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php';
		$detect = new Mobile_Detect;
	}
	if ($detect->isMobile() || substr($_SERVER[HTTP_HOST], 0, 5) == "www.m" || $_SERVER[HTTP_HOST][0] == 'm') {
		header("AMP-Redirect-To: " . $URL . '/find-homes' . $urlAdd);
	} else {
		header("Location: " . $URL . '/find-homes' . $urlAdd);
	}
	echo json_encode([]);
?>
