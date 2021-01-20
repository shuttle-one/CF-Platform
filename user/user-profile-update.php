<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?
$userid = $_SESSION['userid'];
$firstname = $_REQUEST['firstname'];
$lastname = $_REQUEST['lastname'];
$address = $_REQUEST['address'];
$city = $_REQUEST['city'];
$postcode = $_REQUEST['postcode'];
$country = $_REQUEST['country'];
$company = $_REQUEST['company'];


include '../include/database.php';
$db = new Database();  
$db->connect();

$param = array(

	"firstname" => $firstname,
	"lastname" => $lastname,
	"address" => $address,
	"city" => $city,
	"postcode" => $postcode,
	"country" => $country,
	"company" => $company,
	);

if ($_FILES["file1"]["name"] != '') {
	$target_dir = "../assets/docs/kyb/";
	$filename = basename($_FILES["file1"]["name"]);
	$target_file = $target_dir . $filename;//basename($_FILES["file1"]["name"]);

	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if (move_uploaded_file($_FILES["file1"]["tmp_name"], $target_file)) {
		$content = $target_file;
		$param['file1'] = $filename;
	}
}

if ($db->update("loan_account", $param, "id=$userid")) {
	$nextURL = "user-profile.php?t=2";
}else {
	$nextURL = "user-profile.php?e=1";
}

header("Location:$nextURL");


?>