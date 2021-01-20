<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php'; ?>
<? require_once ('../api/function.php'); ?>
<?

function moveFile($id, $filename) {

	$hasDir = false;
	$source = "../assets/docs/" . $filename;
	$directory = "../ipfs/ratdoc/d" . $id;

	if (is_dir($directory)) {
		$hasDir = true;
	}else 
	{
		if (mkdir($directory))
			$hasDir = true;
	}
	
	if ($hasDir) {
		$target = $directory . "/" . $filename;
		if (!copy($source, $target)) {
			// echo "Fail to copy ";
			$errors= error_get_last();
		    return "COPY ERROR: ".$errors['type'];
		}else 
			return "Success";

	}else 
		return "Cant make dir";
}


include '../include/database.php';
$db = new Database();  
$db->connect();

$id = $_REQUEST['id'];
$userid = $_SESSION['userid'];
$usertype = $_SESSION['usertype'];
$sectionid = $_SESSION['sectionid'];
$config = include ('../api/config.php');

$sql = "select * from loan_documents_v2 where userid=$userid and usertype=$usertype and id=$id and status=0";
if ($config['TEST']==1)
      $sql .= " and test=1 ";
  else $sql .= " and test=0 ";
$db->sql($sql);
$res = $db->getResult();

$success = 1;

if (count($res) == 1) { // CHECK DOCUMENTS IS OWN LOGIN USER.
	$docid = $res[0]['id'];
	$doctype = $res[0]['doc_type'];
	$ethaddress = $_SESSION['useraddress'];

	$sql = "select * from loan_token where docid=$docid and userid=$userid";
	$db->sql($sql);
	$tokenRes = $db->getResult();


	if (count($tokenRes)>0) {
	// if (count($tokenRes)==1)
		$tokenid = $tokenRes[0]['tokenid'];
	// else if (count($tokenRes)>1) {

	// 	echo "Duplicate Docid ";// . $count($tokenRes);
	// 	return;
	// }
	} else {
		echo "Token Fail ". " : Not found docid : " . $docid;
		return;
	}

	//----- COPY DOCS TO IPFS

		$file1 = $res[0]['file1'];
		$file2 = $res[0]['file2'];
		$file3 = $res[0]['file3'];
		$file4 = $res[0]['file4'];

		if ($file1 != '') 
			moveFile($id, $file1);
		if ($file2 != '') 
			moveFile($id, $file2);
		if ($file3!= '') 
			moveFile($id, $file3);
		if ($file4 != '') 
			moveFile($id, $file4);
		
	$arr = callCreateDoc($sectionid, $tokenid, $docid, $doctype, 'test');

	if ($arr['code']=="0")  {
		$txhash  = $arr['data']['txHash'];
		$sql = "update loan_documents_v2 set txhash='$txhash',status=1 where id=$id";
		$db->sql($sql);

		

		
		//----- CALL SEND EMAIL TO ADMIN FOR SUBMIT
		// $r = sendComitteeEmail("");
		// echo "Return from send email = $r";

	}

	else  {
		// $err = $arr['data'];
		$sql = "update loan_documents_v2 set txhash='$err' where id=$id";
		$db->sql($sql);
		$success = 0;
		$success = $arr['data'];
	}

}



echo $success;

// header("Location:document.php");

?>