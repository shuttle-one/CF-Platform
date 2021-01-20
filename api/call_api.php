<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? require_once ('../api/function.php'); ?>
<? 

$command = $_REQUEST['command'];

if ($command=='topup_rate') {
	$sectionid = $_REQUEST['sectionid'];
	$amount = $_REQUEST['amount'];
	$ccode = $_REQUEST['ccode'];

	echo convertTopupAmount($sectionid, $ccode, $amount);
}
else if ($command=='topup_bank_detail') {
	$sectionid = $_REQUEST['sectionid'];
	$amount = $_REQUEST['amount'];
	$ccode = $_REQUEST['ccode'];

	echo topupBankDetail($sectionid, $ccode, $amount);
}else if ($command=='topup_confirm') {
	$id = $_REQUEST['id'];
	$sectionid = $_REQUEST['sectionid'];
	echo topupConfirm($sectionid, $id);
}else if ($command=='topup_bank_submit') {

	$id = $_REQUEST['id'];
	$sectionid = $_REQUEST['sectionid'];
	echo topupBankSubmit($sectionid, $id);
}else if ($command=='topup_check_price') {
	
	$sectionid = $_REQUEST['sectionid'];
	$amount = $_REQUEST['amount'];
	$token = $_REQUEST['token'];
	echo topupCheckPrice($sectionid, $amount, $token);
}else if ($command=='topup_reserve') {
	
	$sectionid = $_REQUEST['sectionid'];
	$resv = $_REQUEST['resv'];
	echo topupReserve($sectionid, $resv);
}else if ($command=='recovery_password') {
	$email = $_REQUEST['email'];

	echo recoeryPassword($email);
}else if ($command=='withdraw_country') {
	$sectionid = $_REQUEST['sectionid'];
	echo withdrawCountry($sectionid);
}else if ($command=='withdraw_rate') {
	$sectionid = $_REQUEST['sectionid'];
	$amount = $_REQUEST['amount'];
	$country = $_REQUEST['country'];
	echo withdrawRate($sectionid, $amount, $country);
}else if ($command=='repay') {
	$sectionid = $_REQUEST['sectionid'];
	$amount = $_REQUEST['amount'];
	$loanid = $_REQUEST['loanid'];
	echo repay($sectionid, $loanid, $amount);
}else if ($command=='wallet_transaction') {
	$sectionid = $_REQUEST['sectionid'];
	echo walletTransaction($sectionid);
}else if ($command=='wallet_ajax') {
	$sectionid = $_REQUEST['sectionid'];
	echo getwalletAjax($sectionid);
}else if ($command=='contract_detail') {
	$sectionid = $_REQUEST['sectionid'];
	$tokenid = $_REQUEST['tokenid'];
	echo contractDetail($sectionid, $tokenid);
}else if ($command=='contract_active') {
	$sectionid = $_REQUEST['sectionid'];
	$contractid = $_REQUEST['contractid'];
	echo contractActive($sectionid, $contractid);
}else if ($command=='bank_select') {
	$country = $_REQUEST['country'];
	$userid = $_REQUEST['uid'];
	echo getBankFromCountry($country, $userid);
}else if ($command=='bank_select') {
	$country = $_REQUEST['country'];
	$userid = $_REQUEST['uid'];
	echo getBankFromCountry($country, $userid);
}else if ($command=='check_interest') {
	$sectionid = $_REQUEST['sectionid'];
	$contractid = $_REQUEST['contractid'];
	echo checkInterest($sectionid, $contractid);
}else if ($command=='next_period') {
	$sectionid = $_REQUEST['sectionid'];
	$contractid = $_REQUEST['contractid'];
	echo getNextPeriod($sectionid, $contractid);
}


?>