<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? require_once ('../api/function.php'); ?>
<?

$config = include '../include/configs.php';
$loan_doc_path = $config['LOAN_DOC_WIDGET_PATH'];

include '../include/database.php';
$db = new Database();  
$db->connect();



$param = array(
		"score" => 0,
		"max_borrow" => 0,
		"status" => 0,
		);

if ($_FILES["file1"]!=null) {
	if ($_FILES["file1"]!=null && $_FILES["file1"]["name"] != '' && $_FILES["file1"]["size"]>1) {
		$target_dir = $loan_doc_path;//"../assets/docs/";
		$filename = basename($_FILES["file1"]["name"]);
		$target_file = $target_dir . $filename;//basename($_FILES["file1"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file)) {
			$content = $target_file;
			$param['file1'] = str_replace("'", "\'", $filename);
		}
	}
}


if ($_FILES["file2"]!=null && $_FILES["file2"]["name"] != '' && $_FILES["file2"]["size"]>1) {
	$target_dir = $loan_doc_path;//"../assets/docs/";
	$filename = basename($_FILES["file2"]["name"]);
	$target_file = $target_dir . $filename;//basename($_FILES["file2"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["file2"]["tmp_name"], $target_file)) {
		$content = $target_file;
		$param['file2'] = str_replace("'", "\'", $filename);
	}
}

if ($_FILES["file3"]!=null && $_FILES["file3"]["name"] != '' && $_FILES["file3"]["size"]>1) {
	$target_dir = $loan_doc_path;//"../assets/docs/";
	$filename = basename($_FILES["file3"]["name"]);
	$target_file = $target_dir . $filename;//basename($_FILES["file3"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["file3"]["tmp_name"], $target_file)) {
		$content = $target_file;
		$param['file3'] = str_replace("'", "\'", $filename);
	}
}


if ($_FILES["file4"]!=null && $_FILES["file4"]["name"] != '' && $_FILES["file4"]["size"]>1) {
	$target_dir = $loan_doc_path;//"../assets/docs/";
	$filename = basename($_FILES["file4"]["name"]);
	$target_file = $target_dir . $filename;//basename($_FILES["file4"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["file4"]["tmp_name"], $target_file)) {
		$content = $target_file;
		$param['file4'] = str_replace("'", "\'", $filename);
	}
}


$docID = 0;

// var_dump($param);
// return;
//---- CREATE DOCUMENTS


if ($db->insert("loan_widget_docs", $param))
{
	$r = sendComitteeEmail("");
	$docRes = $db->getResult();
	$docID = $docRes[0];
	echo $docID;
}
else {
	echo 0;
}

// header("Location:index.php");
?>