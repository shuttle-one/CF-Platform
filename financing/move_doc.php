<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?

function moveFile($id, $filename) {

	echo "Move $id file $filename : ";

	$hasDir = false;
	$source = "../assets/docs/" . $filename;
	$directory = "../ipfs/ratdoc/d" . $id;

	if (is_dir($directory)) {
		$hasDir = true;
	}else 
	{
		if (mkdir($directory))
			$hasDir = true;
	}

	if ($hasDir) {
		$target = $directory . "/" . $filename;
		if (!copy($source, $target)) {
			echo "Fail to copy ";
			$errors= error_get_last();
		    echo "COPY ERROR: ".$errors['type'];
		}else 
			echo "Success";

	}else 
		echo "Cant make dir";

	echo "<br>";
}

include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "select * from loan_documents_v2";
$db->sql($sql);
$res = $db->getResult();

foreach ($res as $r) {
	$id = $r['id'];
	$file1 = $r['file1'];
	$file2 = $r['file2'];
	$file3 = $r['file3'];
	$file4 = $r['file4'];

	if ($file1 != '' )
		moveFile($id, $file1 );
	if ($file2 != '' )
		moveFile($id, $file2 );
	if ($file3 != '' )
		moveFile($id, $file3 );
	if ($file4 != '' )
		moveFile($id, $file4 );

}

?>