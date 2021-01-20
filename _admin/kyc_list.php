<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen_admin.php';?>
<?
include '../include/database.php';
$db = new Database();  
$db->connect();

$status = $_REQUEST['s'];
if ($status == '')
  $status =1 ;

$sql = "SELECT * FROM loan_account where kycstatus=$status";
$db->sql($sql);
$accountlist = $db->getResult();

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
          <div class="container-fluid">

            <? include '../include/header_space.php';?>

              <div class="row">
                <div class="col">
                  <div class="card">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-md-4">
                        <h5>KYC Waiting list</h5>
                      </div>

                      <div class="col-md-5">
                        <div class="form-group">
                          <select class="form-control btn-square" name="status" id="status" onchange="status(this)">
                            <option value="1" <?if($status=='1') echo ' selected';?>> Wait for approve </option>
                            <option value="2" <?if($status=='2') echo ' selected';?>> Approved </option>
                          </select>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-border-horizontal">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Company</th>
                          <th scope="col">Name</th>
                          <th scope="col">Country</th>
                          <!-- <th scope="col">Apr</th> -->
                          <th scope="col">Create Date</th>
                          <!-- <th scope="col">Status</th> -->
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>

                      <? 
                      $count = 0;
                      foreach($accountlist as $acc) { 
                        $count ++;
                        ?>
                        <tr>
                          <th scope="row"><?=$count?></th>
                          <td><?=$acc['company']?></td>
                          <td><?=$acc['firstname']?> <?=$acc['lastname']?></td>
                          <td><?=$acc['country']?></td>
                          <td><?=$acc['createdate']?></td>
                          <!-- <td><button class='btn btn-success btn-xs'>Success</button></td> -->
                          <td><a class="btn btn-primary btn-sm" href="kyc_detail.php?id=<?=$acc['id']?>" data-original-title="" title=""> <span class="fa fa-info-circle"></span> Approve</a></td>
                        </tr>
                      <? } ?>
                       
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
                
            </div>


          </div>
          
        </div>
        <!-- footer start-->
        <? include '../include/footer.php'; ?>
      </div>
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <!-- Plugin used-->
    <script>
      function status(th) {
        window.location.href = "kyc_list.php?s=" + th.value;
      }
    </script>
  </body>
</html>