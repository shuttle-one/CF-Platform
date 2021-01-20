<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?
session_start();
if (($_SESSION['username'] == '') || 
	($_SESSION['role'] == 'user') || 
	($_SESSION['role'] == 'admin'))
	
	header("Location:../login/login.php?e=commiteerole");

?>