<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<? require_once ('../api/function.php'); ?>
<?

$id = $_REQUEST['id'];
$sectionid = $_SESSION['sectionid'];
$from = $_REQUEST['from'];
$to = $_REQUEST['to'];

$detail = $_REQUEST['detail'];
$detail = str_replace("\\n","&#13;&#10;",$detail);
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
                            	<input class="form-control input-air-primary" value="<?=$from?>" readonly="">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">You got</label>
                            <div class="col-sm-9">
                              
                              <input class="form-control input-air-primary" value="<?=$to?>" readonly="">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Please do a bank transfer of the topup amount to this ShuttleOne Partner's local bank details as stated here</label>
                            <div class="col-sm-9">
                              
                            	<textarea class="form-control input-air-primary" id="exampleFormControlTextarea19" rows="10" readonly=""><?=$detail?></textarea>
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="text-left col-md-6">
                              <button type='button' class='btn btn-warning' id="btn_back">Cancel</button>
                            </div>

                              <div class="text-right col-md-6">
                                <button type='button' class='btn btn-success' id="btn_confirm">Confirm Topup</button>
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
        window.location.href = 'wallet_topup.php';
      });

      $("#btn_confirm").on("click", function() {
        $.ajax({
          url: "../api/call_api.php",
          type: 'GET',
          data: {
              'command' : "topup_confirm",
              'id' : <?=$id?>,
              'sectionid' : <?=$sectionid?>,
          },
          success: function (data) {

            var obj = JSON.parse(data);

            if (obj.code == 0) {
              alert(obj.data);
              window.location.href = "wallet_topup.php";
            }else if (obj.code == 2)
            {
              alert(obj.data);
              window.location.href = '../login/logout.php';
            }
          }
        });
      });

    </script>
    <!-- Plugin used-->
  </body>
</html>