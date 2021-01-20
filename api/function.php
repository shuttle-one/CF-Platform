<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?
include 'encrypt.php';

function getFromServer24Data($encode) {
	$r = file_get_contents("/test.php?enc=".$encode);
	return $r;
}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function get_all_param() {
	$allValue  = 'get || ';
	foreach($_GET as $key => $value){
	  //echo $key . " : " . $value . "<br />\r\n";
	  $allValue = $allValue.$key.' : '.$value.'\n';
	}

	$allValue = $allValue.'post || ';
	foreach($_POST as $key => $value){
	  //echo $key . " : " . $value . "<br />\r\n";
	  $allValue = $allValue.$key.' : '.$value.'\n';
	}
	return $allValue;
}

function get_real_url() {
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	return $actual_link;
}

function log_user() {
	// include '../include/database.php';
	require_once ('../include/database_log.php');
	$db = new DatabaseLog();  
	$db->connect();

	$param = array (
			"sectionid" => $_SESSION['sectionid'],
			"ip" => get_client_ip(),
			"username" => $_SESSION['username'],
			"url" => get_real_url(),
			"param" => get_all_param(),
			);

	// return var_dump($param);


	$db->insert("log_user", $param);

	// return "test";

}

function showFileAttach($f) {

  $ar = explode('.',$f);
  $ex = $ar[count($ar)-1];

  $res = "";

  if (strtolower($ex)=='pdf') {

    $res = "<a href=\"../assets/docs/$f\" target=\"_blank\"><i class=\"fa fa-file-pdf-o\"></i> Click to open attatched file</a>
    <br>
    <embed src=\"../assets/docs/$f\" type=\"application/pdf\" width=\"200px\" height=\"200px\" />";

  } else if (strtolower($ex)=='jpg' || strtolower($ex)=='jpeg' || strtolower($ex)=='gif' || strtolower($ex)=='png') { // IMAGE
   
   $res = "<a href=\"../assets/docs/$f\" target=\"_blank\"><i class=\"fa fa-file-image-o\"></i> Click to open attatched file</a>
      <br>
      <img src=\"../assets/docs/$f\" width=\"200px\">";
  
  } else if (strtolower($ex)=='xls' || strtolower($ex)=='xlsx') {
        
    $res = "<a href=\"../assets/docs/$f\" target=\"_blank\"><i class=\"fa fa-file-excel-o\"></i> Click to open attatched file</a>";

  }else if (strtolower($ex)=='doc' || strtolower($ex)=='docs') {
    
    $res = "<a href=\"../assets/docs/$f\" target=\"_blank\"><i class=\"fa fa-file-word-o\"></i> Click to open attatched file</a>";
   }

   return $res;
}

function callCreateDoc($sectionid, $tokenid, $docid, $doctype, $test='') {

	$ipfs = '0';
	$config = include ('config.php');
	$url = $config["CREATE_DOC"];

	$url = $url . $sectionid . "/" .$tokenid . "/" . $docid . "/" . $doctype;
	$url .= "/" . $ipfs;

	if ($config['TEST']==1)
		$url = $url . '/test';

	$after = encrypt($url);
	$url = $config['CONTEXT'] . $after;

	$r = file_get_contents($url);

	// $protocol=strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
	// $domainLink=$protocol.'://'.$_SERVER['HTTP_HOST'];

	// $url = $domainLink . '/loans/api/create_doc.php?';
	// $r = file_get_contents($url);

	$ar = json_decode($r,true);
	return $ar;
}

function legalkyc($ethaddress, $legalid, $test='') {
	$config = include ('config.php');
	$url = $config["LEGAL_KYC"];

	$url = $url . $ethaddress . '/' . $legalid;
	if ($config['TEST']==1)
		$url = $url . '/test';

	$after = encrypt($url);
	$url = $config['CONTEXT'] . $after;
	$r = file_get_contents($url);

	$ar = json_decode($r, true);
	return $ar;
}

function auditkyc($ethaddress, $legalid, $test='') {
	$config = include ('config.php');
	$url = $config["AUDIT_KYC"];

	$url = $url . $ethaddress . '/' . $legalid;
	if ($config['TEST']==1)
		$url = $url . '/test';

	$after = encrypt($url);
	$url = $config['CONTEXT'] . $after;

	$r = file_get_contents($url);

	$ar = json_decode($r, true);
	return $ar;
}

