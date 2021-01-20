<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php'; ?>
<? require_once ('../api/function.php'); ?>
<?

$config = include '../include/configs.php';
$loan_doc_path = $config['LOAN_DOC_PATH'];

include '../include/database.php';
$db = new Database();  
$db->connect();

$id = $_REQUEST['id'];
$title = $_REQUEST['title'];
$score = -1;
$debit = 0;
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
	"doc_type" => $doctype,
	"legal_approve" => 0,
	"audit_approve" => 0,
	"score" => $score,
	"max_borrow" => $debit,

	"payperiod" => $payperiod,
	"duemonth" => $duemonth,
	
	);



if ($_FILES["filename1"]["name"] != '' && $_FILES["filename1"]["size"]>1) {
	$target_dir = $target_dir = dirname(__FILE__) .'/' . $loan_doc_path;
	$filename = $id . "_file1_" . basename($_FILES["filename1"]["name"]);
	$target_file = $target_dir . $filename;//basename($_FILES["filename1"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["filename1"]["tmp_name"], $target_file)) {
		$content = $target_file;
		$param['file1'] = str_replace("'", "\'", $filename);
	}
}

if ($_FILES["filename2"]["name"] != '' && $_FILES["filename2"]["size"]>1) {
	$target_dir = $target_dir = dirname(__FILE__) .'/' . $loan_doc_path;
	$filename = $id . "_file2_" . basename($_FILES["filename2"]["name"]);
	$target_file = $target_dir . $filename;//basename($_FILES["filename2"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["filename2"]["tmp_name"], $target_file)) {
		$content = $target_file;
		$param['file2'] = str_replace("'", "\'", $filename);
	}
}

if ($_FILES["filename3"]["name"] != '' && $_FILES["filename3"]["size"]>1) {
	$target_dir = $target_dir = dirname(__FILE__) .'/' . $loan_doc_path;
	$filename = $id . "_file3_" . basename($_FILES["filename3"]["name"]);
	$target_file = $target_dir . $filename;//basename($_FILES["filename3"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["filename3"]["tmp_name"], $target_file)) {
		$content = $target_file;
		$param['file3'] = str_replace("'", "\'", $filename);
	}
}

if ($_FILES["filename4"]["name"] != '' && $_FILES["filename4"]["size"]>1) {
	$target_dir = $target_dir = dirname(__FILE__) .'/' . $loan_doc_path;
	$filename = $id . "_file4_" . basename($_FILES["filename4"]["name"]);
	$target_file = $target_dir . $filename;//basename($_FILES["filename4"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["filename4"]["tmp_name"], $target_file)) {
		$content = $target_file;
		$param['file4'] = str_replace("'", "\'", $filename);
	}
}

// var_dump($param);

$db->update("loan_documents_v2", $param,"id=$id");
$r = sendComitteeEmail("");

echo "1";
// header("Location:index.php");

?>