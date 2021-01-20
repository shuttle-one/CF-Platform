<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<? require_once ('../api/function.php'); ?>
<?

$config = include ('../api/config.php');
$uploadpath = $config['TOPUP_DOC_UOLOAD_URL'];

$menuid = 5;
$sectionid = $_SESSION['sectionid'];
$id = $_REQUEST['id'];

$arr = topupCheck($sectionid, $id);
if ($arr['code']==0) {
  $amount = $arr['data']['amount'];
  $currency = $arr['data']['currency'];
  $detail = $arr['data']['bankacc'];
}
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

        <? include '../include/header_space.php';?>


            <div class="container-fluid">
              
              <div class="row">

                <div class="col-xl-12 xl-50 col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h5>Topup Detail</h5>

                     </div>
                    <div class="card-body">
                      <div class="row">

                        <div class="col">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Topup </label>
                            <div class="col-sm-9">
                            	<input class="form-control input-air-primary" value="<?=number_format($amount,2,'.',',')?> <?=$currency?>" readonly="">
                            </div>
                          </div>


                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Transfer this fund to bank account</label>
                            <div class="col-sm-9">
                              
                            	<textarea class="form-control input-air-primary" id="exampleFormControlTextarea19" rows="10" readonly=""><?=$detail?></textarea>
                            </div>
                          </div>


                          <form id="sform" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="tranid" id="tranid" value="<?=$id?>">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Upload Document for this transaction.</label>
                              <div class="col-sm-9">
                                
                                <input type="file" id="file1" name="file1" class="form-control input-air-primary" >
                              </div>
                            </div>
                          </form>


                          <div class="form-group row">
                            <div class="text-left col-md-6">
                              <button type='button' class='btn btn-warning' id="btn_back">Cancel</button>
                            </div>

                              <div class="text-right col-md-6">
                                <button type='button' class='btn btn-success' id="btn_confirm">Submit document</button>
                              </div>
                            
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <? include '../include/footer.php'; ?>
      </div>
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <script>

      $("#btn_back").on("click", function() {
        window.location.href = "wallet_topup.php";
      });

      $("#btn_confirm").on("click", function() {

        callSubmitBank();
        
      });

      function callSubmitBank() {

        if ($("#file1").val() == '' ) {
          alert('Please choose document file');
          return;
        }
        
        $.ajax({
          url: "../api/call_api.php",
          type: 'GET',
          data: {
              'command' : "topup_bank_submit",
              'sectionid' : <?=$sectionid?>,
              'id' : <?=$id?>,
          },
          success: function (data) {
            var obj = JSON.parse(data);
            alert(obj.data);

            if (obj.code == '0') {
              window.location.href = "wallet_topup.php";
            }
          }
        });
      }

    </script>
    <!-- Plugin used-->
  </body>
</html>