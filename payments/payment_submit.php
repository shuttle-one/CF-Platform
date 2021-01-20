<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?

$config = include ('../api/config.php');


include '../include/database.php';
$db = new Database();  
$db->connect();

$loanid = $_REQUEST['loanid'];
$amount = $_REQUEST['amount'];
$txhash = $_REQUEST['txhash'];
$userid = $_SESSION['userid'];

$test = $config['TEST'];

$param = array(
			"contractid" => $loanid,
			"amount" => $amount,
			"txhash" => $txhash,
			"userid" => $userid,
			"test" => $test,
			);

// var_dump($param);

if ($db->insert("loan_repay",$param))
{
	?>
	<script>
		alert("Success");
		window.location.href = "payment_list.php";
	</script>
	<?
}else {
	?>
	<script>
		alert("Fail update DB");
		window.history.back();
	</script>
	<?
}

?>