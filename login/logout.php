<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?
session_start();

$_SESSION['username'] = '';
$_SESSION['admin'] = '';
$_SESSION['sectionid'] = "";
session_unset();
session_destroy();

$e = $_REQUEST['e'];

if ($e=='') { ?>

	<script>
		window.location.href = "login.php";
	</script>
	
<? }else { ?>

	<script>
		alert("<?=$e?>");
		window.location.href = "login.php";
	</script>
<? } 

?>