<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?
session_start();
if ($_SESSION['username'] == ''){
	session_destroy();
	header("Location:../login/login.php?e=f");
}
else {
	require_once ('../api/function.php');
	$sectionid = $_SESSION['sectionid'];

	$userdetail = userDetail($sectionid);

	if ($userdetail['code']!=0)
	{
		header("Location:../login/logout.php?e=" . $userdetail['data']);
	}

	// log_user();

}


?>