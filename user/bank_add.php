<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?
include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "select * from country";
$db->sql($sql);
$res = $db->getResult();

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
                    <div class="card">
                  <div class="card-header">
                    <h5>New Bank Account</h5>
                  </div>
                  <form class="form theme-form" action="bank_add_submit.php" method="post">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Account Name</label>
                            <div class="col-sm-9">
                              <input class="form-control" type="text" name="account_name" id="account_name">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Bank Name</label>
                            <div class="col-sm-9">
                              <input class="form-control" type="text" name="bank_name" id="bank_name">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Branch</label>
                            <div class="col-sm-9">
                              <input class="form-control" type="text" name="branch" id="branch">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Account Number</label>
                            <div class="col-sm-9">
                              <input class="form-control" type="text" name="account_number" id="account_number">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">SWIFT Code</label>
                            <div class="col-sm-9">
                              <input class="form-control" type="text" name="swiftcode" id="swiftcode">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Country</label>
                            <div class="col-sm-9">

                              <select class="form-control" name="country" id="country">
                                <? foreach ($res as $r) { ?>
                                <option value="<?=$r['country']?>"><?=$r['country']?></option>
                              <? } ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="col-sm-9 offset-sm-3">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <input class="btn btn-light" type="reset" value="Clear Data">
                      </div>
                    </div>
                  </form>
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
    <script>
      $("#btn_cancel").on("click", function() {
        window.history.back();
      });
    </script>
  </body>
</html>