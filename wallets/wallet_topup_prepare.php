<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<? require_once ('../api/function.php'); ?>
<?
$sectionid = $_SESSION['sectionid'];
$countryid = $_REQUEST['countryid'];
$famount = $_REQUEST['famount'];

$arr = topupBankDetail($sectionid, $countryid, $famount);

if ($arr['code']==0) {
  $id = urlencode($arr['data']['topupid']);
  $from = urlencode($arr['data']['from']);
  $to = urlencode($arr['data']['to']);
  $detail = urlencode($arr['data']['detail']);

  $param = urlencode($param);
  $url = "wallet_topup_confirm.php?from=$from&to=$to&detail=$detail&id=$id";
  header("Location:" . $url);

  echo "go to " . $url;

} else {
  echo 'fail';
  ?>
<script>
  alert("<?=$arr['data']?>");
  window.history.back();
</script>
  <?
}
?>

Finiash