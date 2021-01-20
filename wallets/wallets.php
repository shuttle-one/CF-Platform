<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<? require_once ('../api/function.php'); ?>
<?
$menuid = 4;
$sectionid = $_SESSION['sectionid'];
$walletid = $_SESSION['walletid'];
$userid = $_SESSION['userid'];

$config = include ('../api/config.php');

include '../include/database.php';
$db = new Database();  
$db->connect();



$sql = "select * from topup_tran where fromid='$walletid' order by create_time desc";
$db->sql($sql);
$topupRes = $db->getResult();


$sql = "select * from withdraw_bkk where fromid='$walletid' ";

if ($config['TEST']==1)
    $sql .= " and testnet=1 ";
  else $sql .= " and testnet=0 ";

$sql .= " order by submit_date desc";
$db->sql($sql);
$withdrawRes = $db->getResult();


$sql = "select repay.*,dv2.title,dv2.max_borrow,cv2.amount as fromamount from loan_repay repay left join loan_contract_v2 cv2 on repay.contractid=cv2.id left join loan_documents_v2 dv2 on cv2.documentid=dv2.id where repay.userid=$userid";

if ($config['TEST']==1)
    $sql .= " and repay.test=1 ";
  else $sql .= " and repay.test=0 ";

$sql .= " order by repay.updatedate desc";
$db->sql($sql);
$payRes = $db->getResult();


$sql = "SELECT con.*,doc.title FROM `loan_contract_v2` con inner join loan_documents_v2 doc on con.documentid=doc.id where (con.status=2 or con.status=3) and con.userid=$userid";

if ($config['TEST']==1)
    $sql .= " and con.test=1 ";
  else $sql .= " and con.test=0 ";

