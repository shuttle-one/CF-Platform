<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen_admin.php';?>
<?
include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "SELECT * FROM loan_account";
$db->sql($sql);
$res = $db->getResult();

$accountlist = array();

foreach ($res as $a ) {
  $account = array();
  $userid = $a['id'];
  $createdate = $a['createdate'];


  if ($a['usertype']==1) { //----- USER
    $sql = "select * from wallet_data where walletid='".$a['userid']."'";
    $db->sql($sql);
    $uAcc = $db->getResult();
    if (count($uAcc) == 1) {
      $accpint['userid'] = $userid;
      $account['email'] = $uAcc[0]['email'];
      $account['wallet'] = $uAcc[0]['eth_wallet'];
      $account['userid'] = $userid;
      $account['type'] = "user";
      $account['createdate'] = $createdate;

      array_push($accountlist, $account);

    } 
  }

  else if ($a['usertype']==2) { //----- COMPANY
    $sql = "select * from partner_data where partnerid='" . $a['userid'] . "'";
    $db->sql($sql);
    $uAcc = $db->getResult();
    if (count($uAcc) == 1) {
      $accpint['userid'] = $userid;
      $account['email'] = $uAcc[0]['email'];
      $account['wallet'] = $uAcc[0]['wallet_addr'];
      $account['userid'] = $userid;
      $account['type'] = "partner";
      $account['createdate'] = $createdate;

      array_push($accountlist, $account);
    }
  }
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
                        <h5>User List</h5>
                      </div>
                      <div class="col-md-8 text-right">
                        <a href="#">
                          <button type="button" class="btn btn-secondary "> <span class="icon-plus"></span> Create New User</button>
                        </a>
                      </div>
                    </div>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-border-horizontal">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Username</th>
                          <th scope="col">Address</th>
                          <th scope="col">Type</th>
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
                          <td><?=$acc['email']?></td>
                          <td><?=$acc['wallet']?></td>
                          <td><?=$acc['type']?></td>
                          <td><?=$acc['createdate']?></td>
                          <!-- <td><button class='btn btn-success btn-xs'>Success</button></td> -->
                          <td><a class="btn btn-primary btn-sm" href="user-detail.php?id=<?=$acc['userid']?>" data-original-title="" title=""> <span class="fa fa-info-circle"></span> Detail</a></td>
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
  </body>
</html>