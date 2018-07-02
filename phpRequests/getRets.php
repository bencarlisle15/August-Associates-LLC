<?php
	header('Content-Type: application/json');
	$my_file = 'rets-data.json';
	$handle = fopen($my_file, 'r');
	$result = fread($handle,filesize($my_file));
	fclose($handle);
	echo json_encode($result);
?>
