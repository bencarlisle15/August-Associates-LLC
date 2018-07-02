<?php
	header("Content-type: application/json");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Allow-Origin: *.ampproject.org");
	header("AMP-Access-Control-Allow-Source-Origin: https://www.nswecompass.com");
	header("Access-Control-Allow-Origin: ". str_replace('.', '-','https://www.nswecompass.com') .".cdn.ampproject.org");
	$_POST['functionname'] = 'sendEmail';
	$body = "Source: Website Home Page Contact Form\nName: " . $_POST['name'] . "\nEmail: " . $_POST['email'] . "\nPhone: " . $_POST['phone'] . "\nAddress: \nMLS Number: \nNotes: " . $_POST['text'];
	$_POST['body'] = $body;
	include('apiRequests.php');
	echo json_encode("success");
?>
