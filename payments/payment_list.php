<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?
include '../include/database.php';
$db = new Database();  
$db->connect();

$config = include ('../api/config.php');

$userid = $_SESSION['userid'];

// $sql = "select * from loan_contract_v2 where userid=$userid order by updatedate desc";
$sql = "select repay.*,dv2.title,dv2.max_borrow,cv2.amount as fromamount from loan_repay repay left join loan_contract_v2 cv2 on repay.contractid=cv2.id left join loan_documents_v2 dv2 on cv2.documentid=dv2.id where repay.userid=$userid ";

if ($config['TEST']==1)
    $sql .= " and repay.test=1 ";
  else $sql .= " and repay.test=0 ";

$sql .= " order by repay.updatedate desc";

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
          <div class="container-fluid">

            <? include '../include/header_space.php';?>

              <div class="row">
                <div class="col">
                  <div class="card">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-md-4">
                        <h5>Payments</h5>
                      </div>
                      <div class="col-md-8 text-right">
                        <a href="payment_create.php">
                          <button type="button" class="btn btn-secondary "> <span class="icon-plus"></span> Repay Trade Loan</button>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-border-horizontal">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Date</th>
                          <th scope="col">Docs Title</th>
                          <th scope="col">Amount</th>
                          <th scope="col">Principle</th>
                          <th scope="col">Interest</th>
                          <th scope="col">From Amount</th>
                          <th scope="col">txHash</th>
                          <th scope="col">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?
                          $count = 0; 
                          foreach($res as $r) { 
                            $count ++;

                            $status = $r['status'];
                            if ($status == 0)
                              $status = "<span class=\"badge badge-pill badge-warning\">Pending</span>";
                            else if ($status==1)
                              $status = "<span class=\"badge badge-pill badge-success\">Complete</span>";
                            else if ($status==2)
                              $status = "<span class=\"badge badge-pill badge-danger\">Fail</span>";
                        ?>
                        <tr>
                          <th scope="row"><?=$count?></th>
                          <td><?=$r['updatedate']?></td>
                          <td><?=$r['title']?></td>
                          <td><?=$r['amount']?></td>
                          <td><?=$r['principle']?></td>
                          <td><?=$r['interest']?></td>
                          <td><?=$r['fromamount']?></td>
                          <td><a href="https://etherscan.io/tx/<?=$r['txhash']?>" target="_blank"><?=substr($r['txhash'],0,10)?> .. </a></td>
                          <td><?=$status?></td>
                          <!-- <td><a class="btn btn-primary btn-sm" href="#" data-original-title="" title=""> <span class="fa fa-info-circle"></span> Button</a></td> -->
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