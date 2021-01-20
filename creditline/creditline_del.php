<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php'; ?>
<?
include '../include/database.php';
$db = new Database();  
$db->connect();

$id = $_REQUEST['cid'];
$sql = "insert into loan_contract_deleted select *,now() from loan_contract where id='$id'";
if ($db->sql($sql)) {
	$sql = "delete from loan_contract_v2 where id='$id'";
	$db->sql($sql);
	echo "1";
}else 
	echo "0";

?>