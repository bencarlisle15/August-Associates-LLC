<?php
require_once("../vendor/autoload.php");
$config = new \PHRETS\Configuration;
$config->setLoginUrl('http://sample.data.crea.ca/Login.svc/Login');
$config->setUsername('CXLHfDVrziCfvwgCuL8nUahC');
$config->setPassword('mFqMsCSPdnb5WO1gpEEtDCHH');

// optional.  value shown below are the defaults used when not overridden
$config->setRetsVersion('1.8'); // see constants from \PHRETS\Versions\RETSVersion
$config->setUserAgent('');
$config->setOption('use_post_method', true); // boolean
$config->setOption('disable_follow_location', false);
$rets = new \PHRETS\Session($config);
$bulletin = $rets->Login();
echo $bulletin;
var_dump($bulletin);
$system = $rets->GetSystemMetadata();
$resources = $system->getResources();
$classes = $rets->GetClassesMetadata('Property');
$objects = $rets->GetObject('Property', 'Photo', '00-1669', '*', 1);
$fields = $rets->GetTableMetadata('Property', 'A');
$results = $rets->Search($resource, $class, $query);
$data = $results->toJSON();
var_dump($data);
echo $data;
$my_file = 'rets-data.json';
$handle = fopen($my_file, 'w');
fwrite($handle, $data);
fclose($handle);
?>