$db->sql($sql);
$conRes = $db->getResult();

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

                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-header">
                        <h5>Balance</h5>

                      </div>

                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-8">
                            <h5 id="summary">
                              Loading ... 
                            </h5>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="card">
                      <div class="card-header">
                        <h5>Maintain </h5>
                      </div>

                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-8">
                            <h5 id='szo'>Loading ...</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">
                        <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                          
                          <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="true"><h5>Topup Transaction</h5></a></li>

                          <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false"><h5>Withdraw Transaction</h5></a></li>

                          <li class="nav-item"><a class="nav-link" id="repay-top-tab" data-toggle="tab" href="#top-repay" role="tab" aria-controls="top-repay" aria-selected="false"><h5>Repay Transaction</h5></a></li>

                          <li class="nav-item"><a class="nav-link" id="loan-top-tab" data-toggle="tab" href="#top-loan" role="tab" aria-controls="top-loan" aria-selected="false"><h5>Loan Transaction</h5></a></li>

                        </ul>

                        <div class="tab-content" id="top-tabContent">
                          <div class="tab-pane fade show active" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                            <div class="table-responsive">
                              <table class="display table" id="table1">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Paid Amount</th>
                                    <th scope="col">Topup With</th>
                                    
                                  </tr>
                                </thead>
                                <tbody>

                                  <? 
                                  $statusArr = array("Create","Pending","Cancel","Complete Submit","Submit Doc", "Error");


                                  $i = 0;
                                  foreach ($topupRes as $t) { 
                                    $i ++;
                                    $status = $statusArr[$t['status']];

                                  ?>
                                  <tr>
                                    <th scope="row"><?=$i?></th>
                                    <td><?=$t['create_time']?></td>
                                    <td>
                                      <?=$status?>
                                    </td>
                                    <td><?=$t['from_amount']?> <?=$t['from_cur']?></td>
                                    <td><?=$t['to_amount']?> <?=$t['to_cur']?></td>
                                    <td><?=$t['to_name']?></td>
                                    

                                  </tr>
                                <? } ?>


                                </tbody>
                              </table>
                            </div>
                          </div>

                          <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                            <div class="table-responsive">
                              <table class="display" id="table2">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Paid Amount</th>
                                    <th scope="col">txHash</th>
                                    
                                  </tr>
                                </thead>
                                <tbody>

                                  <? 
                                  $statusArr = array("Submit","Digital Asset Transfer Complete", "Reject", "Fail Send Digital Asset", "Bank Transfer Complete", "Cancel Send Fiat");


                                  $i = 0;
                                  foreach ($withdrawRes as $t) { 
                                    $i ++;
                                    $status = $statusArr[$t['status']];

                                  ?>
                                  <tr>
                                    <th scope="row"><?=$i?></th>
                                    <td><?=$t['submit_date']?></td>
                                    <td>
                                      <?=$status?>
                                    </td>
                                    <td><?=$t['amount']?> <?=$t['currency']?></td>
                                    <td><?=$t['amount_to']?> <?=$t['currency_to']?></td>
                                    <td><a href="https://etherscan.io/tx/<?=$t['txhash']?>" target="_blank"><?=substr($t['txhash'],0,10)?> .. </a></td>
                                    
                                    
                                  </tr>
                                <? } ?>


                                </tbody>
                              </table>
                            </div>
                          </div>

                          <div class="tab-pane fade" id="top-repay" role="tabpanel" aria-labelledby="repay-top-tab">
                            <div class="table-responsive">
                              <table class="display" id="table3">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Docs Title</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">From Amount</th>
                                    <th scope="col">txHash</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?
                                    $count = 0; 
                                    foreach($payRes as $r) { 
                                    $count ++;?>
                                  <tr>
                                    <th scope="row"><?=$count?></th>
                                    <td><?=$r['updatedate']?></td>
                                    <td><?=$r['title']?></td>
                                    <td><?=$r['amount']?> USD</td>
                                    <td><?=$r['fromamount']?></td>
                                    <td><a href="https://etherscan.io/tx/<?=$r['txhash']?>" target="_blank"><?=substr($r['txhash'],0,10)?> .. </a></td>
                                    <!-- <td><a class="btn btn-primary btn-sm" href="#" data-original-title="" title=""> <span class="fa fa-info-circle"></span> Button</a></td> -->
                                  </tr>
                                  <? } ?>
                                  
                                </tbody>
                              </table>
                            </div>
                          </div>

                          <div class="tab-pane fade" id="top-loan" role="tabpanel" aria-labelledby="loan-top-tab">
                            <div class="table-responsive">

                              <table class="display" id="table4">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">txHash</th>
                                    <th scope="col">Amount</th>
                                    <!-- <th scope="col">Principle</th>
                                    <th scope="col">Interest Paid</th> -->
                                  </tr>
                                </thead>
                                <tbody>
                                  <?
                                    $count = 0; 
                                    foreach($conRes as $r) { 
                                    $count ++;?>
                                  <tr>
                                    <th scope="row"><?=$count?></th>
                                    <td><?=$r['active_date']?></td>
                                    <td><a href="https://etherscan.io/tx/<?=$r['txhash']?>" target="_blank"><?=substr($r['txhash'],0,10)?> .. </a></td>
                                    <td><?=$r['amount']?> USD</td>
                                    <!-- <td><?=$r['principle']?></td>
                                    <td><?=$r['interest_paid']?></td> -->
                                    
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

      $(document).ready(function () {
          $('#table1').DataTable({
            "ordering": false
          });

          $('#table2').DataTable({
            "ordering": false
          });

          $('#table3').DataTable({
            "ordering": false
          });

          $('#table4').DataTable({
            "ordering": false
          });

      });


      <? if ($arr['code']==2) { ?>
        alert("<?=$arr['data']?>");
        window.location.href="../login/logout.php";
      <?}?>

      function callWallet() {

        $.ajax({
          url: "../api/call_api.php",
          type: 'GET',
          data: {
              'command' : "wallet_ajax",
              'sectionid' : <?=$sectionid?>,
          },
          success: function (data) {
            var obj = JSON.parse(data);

            if (obj.code==0) {
              console.log(obj.summary);
              $("#summary").text(obj.summary + " " + obj.currency);
              $("#szo").text(obj.xse);
//   $summary = $wallet['summary'];
//   $currency = $wallet['currency'];
//   $szoAmount = $wallet['xse'];
              
            } else if (obj.code==2) {
              alert(obj.data);
              window.location.href='../login/login.php';
            }else {
              alert(obj.data);
            }

          },
          error: function(e) {
            console.log(e);
          }
        });
      }

      callWallet();
    </script>
  </body>
</html>