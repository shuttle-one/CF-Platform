<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?

$submenu = $_REQUEST['t'];

if ($submenu=='')
   $submenu = 1;

$userid = $_SESSION['userid'];
$username = $_SESSION['username'];

$kyc_ready = "";

include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "select * from loan_account where id='$userid'";
$db->sql($sql);
$accountRes = $db->getResult();


$sql = "select * from country order by id";
$db->sql($sql);
$res = $db->getResult();


$sql = "select * from loan_bank_account where userid='$userid'";
$db->sql($sql);
$bankRes = $db->getResult();


if (($accountRes[0]['kycstatus']==1) || ($accountRes[0]['kycstatus']==2) ){ // READY
  $kyc_ready = " readonly";
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
          <!-- <div class="page-header"> -->
          <? include '../include/header_space.php';?>
          
            <div class="container-fluid">
            <div class="edit-profile">
              <div class="row">


                <div class="col-lg-12">

                  <div class="card">

                    <div class="card-body">
                    <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                      <li class="nav-item"><a class="nav-link<?if ($submenu==1) echo ' active';?>" id="top-home-tab" data-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="true"><i class="icofont icofont-businessman"></i>Profile</a></li>
                      <li class="nav-item"><a class="nav-link<?if ($submenu==2) echo ' active';?>" id="profile-top-tab" data-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false"><i class="icofont icofont-id-card"></i>KYB Info</a></li>
                      <li class="nav-item"><a class="nav-link<?if ($submenu==3) echo ' active';?>" id="contact-top-tab" data-toggle="tab" href="#top-contact" role="tab" aria-controls="top-contact" aria-selected="false"><i class="icofont icofont-files"></i>Bank Account</a></li>
                    </ul>
                    <div class="tab-content" id="top-tabContent">

                      <!-- GENERAL PROFILE START -->

                      <div class="tab-pane fade <?if ($submenu==1) echo ' show active';?>" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                        <form>
                          <div class="row">
                            <div class="col-md-4">
                              <label>New Password</label>
                              <input type="password" name="pass1" id="pass1" class="form-control">
                            </div>

                            <div class="col-md-4">
                              <label>Confirm Password</label>
                              <input type="password" name="pass2" id="pass2" class="form-control">
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-md-4">
                              <button type="button" class="btn btn-success btn-sm active" id="btn_change_password"> <span class="icon-key"></span> Change Password</button>
                            </div>
                          </div>
                        </form>

                      </div>
                      <!-- END GENERAL INFORMATION -->

                      <!-- KYB INFORMATION START -->
                      <div class="tab-pane fade <?if ($submenu==2) echo ' show active';?>" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                      <form class="card" action="user-profile-update.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                          <div class="col-md-5">
                            <div class="form-group">
                              <label class="form-label">Company</label>
                              <input class="form-control" type="text" name="company" id="company" value="<?=$accountRes[0]['company']?>" <?=$kyc_ready?>>
                            </div>
                          </div>

                          <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                              <label class="form-label">Email address</label>
                              <input class="form-control" readonly="" type="email" value="<?=$username?>" <?=$kyc_ready?>>
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                              <label class="form-label">First Name</label>
                              <input class="form-control" type="text" name="firstname" id="firstname" value="<?=$accountRes[0]['firstname']?>" <?=$kyc_ready?>>
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                              <label class="form-label">Last Name</label>
                              <input class="form-control" type="text" id="lastname" name="lastname" value="<?=$accountRes[0]['lastname']?>" <?=$kyc_ready?>>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="form-label">Address</label>
                              <input class="form-control" type="text" id="address" name="address" value="<?=$accountRes[0]['address']?>" <?=$kyc_ready?> <?=$kyc_ready?>>
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                              <label class="form-label">City</label>
                              <input class="form-control" type="text" id="city" name="city" value="<?=$accountRes[0]['city']?>" <?=$kyc_ready?>>
                            </div>
                          </div>
                          <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                              <label class="form-label">Postal Code</label>
                              <input class="form-control" type="text" id="postcode" name="postcode" value="<?=$accountRes[0]['postcode']?>" <?=$kyc_ready?>>
                            </div>
                          </div>
                          <div class="col-md-5">
                            <div class="form-group">
                              <label class="form-label">Country</label>
                              <select class="form-control btn-square" name="country" id="country" <?=$kyc_ready?>>
                                <? foreach ($res as $r) { ?>
                                <option value="<?=$r['country']?>" <? if ($accountRes[0]['country']==$r['country']) echo ' selected';?>> <?=$r['country']?></option>
                                <? } ?>
                              </select>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="form-label">Document File 

                              </label>
                              <? if ($kyc_ready=='') { ?>
                                <input type="file" class="form-control" name="file1" id="file1">
                              <? } ?>

                              <? if ($accountRes[0]['file1'] != '') { ?>
                                <br>
                                <img src="../assets/docs/kyb/<?=$accountRes[0]['file1']?>" height="200px">

                              <? } ?>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="card-footer text-right">
                              <? if ($accountRes[0]['kycstatus']==0) { ?>
                                <button class="btn btn-primary" type="submit">Save Infomation</button>
                                <button class="btn btn-success" type="button" id="btn_kyc_submit">Submit KYC</button>
                              <? } ?>
                              <? if ($accountRes[0]['kycstatus']==2) { ?>
                                Account Approved.
                              <? } ?>
                            </div>
                          </div>
                          
                        </div>
                        </form>
                      </div>
                      <!-- END KYB INFORMATION -->

                      <!-- BANK ACCOUNT START -->
                      <div class="tab-pane fade <?if ($submenu==3) echo ' show active';?>" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
                        

                      <div class="table-responsive">
                      <a href="bank_add.php"><button class="btn btn-light"><i class="fa fa-plus-square-o"></i> Add Bank Account</button></a>
                      <br><br>
                      <table class="table card-table table-vcenter text-nowrap">
                        <thead>
                          <tr>
                            <th>Account Name</th>
                            <th>Bank Name</th>
                            <th>Account Number</th>
                            <th>Country</th>
                            <th>Use Default</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        <? foreach($bankRes as $b) { ?>
                          <tr>
                            <td><?=$b['account_name']?></td>
                            <td><?=$b['bank_name']?></td>
                            <td><?=$b['account_number']?></td>
                            <td><?=$b['country']?></td>
                            <td>
                            <? if ($b['isuse']==1) { ?>
                              <i data-feather="check-square"></i>
                            <? } else { ?>
                              <!-- <button type="button" id="btn_check" class="btn btn-light btn-sm active"> -->
                              <a href="javascript:switchto(<?=$b['id']?>)" id="btn_switch"><i data-feather="square"></i></a>
                               <!-- Switch</button> -->
                            <? } ?>
                            </td>
                            <td class="text-right">
                            <!-- <a class="icon" href="javascript:void(0)"></a><a class="btn btn-primary btn-sm" href="javascript:void(0)"><i class="fa fa-pencil"></i> </a>&nbsp; -->

                            <a class="btn btn-danger btn-sm" href="javascript:deleteBank('<?=$b['id']?>')"><i class="fa fa-trash"></i> </a></td>
                          </tr>
                        <? } ?>

                        </tbody>
                      </table>
                    </div>
                      </div>
                      <!-- END BANK ACCOUNT -->

                    </div>
                  </div>
                    
                  </div>
                </div>
                
              </div>
            </div>
          <!-- </div> -->
            
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

    $("#btn_kyc_submit").on("click", function() {

      $.ajax({
          url: "user-submit-kyc.php",
          type: 'GET',
          data: {
              'id' : <?=$userid?>,
          },
          success: function (data) {
            if (data==1) {
              alert("Sent KYC submit, wait for approve by system.");
              window.location.href = "user-profile.php?t=2";
            }else {
              alert(data);
            }
        }
      });
    });

    $("#btn_change_password").on("click", function() {
      var p1 = $("#pass1").val();
      var p2 = $("#pass2").val();

      if (p1.indexOf('%')>0 || 
        p1.indexOf('?')>0 || 
        p1.indexOf('=')>0 || 
        p1.indexOf('\\')>0 || 
        p1.indexOf('\'')>0 || 
        p1.indexOf('\"')>0
         )
      {
        alert("Please not use these charactor %,?,=,\\,',\"");
        return;
      }

      if (p1=='' || p2==''){
        alert("Please enter password.");
        return;
      }

      if (p1!=p2) {
        alert("Please check new password is match");
        return;
      }

      var oldp = prompt("Please enter old password");
      if (oldp != '' && oldp != null) {
        $.ajax({
            url: "user-change-pass.php",
            type: 'POST',
            data: {
                'oldp' :oldp,
                'np1' : p1,
            },
            success: function (data) {
              var obj = JSON.parse(data);
              if (obj.code == 0) {
                alert("Change Password success");
              }else {
                alert(obj.code);
              }
              $("#pass1").val('');
              $("#pass2").val('');
            }
          });
      }
    });

    function switchto(id) {
      $.ajax({
          url: "bank_switch_account.php",
          type: 'POST',
          data: {
              'id' : id,
          },
          success: function (data) {
            if (data==1) {
              alert("Switch success");
              window.location.href = "user-profile.php?t=3";
            }else {
              alert("Switch fail, please try again.");
            }
        }
      });

    }

    function deleteBank(bid) {
      var oldp = confirm("Are you sure to delete this bank account?");
      if (oldp == true) {
        $.ajax({
          url: "bank_delete.php",
          type: 'POST',
          data: {
              'id' : bid,
          },
          success: function (data) {
            if (data==1) {
              window.location.href = "user-profile.php?t=3";
            }else 
              alert("Something error, please try again.");
          }
        });
      }
      
    }

    </script>
  </body>
</html>