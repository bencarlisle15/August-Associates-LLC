<?php
	$URL = "https://$_SERVER[HTTP_HOST]";
	header("Content-type: application/json");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Allow-Origin: *.ampproject.org/*");
	header("AMP-Access-Control-Allow-Source-Origin: " . $URL);
	header("Access-Control-Allow-Origin: ". str_replace('.', '-', $URL . '/*') .".cdn.ampproject.org");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Expose-Headers: AMP-Access-Control-Allow-Source-Origin");
	$_POST['functionname'] = 'sendEmail';
	$_POST['body'] = "Source: Website Home Page Contact Form\nName: " . $_POST['contactFormName'] . "\nEmail: " . $_POST['contactFormEmail'] . "\nPhone: " . $_POST['contactFormPhone'] . "\nAddress: \nMLS Number: \nNotes: " . $_POST['contactFormText'];
	include('apiRequests.php');
	echo json_encode([]);
?>
