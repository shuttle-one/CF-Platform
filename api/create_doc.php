<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?

include 'encrypt.php';
$config = include ('config.php');

$context = $config['CONTEXT'];
$url = $config["CREATE_DOC"];

$addr = "";
$tokenid = 0;
$docid = 0;
$doctype = 0;
// doctype 1 = invoice,2 ทะเบียนรถ 3  ที่ดิน

$url = $url . $addr . "/" .$tokenid . "/" . $docid . "/" . $doctype . "/test";
$after = encrypt($url);
$url = $context . $after;

$res = file_get_contents($url);
echo $res;

?>