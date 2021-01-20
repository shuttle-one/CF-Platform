<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';

require_once ('../api/function.php');


$userid = $_SESSION['userid'];

$bank_account = $_REQUEST['bank_account'];
$amount = $_REQUEST['amount'];
$countrycode = $_REQUEST['country'];

$sectionid = $_SESSION['sectionid'];

include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "select * from loan_bank_account where id='$bank_account'";
$db->sql($sql);
$res = $db->getResult();

$success = 0;

if (count($res)==1) {
	$name = $res[0]['account_name'];
	$account_number = $res[0]['account_number'];
	$swiftcode = $res[0]['swift_code'];
	$country = $res[0]['country'];
	$bank_name = $res[0]['bank_name'];

	$r = withdrawBank($sectionid, $name, $account_number, $swiftcode, $country, $amount, $countrycode, $bank_name);

	if ($r['code']==0) {
		$success = 1;
	}else {
		$err = $r['data'];
	}

}

var_dump($r);
return;

$param = array(
		"userid" => $userid,
		"accountid" => $bank_account,
		"amount" => $amount,
		);

if ( ($success==1) && $db->insert("loan_withdraw", $param)) {
?>
<script>
	alert("Withdraw Success");
	window.location.href = "wallets.php";
</script>
<?
	// header("Location:wallets.php");
} else {
$e01 = explode("\n",$err)[0];
$e02 = explode("\n",$err)[1];
?>
 <script>

	alert("Have an error, Please try again. Error : <?=$e01?> <?=$e02?>");
	window.location.href = "wallet_withdraw.php";
</script>
 <?
}

?>