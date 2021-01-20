<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?
session_start();
if (($_SESSION['username'] == '') || ($_SESSION['admin'] == 0))
	header("Location:../login/login.php?e=adminrole");

?>