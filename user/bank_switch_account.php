<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?

$userid = $_SESSION['userid'];
$id = $_REQUEST['id'];

include '../include/database.php';
$db = new Database();  
$db->connect();

$s = 1;

$sql = "update loan_bank_account set isuse=0 where userid=$userid";
if ($db->sql($sql)) {
	$sql = "update loan_bank_account set isuse='1' where id=$id and userid=$userid";
	if ($db->sql($sql)) {
		$s = 1;
	}
}

echo $s;

?>