<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?
$id = $_REQUEST['id'];

include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "insert into loan_documents_deleted select *, now() from loan_documents_v2 where id=$id";
if ($db->sql($sql)) {
	$sql = "delete from loan_documents_v2 where id=$id";
	$db->sql($sql);
	echo '1';
}
else 
	echo '0';

?>