<?php
	require_once '../vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php';
	$detect = new Mobile_Detect;
	if ($detect->isMobile() || substr($_SERVER[HTTP_HOST], 0, 5) == "www.m" || $_SERVER[HTTP_HOST][0] == 'm') {
		include('wendyAmp.php');
	} else {
		include('wendyDesktop.php');
	}
?>
