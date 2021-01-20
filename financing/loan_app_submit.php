<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php'; ?>
<? require_once ('../api/function.php'); ?>
<?
$webConfig = include '../api/config.php';
$config = include '../include/configs.php';
$loan_doc_path = $config['LOAN_DOC_PATH'];

require_once ('../include/database.php');
$db = new Database();  
$db->connect();

$title = $_REQUEST['title'];
$score = -1;
$debit = -1;
$status = 0;
$userid = $_SESSION['userid'];
$usertype = $_SESSION['usertype'];

$doctype = $_REQUEST['doctype'];
$payperiod = $_REQUEST['payperiod'];
$duemonth = $_REQUEST['duemonth'];

$param = array(
	"userid" => $userid,
	"usertype" => $usertype,
	"title" => $title,
	"score" => $score,
	"doc_type" => $doctype,
	"status" => $status,
	"max_borrow" => $debit,

	"payperiod" => $payperiod,
	"duemonth" => $duemonth,
	);



$isTest = $webConfig['TEST'];
if ($isTest == 1) 
	$param['test'] = 1;
else 
	$param['test'] = 0;



if ($_FILES["file1"]!=null) {
	if ($_FILES["file1"]!=null && $_FILES["file1"]["name"] != '' && $_FILES["file1"]["size"]>1) {
		$target_dir = dirname(__FILE__) .'/' . $loan_doc_path;
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
	$target_dir = dirname(__FILE__) .'/' . $loan_doc_path;//"../assets/docs/";
	$filename = basename($_FILES["file2"]["name"]);
	$target_file = $target_dir . $filename;//basename($_FILES["file2"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["file2"]["tmp_name"], $target_file)) {
		$content = $target_file;
		$param['file2'] = str_replace("'", "\'", $filename);
	}
}

if ($_FILES["file3"]!=null && $_FILES["file3"]["name"] != '' && $_FILES["file3"]["size"]>1) {
	$target_dir = dirname(__FILE__) .'/' . $loan_doc_path;//"../assets/docs/";
	$filename = basename($_FILES["file3"]["name"]);
	$target_file = $target_dir . $filename;//basename($_FILES["file3"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["file3"]["tmp_name"], $target_file)) {
		$content = $target_file;
		$param['file3'] = str_replace("'", "\'", $filename);
	}
}


if ($_FILES["file4"]!=null && $_FILES["file4"]["name"] != '' && $_FILES["file4"]["size"]>1) {
	$target_dir = dirname(__FILE__) .'/' . $loan_doc_path;//"../assets/docs/";
	$filename = basename($_FILES["file4"]["name"]);
	$target_file = $target_dir . $filename;//basename($_FILES["file4"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["file4"]["tmp_name"], $target_file)) {
		$content = $target_file;
		$param['file4'] = str_replace("'", "\'", $filename);
	}
}


$docID = 0;
// echo $target_file;
// var_dump($param);
// return;
//---- CREATE DOCUMENTS


if ($db->insert("loan_documents_v2", $param))
{
	// $r = sendComitteeEmail("");
	$docRes = $db->getResult();
	$docID = $docRes[0];
	$r = sendComitteeEmail("");
}

//---- CREATE TOKEN

if ($docID != 0) {
	$param = array(
		"docid" => $docID,
		"doctype" => 0,
		"loanid" => 0,
		"userid" => $_SESSION['userid'],
	);
	$db->insert("loan_token", $param);
}

echo "1";

// header("Location:index.php");
?>