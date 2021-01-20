<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?

$userid = $_REQUEST['uid'];
$country = $_REQUEST['c'];

include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "select * from loan_bank_account where userid='$userid' and country='$country'";
$db->sql($sql);
$bankRes = $db->getResult();

$param = array(
"code" => 0,
"data" => $bankRes);

echo json_encode($param,true);
?>