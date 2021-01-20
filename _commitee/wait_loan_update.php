<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? //include '../include/commitee_authen.php'; 
session_start();
?>
<? require_once ('../api/function.php'); ?>
<?
include '../include/database.php';
$db = new Database();  
$db->connect();


$maxborrow = $_REQUEST['m'];
$apr = $_REQUEST['a'];
$loanid = $_REQUEST['id'];
$approve = $_REQUEST['s'];
$score = $_REQUEST['sc'];

$userid = $_SESSION['userid'];
$admin_type = $_REQUEST['type'];


$config = include ('../api/config.php');

if ($approve==3) {
	$sql = "update loan_documents_v2 set status=3 where id=" . $loanid;
	if ($config['TEST']==1)
      $sql .= " and test=1 ";
  	else $sql .= " and test=0 ";

	if ($db->sql($sql)) {
		echo 1;
	}

	return;
}

//------ CHECK ACCOUNT ROLE 
$sql = "select * from loan_commitee where id=$userid";
$db->sql($sql);
$res = $db->getResult();
$role = $res[0]['commitee_type'];
$wallet_addr = $res[0]['wallet_addr'];
$username = $res[0]['name'] . " " . $res[0]['surname'] . "[" .$res[0]['email'] ."]";


$param = array(
	"max_borrow" => $maxborrow,
	// "apr" => $apr,
	// "debit" => $debit,
	"status" => $approve,
	"score" => $score,
	// "id" =>$loanid,
	
);

//----- GET EMAIL FOR CONFIRM 

$ownerEmail = '';

// $sql = "SELECT acc.* FROM `loan_documents_v2` doc left join loan_account acc on doc.userid=acc.id where doc.id=$loanid";

$sql = "SELECT acc.*,token.tokenid FROM `loan_documents_v2` doc left join loan_account acc on doc.userid=acc.id left join loan_token token on doc.id=token.docid where doc.id=$loanid";
if ($config['TEST']==1)
  $sql .= " and doc.test=1 ";
else $sql .= " and doc.test=0 ";

$db->sql($sql);
$res = $db->getResult();
if (count($res) == 1) {
	$type = $res[0]['usertype'];
	$accountid = $res[0]['userid'];

	if ($type==1) { // USER
		$sql = "select * from wallet_data where walletid='$accountid'";
		$db->sql($sql);
		$accRes = $db->getResult();
	}else if ($type==2) { // PARTNER
		$sql = "select * from partner_data where partnerid='$accountid'";
		$db->sql($sql);
		$accRes = $db->getResult();
	}

	if (count($accRes) == 1) {
		$email = $accRes[0]['email'];
	}

	$ownerEmail = $email;

	$tokenid = $res[0]['tokenid'];
}


//------ END GET EMAIL ----//

$txhash = '';
$borrow = ($score * $maxborrow) / 100;
$r = "";
if ($role == 2) { // Legal
	$r = legalApprove($wallet_addr, $tokenid , "test");
}else if ($role == 3) {
	$r = auditApprove($wallet_addr, $tokenid, $borrow, $score, $apr, "test");
}else if ($role==4) { //SUPERADMIN
	if ($admin_type=='audit') {
		$r = auditApprove($wallet_addr, $tokenid, $borrow, $score, $apr , "test");
	}else if ($admin_type=='legal') {
		$r = legalApprove($wallet_addr, $tokenid , "test");
	}
}


if ($r['code']=='0') {
	$txhash = $r['data']['txHash'];
}else 
	$txhash = $r['data'];


if ($r['code']=='0') {
	if ($role == 2) { // LEGAL
		$param['legal_approve'] = 1;
		$param['legal_approve_date'] = date("Y-m-d h:i:s");
		$param['legal_name'] = $username;
		$param['legal_txhash'] = $txhash;
	} else if ($role == 3) { // AUDIT
		$param["apr"] = $apr;
		$param['max_borrow'] = $maxborrow;
		$param['audit_approve'] = 1;
		$param['audit_approve_date'] = date("Y-m-d h:i:s");
		$param['audit_name'] = $username;
		$param['audit_txhash'] = $txhash;
	} else if ($role == 4) { // SUPER ADMIN
		if ($admin_type=='legal') {
			$param['legal_approve'] = 1;
			$param['legal_approve_date'] = date("Y-m-d h:i:s");
			$param['legal_name'] = $username;
			$param['legal_txhash'] = $txhash;
		} else if ($admin_type=='audit') {
			$param["apr"] = $apr;
			$param['max_borrow'] = $maxborrow;
			$param['audit_approve'] = 1;
			$param['audit_approve_date'] = date("Y-m-d h:i:s");
			$param['audit_name'] = $username;
			$param['audit_txhash'] = $txhash;
		}
	}

	// var_dump($param);
	// return;
	
	if ($db->update("loan_documents_v2", $param, "id=$loanid"))
	{
		$sql = "select * from loan_documents_v2 where legal_approve=1 and audit_approve=1 and id=$loanid";
		if ($config['TEST']==1)
      		$sql .= " and test=1 ";
      	else $sql .= " and test=0 ";
      	
		$db->sql($sql);
		$docRes = $db->getResult();

		if (($ownerEmail!='') && (count($docRes)==1)) {
			$r = sendApprovedEmail($ownerEmail);
		}

			if (($role==3) || ($admin_type=='audit')) { // AUDITOR //SUPERADMIN
				$param = array(
					"docid" => $loanid,
					"debt" => $maxborrow,
					"score" => $score,
					"approve_by" => $username,
				);

				$db->insert("loan_approved_log", $param);
			}

		echo 1;
	}
	else echo 0;
}
else {
	echo $txhash;
}

?>