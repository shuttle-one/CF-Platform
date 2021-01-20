<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?

$userid = $_REQUEST['id'];//$_SESSION['userid'];
$username = $_SESSION['username'];

include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "select * from loan_account where id='$userid'";
$db->sql($sql);
$accountRes = $db->getResult();


$sql = "select * from country order by id";
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
                      <h5>Update Profile</h5>
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
                          <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                              <label class="form-label">First Name</label>
                              <input class="form-control" type="text" name="firstname" id="firstname" value="<?=$accountRes[0]['firstname']?>">
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                              <label class="form-label">Last Name</label>
                              <input class="form-control" type="text" id="lastname" name="lastname" value="<?=$accountRes[0]['lastname']?>">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="form-label">Address</label>
                              <input class="form-control" type="text" id="address" name="address" value="<?=$accountRes[0]['address']?>">
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                              <label class="form-label">City</label>
                              <input class="form-control" type="text" id="city" name="city" value="<?=$accountRes[0]['city']?>">
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                              <label class="form-label">Postal Code</label>
                              <input class="form-control" type="text" id="postcode" name="postcode" value="<?=$accountRes[0]['postcode']?>">
                            </div>
                          </div>
                          <div class="col-md-5">
                            <div class="form-group">
                              <label class="form-label">Country</label>
                              <select class="form-control btn-square" name="country" id="country">
                                <? foreach ($res as $r) { ?>
                                <option value="<?=$r['country']?>" <? if ($accountRes[0]['country']==$r['country']) echo ' selected';?>> <?=$r['country']?></option>
                                <? } ?>
                              </select>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="form-label">Document File 
                              <? if ($accountRes[0]['file1'] != '') { ?>
                              
                              <a href="../assets/docs/kyb/<?=$accountRes[0]['file1']?>" target="_blank">
                              <i data-feather="link"></i>
                              </a>
                              <? } ?>
                              </label>
                              <input type="file" class="form-control" name="file1" id="file1">
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="card-footer text-right">
                              <button class="btn btn-primary" type="submit">Save Infomation</button>
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
    
  </body>
</html>