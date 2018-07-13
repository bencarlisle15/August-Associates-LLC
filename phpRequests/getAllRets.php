<?php
	$my_file = 'rets-data.json';
	$handle = fopen($my_file, 'r');
	$result = fread($handle,filesize($my_file));
	fclose($handle);
	$json = json_decode($result, true);
	foreach ($_POST as $key => $val) {
		if ($key == "pageNumber") {
			continue;
		}
		$lastChar = substr($val, -1);
		$change = 0;
		if ($lastChar == ">") {
			$change = 1;
			$val = substr($val, 0 , -1);
		} else if ($lastChar == "<") {
			$change = -1;
			$val = substr($val, 0 , -1);
		}
		for ($q = 0; $q < sizeof($json); $q++) {
			if ($change == 0 && (is_int($json[$q][$key]) ? ($json[$q][$key] != $val) : (strtolower($json[$q][$key]) != strtolower($val) && strpos(strtolower($val), strtolower($json[$q][$key])) === false)) || $change == -1 && $json[$q][$key] > $val || $change == 1 && $json[$q][$key] < $val) {
				unset($json[$q]);
				$q--;
				$json = array_values($json);
			}
		}
	}
	$perPage = 40;
	$first = array_slice($json, $_POST["pageNumber"] * $perPage, ($_POST["pageNumber"] + 1) * $perPage);
	echo json_encode(json_encode($first));
?>
