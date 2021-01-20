<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?

$id = $_REQUEST['id'];
$userid = $_SESSION['userid'];
$config = include ('../api/config.php');

include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "insert into loan_documents_deleted select *, now() from loan_documents_v2 where id=$id";
if ($db->sql($sql)) {
	$sql = "delete from loan_documents_v2 where id=$id and userid=$userid";
	if ($config['TEST']==1)
    	$sql .= " and test=1 ";
    else $sql .= " and test=0 ";
	$db->sql($sql);
	echo '1';
}
else 
	echo '0';

?>