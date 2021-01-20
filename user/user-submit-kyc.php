<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?

$userid = $_SESSION['userid'];

include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "select * from loan_account where id=$userid";
$db->sql($sql);
$acc = $db->getResult();




$err = "";

if (count($acc)==1) {
	// if ($acc[0]['usertype']==1) {
		$walletid = $acc[0]['userid'];

		$sql = "update loan_account set kycstatus=1 where id=$userid";
		$db->sql($sql);
		
		$err = 1;

	// } else {
	// 	$err = "Only user can KYC";
	// }
}else {
	$err = "Not found account";
}

echo $err;

?>