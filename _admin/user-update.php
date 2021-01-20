<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen_admin.php';?>
<?

$userid = $_REQUEST['userid'];
$firstname = $_REQUEST['firstname'];
$lastname = $_REQUEST['lastname'];
$address = $_REQUEST['address'];
$city = $_REQUEST['city'];
$postcode = $_REQUEST['postcode'];
$country = $_REQUEST['country'];

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
	$nextURL = "user_list.php";
}else {
	$nextURL = "../error/error.php?e=ServerError&bp=../_admin/user_list.php";
}

header("Location:$nextURL");
?>