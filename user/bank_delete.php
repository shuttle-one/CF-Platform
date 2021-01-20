<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?
$bid = $_REQUEST['id'];
$userid = $_SESSION['userid'];

include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "delete from loan_bank_account where id=$bid and userid=$userid";
if ($db->sql($sql)) {
	echo 1;
}else 
	echo $sql;
?>