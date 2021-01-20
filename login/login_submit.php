<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?

session_start();
$id = session_id();
header("Set-Cookie: PHPSESSID=$id; path=/; httpOnly; SameSite=None; secure;");

$email = $_REQUEST['email'];
$pass = $_REQUEST['pass'];
$role = $_REQUEST['role'];


include '../api/function.php';

//*------ LOGIN SERVER SECTION ---//
$loginArr = login($email, $pass);
$userimage = "";

if ($loginArr['code']=='0') {
	$sectionid = $loginArr['data']['sectionid'];
	
	$userdetail = userDetail($sectionid);
	$userimage = $userdetail['image'];

}
else {
	header("Location:login.php?e=3");
}

// var_dump($userdetail);
// return;
//*----- END LOGIN SERVER SECTION ---//


$isadmin = 0;
$userid = 0;
$accountType = 0; // 1: user 2 : agent//company;
$nextURL = "";

include '../include/database.php';
$db = new Database();  
$db->connect();


if ($role == 'user') {
	$sql = "select * from wallet_data where email='$email'";
	$db->sql($sql);
	$userRes = $db->getResult();

	// $sql = "select * from partner_admin_account where username='$email'";
	$sql = "select * from partner_data where email='$email'";
	$db->sql($sql);
	$companyResult = $db->getResult();

	if (count($userRes)==1) {
		if ($userRes[0]['password']==$pass) {
			$userid = $userRes[0]['walletid'];
			$wallet_address = $userRes[0]['eth_wallet'];
			$accountType = 1;
		}
	} else if (count($companyResult)==1) {
		if ($companyResult[0]['password']==$pass) {
			$userid = $companyResult[0]['partnerid'];
			$wallet_address = $companyResult[0]['wallet_addr'];
			$accountType = 2;
		}
	}

	$nextURL = "../financing/";

} 
else if ($role == 'admin') {
	$sql = "select * from loan_commitee where email='$email'";//" and commitee_type=1";
	$db->sql($sql);
	$res = $db->getResult();
	if (count($res) == 1) {
		if ($res[0]['commitee_type']==1) {
			$userid = $res[0]['id'];
			$accountType = 3;
			$wallet_address = '';
			$isadmin = 1;

			$nextURL = "../_admin/user_list.php";


		}

	}


} else if ($role == 'audit') {
	$sql = "select * from loan_commitee where email='$email' and commitee_type=3";
	$db->sql($sql);
	$res = $db->getResult();
	if (count($res) == 1) {
		$userid = $res[0]['id'];
		$accountType = 3;
		$wallet_address = '';
	}

	$nextURL = "../_commitee/wait_list.php";

} else if ($role == 'legal') {
	$sql = "select * from loan_commitee where email='$email' and commitee_type=2";
	$db->sql($sql);
	$res = $db->getResult();
	if (count($res) == 1) {
		$userid = $res[0]['id'];
		$accountType = 3;
		$wallet_address = '';
	}

	$nextURL = "../_commitee/wait_list.php";
	
}

if ($accountType!=0) { // FOUND ACCOUNT

	if ($accountType ==3 ) { // AUDIT / LEGAL
		$loan_userid = $userid;
		echo 'Audit';
	} else {

		$sql = "select * from loan_account where userid=$userid and usertype=$accountType";
		$db->sql($sql);
		$accRes = $db->getResult();

		if (count($accRes) == 0) { // Never Login 
			$param = array(
				"userid" => $userid,
				"usertype" => $accountType,
				);

			if ($db->insert("loan_account", $param)) {
				$res = $db->getResult();
				$loan_userid = $res[0];

			}else {
				echo 'Server Error';
			}

		}else {
			$loan_userid = $accRes[0]['id'];

		}
	}

	$_SESSION['username'] = $email;
	// $_SESSION['userid'] = $userid;
	$_SESSION['walletid'] = $userid;
	$_SESSION['userimage'] = $userimage;
	$_SESSION['userid'] = $loan_userid;
	$_SESSION['usertype'] = $accountType;
	$_SESSION['useraddress'] = $wallet_address;
	$_SESSION['admin'] = $isadmin;

	$_SESSION['role'] = $role;
	$_SESSION['sectionid'] = $sectionid;


	// echo 'user id = '.$loan_userid;
}else {
	$nextURL = "login.php?e=1";
}

// echo $nextURL;
header("Location:".$nextURL);

?>