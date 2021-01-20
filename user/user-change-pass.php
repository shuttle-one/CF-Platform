<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?
$userid = $_SESSION['userid'];
$oldpass = $_REQUEST['oldp'];
$pass1 = $_REQUEST['np1'];

include '../include/database.php';
$db = new Database();  
$db->connect();

$err = "";
$code = 0;

$sql = "select * from loan_account acc inner join wallet_data w on acc.userid=w.walletid where acc.id=$userid";
$db->sql($sql);
$accRes = $db->getResult();


if (count($accRes)==1) {
	$walletid = $accRes[0]['walletid'];
	$currPass = $accRes[0]['password'];
	if ($oldpass == $currPass) {
		// $err = "Ready to change passwrd";
		$sql = "update wallet_data set password='$pass1' where walletid=$walletid";
		// $err = $sql;
		if ($db->sql($sql))
			$err = "Success";
		else 
			$err = "Fail change password";
	}else {
		$err = "Old password Not match";
	}
}else {
	$err = "Not found";
}

$param = array(
		"code" => $code,
		"data" => $err
		);

echo json_encode($param);
?>