function legalApprove($ethaddress, $docid, $test='') {

	$config = include ('config.php');
	$url = $config["LEGAL_OK"];

	$url = $url . $ethaddress . '/' . $docid;

	if ($config['TEST']==1)
		$url = $url . '/test';

	$after = encrypt($url);
	$url = $config['CONTEXT'] . $after;

	$r = file_get_contents($url);

	$ar = json_decode($r, true);
	return $ar; 
}

function auditApprove($ethaddress, $docid, $credit, $score, $apr, $test='') {
	$config = include ('config.php');
	$url = $config["AUDIT_OK"];

	$url = $url . $ethaddress . '/' . $docid . '/'. $credit;
	$url .=  '/' . $score . '/' . $apr;
	if ($config['TEST']==1)
		$url = $url . '/test';

	$after = encrypt($url);
	$url = $config['CONTEXT'] . $after;

	$r = file_get_contents($url);

	$ar = json_decode($r, true);
	return $ar; 
}

function createLoan($sectionid, $tokenid, $docid, $contractid, $loanamount, $test='') {
	$config = include ('config.php');
	$url = $config["CREATE_LOAN"];

	$url = $url . $sectionid . '/' . $tokenid . '/' . $docid . '/' . $contractid . '/' . $loanamount;
	if ($config['TEST']==1)
		$url = $url . '/test';
	$after = encrypt($url);
	$url = $config['CONTEXT'] . $after;

	$r = file_get_contents($url);

	$ar = json_decode($r, true);
	return $ar; 
}

function checkdebit($contractid) {
	$config = include ('config.php');
	$url = $config["CHECK_DEBIT"];

	$url = $url . $contractid;
	if ($config['TEST']==1)
		$url = $url . '/test';
	
	$after = encrypt($url);
	$url = $config['CONTEXT'] . $after;

	// $r = getFromServer24Data($after);
	// $ar = json_decode($r, true);
	// return $ar; 
	// return $url;

	$r = file_get_contents($url);

	$ar = json_decode($r, true);
	return $ar; 
}

function getDateRange($inputdate, $con = " -1 month") {
	$thisdate = date("m/d/Y");
	$date1 = date("m/d/Y", strtotime($con));
	$dr = $inputdate;//$_REQUEST['dr'];
	$currdr = array();

	if ($dr!='') {

	  $date_range = explode("-", $dr);
	  $currdr = $date_range;
	  if (count($date_range)==2) {
	    $date_range[0] = date_format(date_create(trim($date_range[0])),"Y-m-d");
	    $date_range[1] = date_format(date_create(trim($date_range[1])),"Y-m-d");
	  }

	}else {
	  $date_range[0] = date_format(date_create(trim($date1)),"Y-m-d");
	  $date_range[1] = date_format(date_create(trim($thisdate)),"Y-m-d");

	  $currdr[0] = $date1;
	  $currdr[1] = $thisdate;
	}
	return $currdr;

}

// function getContextURL() {
// 	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER['HTTP_HOST']";

// 	return $actual_link;
// }

function sendComitteeEmail($email) {

	$config = include ('config.php');
	$e = $email;
	
	$e = $config["ADMIN_EMAIL"];
	$url = $config["ROOT_PATH"] . "api/send_request_approve.php?email=".$e;

	$r = file_get_contents($url);
	return $r;
}

function sendApprovedEmail($email) {

	$config = include ('config.php');
	$e = $email;
	// $e = "eakkarach@gmail.com"; //zhuang@shuttleone.network";

	$url = $config["ROOT_PATH"] . "api/send_success_to_user.php?email=".$e;

	$r = file_get_contents($url);
	return $r;
}

function http_request($url, $param) {

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,$url);

	// curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$param);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close ($ch);

    return $response;
}

