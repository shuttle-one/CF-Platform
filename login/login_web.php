<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?

include '../include/database.php';
$db = new Database();  
$db->connect();

$email = $_REQUEST['email'];
$check = $_REQUEST['check'];
$key = $_REQUEST['key'];


if ($check == 0) {
	$sql = "insert into loan_web_login(email,webkey,status,weblogindate) value('$email', '$key', 0, now())";
	if ($db->sql($sql))
	{
		$sql = "select * from wallet_data where email='$email'";
		$db->sql($sql);
		$res = $db->getResult();
		if (count($res)==1) {
			$notif = $res[0]['push_id'];

			// $url = "http://natee.network/xse_wallet/notif/send_notif_data.php";
			// $url .= "?id=" . urlencode($notif);
			// $url .= "&msg=" . urlencode("Have request login from web");
			// echo $url;
			// file_get_contents($url);

			$url = "../notif/send_notif_data.php";
			$url .= "?id=" . urlencode($notif);
			$url .= "&key=" . urlencode($key);
			$url .= "&msg=" . urlencode("Have request login from web");
			

			$v = file_get_contents($url);

		}

		echo 1;
	}
	else 
		echo 0;
} else if ($check == 1) {
	$sql = "select * from loan_web_login where email='$email' and status=1 and webkey='$key'";
	$db->sql($sql);
	$res = $db->getResult();
	if (count($res) == 1) {
		$id = $res[0]['id'];
		if ($db->sql("update loan_web_login set status=2 where id=$id and webkey='$key'"))
			echo 1;
		else echo 0;
	}else 
		echo 0;
}

?>