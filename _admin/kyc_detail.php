<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?

$userid = $_REQUEST['id'];

include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "select * from loan_account where id='$userid'";
$db->sql($sql);
$accountRes = $db->getResult();

$walletid = $accountRes[0]['userid'];

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
        <? include '../include/admin_left_bar.php'; ?>
        <!-- Page Sidebar Ends-->
        <!-- Right sidebar Start-->
        <? include '../include/right_bar.php'; ?>
        <!-- Right sidebar Ends-->
        <div class="page-body">
          <!-- <div class="page-header"> -->
          <? include '../include/header_space.php';?>
          
          <div class="container-fluid">
            <div class="edit-profile">
              <div class="row">


                <div class="col-lg-12">

                  <div class="card">
                    <div class="card-header">
                      <h5>KYC Detail</h5>
                    </div>

                    <div class="card-body">

                      <form action="user-update.php" method="post">
                        <input type="hidden" name="userid" id="userid" value="<?=$userid?>">
                        <div class="row">
                          <!-- <div class="col-md-5">
                            <div class="form-group">
                              <label class="form-label">Company</label>
                              <input class="form-control" type="text">
                            </div>
                          </div>

                          <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                              <label class="form-label">Email address</label>
                              <input class="form-control" readonly="" type="email" value="<?=$accountRes[0]['firstname']?>">
                            </div>
                          </div> -->
                          <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                              <label class="form-label">Company</label>
                              <input class="form-control" type="text" name="firstname" id="firstname" value="<?=$accountRes[0]['company']?>" readonly>
                            </div>
                          </div>
                          <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                              <label class="form-label">First Name</label>
                              <input class="form-control" type="text" name="firstname" id="firstname" value="<?=$accountRes[0]['firstname']?>" readonly>
                            </div>
                          </div>
                          <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                              <label class="form-label">Last Name</label>
                              <input class="form-control" type="text" id="lastname" name="lastname" value="<?=$accountRes[0]['lastname']?>" readonly>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="form-label">Address</label>
                              <input class="form-control" type="text" id="address" name="address" value="<?=$accountRes[0]['address']?>" readonly>
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                              <label class="form-label">City</label>
                              <input class="form-control" type="text" id="city" name="city" value="<?=$accountRes[0]['city']?>" readonly>
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                              <label class="form-label">Postal Code</label>
                              <input class="form-control" type="text" id="postcode" name="postcode" value="<?=$accountRes[0]['postcode']?>" readonly>
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                              <label class="form-label">Country</label>
                              <input class="form-control" type="text" id="postcode" name="postcode" value="<?=$accountRes[0]['country']?>" readonly>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="form-label">Document File 
                              <? if ($accountRes[0]['file1'] != '') { ?>
                              
                              <a href="../assets/docs/kyb/<?=$accountRes[0]['file1']?>" target="_blank">
                              <i data-feather="link"></i> Click to see attach file.
                              </a>
                              <? } ?>
                              </label>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="card-footer text-right">
                              <button class="btn btn-primary" type="button" id="btn_approve">Approve KYC</button>
                            </div>
                          </div>
                          
                        </div>
                      </form>
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
    <!-- Plugin used-->
    <script>
      $("#btn_approve").on("click", function() {

        $.ajax({
          url: "kyc_approve.php",
          type: 'GET',
          data: {
              'id' : <?=$walletid?>,
          },
          success: function (data) {
            if (data==1){
              alert("Approve success.");
              window.location.href = "kyc_list.php";
            }else {
              alert("Error from server " + data);
            }
          }
        });

      });

    </script>
    
  </body>
</html>