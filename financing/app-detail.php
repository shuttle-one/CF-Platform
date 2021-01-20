<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<? require_once ('../api/function.php'); ?>
<?
include '../include/database.php';
$db = new Database();  
$db->connect();

$userid = $_SESSION['userid'];
$sectionid = $_SESSION['sectionid'];
$loanid = $_REQUEST['id'];

$config = include ('../api/config.php');

$sql = "select d.*,t.doctitle from loan_documents_v2 d left join loan_doc_type t on d.doc_type=t.doctypeid where d.id=$loanid";

if ($config['TEST']==1)
    $sql .= " and d.test=1 ";
else $sql .= " and d.test=0 ";

$db->sql($sql);
$appRes = $db->getResult();

//------------------------------------------------

$sql = "select * from loan_contract_v2 where documentid=$loanid";
if ($config['TEST']==1)
    $sql .= " and test=1 ";
  else $sql .= " and test=0 ";
$db->sql($sql);
$creRes = $db->getResult();

$contractid = $creRes[0]['id'];
$principle = $creRes[0]['principle'];

//------------------------------------------------

$sql = "select repay.*,dv2.title,dv2.max_borrow,cv2.amount as fromamount from loan_repay repay left join loan_contract_v2 cv2 on repay.contractid=cv2.id left join loan_documents_v2 dv2 on cv2.documentid=dv2.id where repay.userid=$userid and repay.contractid=$contractid ";

if ($config['TEST']==1)
    $sql .= " and repay.test=1 ";
  else $sql .= " and repay.test=0 ";

$sql .= " order by repay.updatedate desc";
$db->sql($sql);
$payRes = $db->getResult();

//------------------------------------------------

?>
<!DOCTYPE html>
<html lang="en">
  <? include '../include/head.php'; ?>
  <style>