function login($username, $pass) {

	//acc/login/username/pass//web/version/0/
	$config = include ('config.php');

	$url = $config['LOGIN'] . $username . '/'. $pass .'//web/0/0';
	if ($config['TEST']==1)
		$url = $url . '/test';


	$url = encrypt($url);

	$param = array(
				"id" => 1,
			);
	$url = $config['CONTEXT'] . $url;
	
	// $res = http_request($url,$param);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $dec;
}


function userDetail($sectionid ) {
	$config = include ('config.php');

	$url = $config['USER_DETAIL'] . $sectionid;
	if ($config['TEST']==1)
		$url = $url . '/test';


	$url = encrypt($url);

	$param = array(
				"id" => 1,
			);
	$url = $config['CONTEXT'] . $url;
	
	// $res = http_request($url,$param);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $dec;
}

function getWallet($sectionid) {
	$config = include ('config.php');

	$url = $config['GET_WALLET_WITH_SECTIONID'] . $sectionid;
	$url .= '//' . $config['PLATFORM'] . '/' ;

	if ($config['TEST']==1)
		$url = $url . '/test';

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);

	// $res = http_request($url,$param);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $dec;
}

function getwalletAjax($sectionid) {
	$config = include ('config.php');

	$url = $config['GET_WALLET_WITH_SECTIONID'] . $sectionid;
	$url .= '//' . $config['PLATFORM'] . '/' ;

	if ($config['TEST']==1)
		$url = $url . '/test';

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);

	// $res = http_request($url,$param);
	$res = file_get_contents($url);
	// $dec = json_decode($res, true);
	return $res;
}

function walletTransaction($sectionid) {
	$config = include ('config.php');

	$url = $config['USER_TRANSACTION'] . $sectionid;

	if ($config['TEST']==1)
		$url = $url . '/test';

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);

	// $res = http_request($url,$param);
	$res = file_get_contents($url);
	// $dec = json_decode($res, true);
	return $res;
}

function getTransactions($sectionid) {
	$config = include ('config.php');

	$url = $config['USER_TRANSACTION'] . $sectionid;

	if ($config['TEST']==1)
		$url = $url . '/test';

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);

	// $res = http_request($url,$param);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $dec;
}

function getTopupCountry($sectionid) {
	$config = include ('config.php');

	$url = $config['TOPUP_COUNTRY'] . $sectionid;

	if ($config['TEST']==1)
		$url = $url . '/test';

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $dec;
}

function convertTopupAmount($sectionid, $countryid, $amount) { // CALL WITH AJAX
	$config = include ('config.php');

	$url = $config['TOPUP_RATE'] . $sectionid . '/' . $amount . '/' . $countryid .'/';

	if ($config['TEST']==1)
		$url = $url . 'test';

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $res;//$dec;
}

function topupBankDetail($sectionid, $countryid, $amount) {
	$config = include ('config.php');

	$url = $config['TOPUP_BANK_DETAIL'] . $sectionid . '/' . $countryid . '/' . $amount .'/';

	if ($config['TEST']==1)
		$url = $url . 'test';

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $dec;
}

function topupBankList($sectionid) {
	$config = include ('config.php');

	$url = $config['TOPUP_BANK_LIST'] . $sectionid ;

	if ($config['TEST']==1)
		$url = $url . 'test';

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $dec;
}

function topupConfirm($sectionid, $id) {
	$config = include ('config.php');

	$url = $config['TOPUP_CONFIRM'] . $sectionid . '/' . $id ;

	if ($config['TEST']==1)
		$url = $url . '/test';

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $res;//$dec;
}

function topupCheck($sectionid, $id) {
	$config = include ('config.php');

	$url = $config['TOPUP_BANK_CHECK'] . $sectionid . '/' . $id ;

	if ($config['TEST']==1)
		$url = $url . '/test';

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $dec;
}

function topupBankSubmit($sectionid, $id) {
	$config = include ('config.php');

	$url = $config['TOPUP_BANK_SUBMIT'] . $sectionid . '/' . $id ;

	if ($config['TEST']==1)
		$url = $url . '/test';


	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $res;//$dec;
}

function topupCheckPrice($sectionid, $amount, $token) {
	$config = include ('config.php');

	$url = $config['TOPUP_CHECK_PRICE'] . $sectionid . '/'. $token .'/'. $amount;

	if ($config['TEST']==1)
		$url = $url . '/test';

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $res;//$dec;
}

