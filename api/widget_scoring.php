<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?

include '../include/database.php';
$db = new Database();  
$db->connect();

$id = $_REQUEST['id'];

$sql = "select * from loan_widget_docs where id=$id and status=1";
$db->sql($sql);
$res = $db->getResult();

$r = "Error";

if (count($res) == 1) {
	$r = json_encode($res);
	$arr = array(
			"score" => $res[0]['score'],
			"max_borrow" => $res[0]['max_borrow'],
			"apr" => $res[0]['apr'],
				);
	echo json_encode($arr);
}else {
	echo "0";
}


?>