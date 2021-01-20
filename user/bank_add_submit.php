<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?
$userid = $_SESSION['userid'];
$account_name = $_REQUEST['account_name'];
$bank_name = $_REQUEST['bank_name'];
$bank_branch = $_REQUEST['branch'];
$account_number = $_REQUEST['account_number'];
$swiftcode = $_REQUEST['swiftcode'];
$country = $_REQUEST['country'];


$nextURL = "user-profile.php?t=3";


include '../include/database.php';
$db = new Database();  
$db->connect();

$param = array(
	"userid" => $userid,
	"account_name" => $account_name,
	"bank_name" => $bank_name,
	"bank_branch" => $bank_branch,
	"account_number" => $account_number,
	"swift_code" => $swiftcode,
	"country" => $country
	);

if ($db->insert("loan_bank_account",$param)) {
	//echo "Success";
	$nextURL = "user-profile.php?t=3";
}

header("Location:$nextURL");

?>