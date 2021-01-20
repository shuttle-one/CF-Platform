<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? require_once ('../api/function.php'); ?>
<?

$wallet = $_REQUEST['w'];

if ($wallet != '') {
	$res = checkKYC($wallet);
}

echo $res;

?>