function topupReserve($sectionid, $amount) {
	$config = include ('config.php');

	$url = $config['TOPUP_CONFIRM_RESERVE'] . $sectionid . '/' . $amount;

	if ($config['TEST']==1)
		$url = $url . '/test';

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $res;//$dec;
}

function recoeryPassword($email) {
	$config = include ('config.php');

	$url = $config['RECOVERY_PASSWORD'] . $email;

	if ($config['TEST']==1)
		$url = $url . '/test';
	

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $res;//$dec;
}

function withdrawCountry($sectionid) {
	$config = include ('config.php');

	$url = $config['WITHDRAW_COUNTRY'] . $sectionid;

	if ($config['TEST']==1)
		$url = $url . '/test';
	

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $dec;
}

function withdrawRate($sectionid, $amount, $country) {
	$config = include ('config.php');

	$url = $config['WITHDRAW_RATE'] . $sectionid;
	$url .= "/" . $amount;
	$url .= "/" . $country;

	if ($config['TEST']==1)
		$url = $url . '/test';
	

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $res;//$dec;
}

function withdrawBank($sectionid, $name, $bankaccount, $switft, $country, $amount, $countrycode, $bankname) {
	$config = include ('config.php');

	$url = $config['WITHDRAW_BKK'] . $sectionid;
	$url .= "/" . $name;
	$url .= "/" . $bankaccount;
	$url .= "/" . $switft;
	$url .= "/" . $country;
	$url .= "/" . $amount;
	$url .= "/" . $countrycode;
	$url .= "/" . $bankname;

	if ($config['TEST']==1)
		$url = $url . '/test';
	
	// return $url;
	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	$dec = json_decode($res, true);
	return $dec;
}

function repay($sectionid, $contractid, $amount) {
	$config = include ('config.php');

	$url = $config['PAYBACK'] . $sectionid;
	$url .= "/" .$contractid;
	$url .= "/" . $amount;

	if ($config['TEST']==1)
		$url = $url . '/test';
	
	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	// $dec = json_decode($res, true);
	return $res;
}

function contractDetail($sectionid, $tokenid) {
	$config = include ('config.php');

	$url = $config['CONTRACT_DETAIL'] . $sectionid;
	$url .= "/" .$tokenid;

	if ($config['TEST']==1)
		$url = $url . '/test';
	

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	// $dec = json_decode($res, true);
	return $res;
}

function contractActive($sectionid, $contractid) {
	$config = include ('config.php');

	$url = $config['CONTRACT_ACTIVE'] . $sectionid;
	$url .= "/" .$contractid;

	if ($config['TEST']==1)
		$url = $url . '/test';
	
	// return $url;

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	// $dec = json_decode($res, true);
	return $res;
}

function getBankFromCountry($country, $userid) {
	$config = include ('config.php');
	$url = $config["ROOT_PATH"] . "api/getbankaccount.php?uid=$userid&c=$country";
	
	//return $url;
	$res = file_get_contents($url);
	// $dec = json_decode($res, true);
	return $res;
}

function checkInterest($sectionid, $contractid) {
	$config = include ('config.php');

	$url = $config['CHECK_INTERST'] . $sectionid;
	$url .= "/" .$contractid;

	if ($config['TEST']==1)
		$url = $url . '/test';
	
	// return $url;

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	// $dec = json_decode($res, true);
	return $res;
}

function getNextPeriod($sectionid, $contractid) {
	$config = include ('config.php');

	$url = $config['NEXT_PERIOD'] . $sectionid;
	$url .= "/" .$contractid;

	if ($config['TEST']==1)
		$url = $url . '/test';
	
	// return $url;

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	// $dec = json_decode($res, true);
	return $res;
}

function checkKYC($walletaddr) {
	$config = include ('config.php');

	$url = $config['KYC_CHECK'] . $walletaddr;

	if ($config['TEST']==1)
		$url = $url . '/test';
	
	// return $url;

	$url = $config['CONTEXT'] . encrypt($url);
	$param = array(
				"id" => 1,
			);
	$res = file_get_contents($url);
	// $dec = json_decode($res, true);
	return $res;
}


?>