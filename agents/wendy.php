<?php
	require_once '../vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php';
	$detect = new Mobile_Detect;
	if ($detect->isMobile()) {
		include('wendyAmp.php');
	} else {
		include('wendyDesktop.php');
	}
?>
