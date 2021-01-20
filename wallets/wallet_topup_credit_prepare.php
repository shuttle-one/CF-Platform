<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<? require_once ('../api/function.php'); ?>
<?
$menuid = 5;
$sectionid = $_SESSION['sectionid'];

// var_dump($_POST);
$config = include ('../api/config.php');

$url = PREPARE_PAMENT_URL;
$url .= '?amount=' . $_REQUEST['sum'];
      $url .= '&symbol=' . $_REQUEST['symbol'];
      $url .= '&sectionid=' . $sectionid;
      $url .= '&camount=' . $_REQUEST['total'];
      $url .= '&wallet=' . $_REQUEST['wallet'];
      $url .= '&price=' . $_REQUEST['sum'];
      $url .= '&fee=' . $_REQUEST['fee'];
      $url .= '&resv=' . $_REQUEST['resv'];
      $url .= '&orderno=' . $_REQUEST['orderno'];
      $url .= "&currency=" . $_REQUEST['currency'];
      // $url .= '&currency=' . $_REQUEST['currency'];

      if ($config['TEST']==1)
      	$url .= "&test=1";


// echo $url;
// return;

?>
<!DOCTYPE html>
<html lang="en">
  <? include '../include/head.php'; ?>
  <body>
    <!-- Loader starts-->
    <? include '../include/loader.php'; ?>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
      <!-- Page Header Start-->
      <? include '../include/top_bar.php'; ?>
      <!-- Page Header Ends -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <? include '../include/left_bar.php'; ?>
        <!-- Page Sidebar Ends-->
        <!-- Right sidebar Start-->
        <? include '../include/right_bar.php'; ?>
        <!-- Right sidebar Ends-->
        <div class="page-body">
        <br>
          <!-- <div class="page-header"> -->
          	<div class="container-fluid">
              <div class="edit-profile">
                <div class="row">
                  <div class="col-lg-12">
<!-- 
                    <iframe src="<?=$url?>"></iframe> -->

                    <div class="card">

                    	<button class="btn btn-success" id="btn_popup">CLICK TO OPEN PAYMENT</button>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          <!-- </div> -->

          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <? include '../include/footer.php'; ?>
      </div>
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <!-- Plugin used-->
  </body>
  <script>
  	$("#btn_popup").on("click", function() {
  		window.open('<?=$url?>', '_blank', 'toolbar=0,location=0,menubar=0');
  	});
  	
  	
  </script>
</html>