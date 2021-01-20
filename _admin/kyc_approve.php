<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?

$walletid = $_REQUEST['id'];

include '../include/database.php';
$db = new Database();  
$db->connect();


$sql = "update loan_account set kycstatus=2 where userid=$walletid";

if ($db->sql($sql)) {

	$sql = "update wallet_data set kyc=1 where walletid=$walletid";
	if ($db->sql($sql)) {
		echo 1;
	}else 
		echo 2;

}else 
	echo 3;

?>