.modal {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('http://i.stack.imgur.com/FhHRx.gif') 
                50% 50% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading .modal {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .modal {
    display: block;
}
</style>
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

                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-header">
                      <h5>Documents</h5>

                    </div>

                    <div class="card-body">

                      <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="title">Invoice Title</label>
                        <div class="col-sm-6">
                          <?=$appRes[0]['title']?>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="title">Invoice Title</label>
                        <div class="col-sm-6">
                          <?=$appRes[0]['doctitle']?>
                        </div>
                      </div>

                      <? for ($i=1;$i<=4;$i++) { 
                         $name = "file" . $i;
                        ?>
                      <div class="form-group row">
                        <!-- <label class="col-sm-3 col-form-label" for="file1">File Attached <?=$i?></label> -->
                        <div class="col-sm-9">
                          <?if ($appRes[0][$name]!='') { ?>
                            
                            <? 
                              $ar = explode('.',$appRes[0][$name]);
                              $ex = $ar[count($ar)-1];

                              if (strtolower($ex)=='pdf') {
                            ?>
                            <a href="../assets/docs/<?=$appRes[0][$name]?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Click to open attatched file</a>
                            <br>
                            <embed src="../assets/docs/<?=$appRes[0][$name]?>" type="application/pdf" width="200px" height="100px" />

                            <? 
                              } else if (strtolower($ex)=='jpg' || strtolower($ex)=='jpeg' || strtolower($ex)=='gif' || strtolower($ex)=='png') { // IMAGE
                              ?>
                              <a href="../assets/docs/<?=$appRes[0][$name]?>" target="_blank"><i class="fa fa-file-image-o"></i> Click to open attatched file</a>
                              <br>
                              <img src="../assets/docs/<?=$appRes[0][$name]?>" width="100px">
                              <?
                              }else if (strtolower($ex)=='xls' || strtolower($ex)=='xlsx') {
                                ?>
                                <a href="../assets/docs/<?=$appRes[0][$name]?>" target="_blank"><i class="fa fa-file-excel-o"></i> Click to open attatched file</a>
                                <?
                              }else if (strtolower($ex)=='doc' || strtolower($ex)=='docs') {
                                ?>
                                <a href="../assets/docs/<?=$appRes[0][$name]?>" target="_blank"><i class="fa fa-file-word-o"></i></a>
                                <?
                              }
                            } 
                            ?>

                        </div>
                      </div>
                      <? } ?>


                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-header">
                      <h5>Approve Status </h5>
                    </div>

                    <div class="card-body">

                      <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="title">Submit txHash</label>
                        <div class="col-sm-6">
                          <? if ($appRes[0]['txhash']!='') { ?>
                                  <a href="https://etherscan.io/tx/<?=$appRes[0]['txhash']?>" target="_blank"><?=substr($appRes[0]['txhash'],0,10)?>...</a>
                              <? } ?>
                        </div>
                      </div>


                      <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="title">Credit Score</label>
                        <div class="col-sm-6">
                          <?=$appRes[0]['score']?>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="title">Finance Requested</label>
                        <div class="col-sm-6">
                          <?=$appRes[0]['max_borrow']?>
                        </div>
                      </div>


                      <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="title">Apr/Yr</label>
                        <div class="col-sm-6">
                          <?=$appRes[0]['apr']?>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="title">Legal</label>
                        <div class="col-sm-6">
                          <? if ($appRes[0]['legal_approve']==1 && $appRes[0]['legal_txhash']!='') { ?>
                                  <a href="https://etherscan.io/tx/<?=$appRes[0]['legal_txhash']?>" target="_blank"><?=substr($appRes[0]['legal_txhash'],0,10)?>...</a>
                              <? } ?>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="title">Audit</label>
                        <div class="col-sm-6">
                          <? if ($appRes[0]['audit_approve']==1 && $appRes[0]['audit_txhash']!='') { ?>
                                  <a href="https://etherscan.io/tx/<?=$appRes[0]['audit_txhash']?>" target="_blank"><?=substr($appRes[0]['audit_txhash'],0,10)?>...</a>
                              <? } ?>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-6 col-form-label" for="title">Action</label>
                        <div class="col-sm-6">
                          <? if ($appRes[0]['status'] == 0) { ?> 
                                <a href="javascript:confirmSubmit(<?=$appRes[0]['id']?>)" class="btn btn-success btn-xs">Submit</a> &nbsp;<a href="loan_app_edit.php?id=<?=$appRes[0]['id']?>" class="btn btn-primary btn-xs">Edit</a>
                            <? } ?>
                            <? if ($appRes[0]['status'] == 1) { ?> 
                              <span class="badge badge-pill badge-warning">Submited</span>
                            <? } ?>
                            <? if ($appRes[0]['status'] == 2) { ?> 
                              <span class="badge badge-pill badge-warning">Approved</span>
                            <? } ?>
                            <? if ($appRes[0]['status'] == 3) { ?> 
                              <span class="badge badge-pill badge-danger">Reject</span>
                            <? } ?>
                            <? if ($appRes[0]['status'] == 4) { ?> 
                              <span class="badge badge-pill badge-success">Active</span>
                            <? } ?>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                

              </div>
              <div class="row">

                <div class="col-xl-12 xl-50 col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h5>Credit Line</h5>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                    <table class="table table-border-horizontal">
                      <thead>
                        <tr>
                          <th scope="col">Credit ID.</th>
                          <th scope="col">Loan Title</th>
                          <th scope="col">txHash</th>
                          <th scope="col">Debt</th>
                          <th scope="col">Apr</th>
                          <th scope="col">Running Interest</th>
                          <th scope="col">Principle</th>
                          <th scope="col">Loan Date</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?
                          $i=0;
                          foreach ($creRes as $r) {  $i++; 
                            $status = $r['status'];

                      ?>

                        <tr>
                          <td><?=$r['id']?></td>
                          <td><?=$r['title']?></td>
                          <td><a href="https://etherscan.io/tx/<?=$r['txhash']?>" target="_blank"><?=substr($r['txhash'],0,15)?> ...</a></td>
                          <td><?=number_format($r['amount'],2,'.',',')?></td>
                          <td><?=number_format($r['apr'],2,'.',',')?></td>
                          <td><div id="int_<?=$r['id']?>"> loading...</div></td>
                          <td><?=$r['principle']?></td>
                          <td><?=$r['updatedate']?></td>
                          <td>
                          <? if ($r['status'] == 1) { // Pending ?>
                            <i class="fa fa-cogs" style="color: orange;"></i>
                          <? } ?>

                          <? if ($r['status'] == 2) { // Approve ?>
                            <i class="fa fa-check" style="color: green;"></i>
                          <? } ?>
                          
                          </td>
                          <td>
                          <? if ($status == 1) { ?>
                            <div id="start_<?=$r['id']?>">
                              <a href="javascript:contractActive(<?=$r['id']?>)" >
                                <button class='btn btn-primary btn-xs'>Start Loan</button>
                              </a>
                            </div>
                          <? } ?>

                          <? if ($status == 2) { ?>
                            <span class="badge badge-pill badge-success">Started</span> 
                          <? } ?>

                          <? if ($status == 3) { ?>
                            <span class="badge badge-pill badge-dark">Closed</span> 
                          <? } ?>

                          <? if ($status == 4) { ?>
                            <span class="badge badge-pill badge-danger">Error</span> 
                          <? } ?>


                          </td>
                          <!-- <td><a href="creditline_view.php?cid=<?=$r['id']?>&did=<?=$r['did']?>"><button class='btn btn-success btn-xs'>View</button></a></td> -->
                        </tr>

                      <? } ?>
                      </tbody>
                    </table>
                  </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="row">

                <div class="col-xl-12 xl-50 col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h5>Repay Detail</h5>
                    </div>

                    <? if (count($payRes)==0) { ?>
                      Not found.
                    <? } else { ?>

                    <div class="card-body">

                      <form class="form-horizontal" id="frm" method="post" action="payment_submit.php">
                        <fieldset>

                          Principle : <?=number_format($principle,2,'.',',')?>

                        <hr>
                        <!-- Text input-->
                        <div class="form-group row">
                          <label class="col-lg-12 control-label text-lg-left" for="amount">Amount</label>  
                          <div class="col-lg-9">
                          <input id="amount" name="amount" type="text" placeholder="0.000000" class="form-control input-md">
                          </div>

                          <div class="col-lg-3">
                            <button type="button" id="btn_create" name="btn_create" class="btn btn-primary">REPAY</button>
                          </div>
                        </div>

                        <input type="hidden" name="txhash" id="txhash" value="">

                        <!-- Button -->
                        <!-- <div class="form-group row">

                          <div class="col-lg-3">
                            <button type="button" id="btn_create" name="btn_create" class="btn btn-primary">REPAY</button>
                          </div>
                        </div> -->

                        </fieldset>
                      </form>

                      <div class="table-responsive">
                        <table class="table table-border-horizontal">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Date</th>
                              <th scope="col">Docs Title</th>
                              <th scope="col">Amount</th>
                              <th scope="col">From Amount</th>
                              <th scope="col">txHash</th>
                              <th scope="col">Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?
                              $count = 0; 
                              foreach($payRes as $r) { 
                                $count ++;

                                $status = $r['repay'];
                                if ($status == 0)
                                  $status = "<span class=\"badge badge-pill badge-warning\">Pending</span>";
                                else if ($status==1)
                                  $status = "<span class=\"badge badge-pill badge-success\">Complete</span>";
                            ?>
                            <tr>
                              <th scope="row"><?=$count?></th>
                              <td><?=$r['updatedate']?></td>
                              <td><?=$r['title']?></td>
                              <td><?=$r['amount']?></td>
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

                    <? } ?>
                  </div>
                </div>

              </div>

          </div>
          <!-- Container-fluid Ends-->
        </div>
        <div class="modal"><!-- Place at bottom of page --></div>
        <!-- footer start-->
        <? include '../include/footer.php'; ?>
      </div>
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <script>

      $("#btn_create").on("click", function() {
        $body = $("body");
        $body.addClass("loading");
        $.ajax({
          url: "../api/call_api.php",
          type: 'POST',
          data: {
            'command' : "repay",
            'sectionid' : '<?=$sectionid?>',
            'loanid' : $("#loanid").val(),
            'amount' : $("#amount").val(),
          },
          success: function (data) {
            // alert(data);

            $body.removeClass("loading");

            var obj = JSON.parse(data);
            if (obj.code == 0) {
              var tx = obj.data.txHash;

              if (tx!='') {
                $("#txhash").val(tx);
                $("#frm").submit();
              }
            }else  {
              alert(obj.data);

            }
          }
        });
      });

      function confirmSubmit(id) {

        var re = confirm("After submit, you can't edit documents detail");
        if (re) {

            $body = $("body");
            $body.addClass("loading");

            $.ajax({
                url: "loan_send_approve.php",
                type: 'POST',
                data: {
                    'id' : id,
                },
                success: function (data) {

                    $body.removeClass("loading");
                    if (data=='1') {
                        alert("Submit success");
                    }
                    else {
                        alert('Error : ' + data);
                    }
                    
                    location.reload();
                }
            });

        }
      }

      function checkInterest(cid) {
        $.ajax({
            url: "../api/call_api.php",
            type: 'POST',
            data: {
                'command' : "check_interest",
                'sectionid' : <?=$_SESSION['sectionid']?>,
                'contractid' : cid,
            },
            success: function (data) {
              // console.log("set int to : int_" + cid);
              var id = "int_" + cid;
              // console.log(data);
              var obj = JSON.parse(data);
              if (obj.code==0) {
                var d = obj.data;
                document.getElementById(id).innerHTML = d;
              } else if (obj.code == 2) {
                alert(obj.data);
                window.location.href = "../login/login.php";
              }
              else {
                alert(obj.data);
              }
            }
        })
      }

      function refreshInter () {
        <? foreach ($creRes as $r) { ?>
          <? //if ($r['status']==2) {?>
            checkInterest(<?=$r['id']?>);
          <? //} ?>
        <? } ?>
      }

        
        setInterval(function(){ refreshInter (); }, 10000);


    </script>
    <!-- Plugin used-->
  </body>
</html>