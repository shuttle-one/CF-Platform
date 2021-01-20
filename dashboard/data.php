<? include '../api/function.php';?>
<?


$thisdate = date("yy/m");

$d1 = date_format(date_create(trim("2020/07/01")),"m");

echo $d1;

?>