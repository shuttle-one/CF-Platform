<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? session_start(); ?>
<? require_once ('../api/function.php'); ?>
<?

include '../include/database.php';
$db = new Database();  
$db->connect();

$param = array (
			"sectionid" => $_SESSION['sectionid'],
			"ip" => get_client_ip(),
			"username" => $_SESSION['username'],
			"url" => get_real_url(),
			"param" => get_all_param(),
			);

var_dump($param);

$db->insert("log_user", $param);
?>