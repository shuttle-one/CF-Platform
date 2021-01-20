<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>

<?
$menuid = 2;
$userid = $_SESSION['userid'];
$config = include ('../api/config.php');

$thisdate = date("m/d/Y", strtotime(' +1 day'));
$date1 = date("m/d/Y", strtotime(' -1 month'));
$dr = $_REQUEST['dr'];

if ($dr!='') {

  $date_range = explode("-", $dr);
  $currdr = $date_range;
  if (count($date_range)==2) {
    $date_range[0] = date_format(date_create(trim($date_range[0])),"Y-m-d");
    $date_range[1] = date_format(date_create(trim($date_range[1])),"Y-m-d");
  }

}else {
  $date_range[0] = date_format(date_create(trim($date1)),"Y-m-d");
  $date_range[1] = date_format(date_create(trim($thisdate)),"Y-m-d");

  $currdr[0] = $date1;
  $currdr[1] = $thisdate;
}

require_once ('../include/database.php');
$db = new Database();  
$db->connect();

$sql = "select * from loan_documents_v2 where userid=$userid and complete_agreement=0 and date(createdate)>='$date_range[0]' and date(createdate)<='$date_range[1]' ";
if ($config['TEST']==1)
    $sql .= " and test=1 ";
else $sql .= " and test=0 ";

$sql .= " order by createdate desc";

$db->sql($sql);
$res = $db->getResult();

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
          <div class="container-fluid">
            
            <? include '../include/header_space.php';?>

              <div class="row">
                <div class="col">
                  <div class="card">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-md-3">
                        <h5>Loan Applications</h5>
                      </div>

                      <div class="col-md-5">
                        <form action="" method="get">
                          <div class="row">

                            <div class="input-group col-md-7">
                              <input class="datepicker-here form-control digits" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" value="<?=trim($currdr[0])?> - <?=trim($currdr[1])?>" name="dr">
                            </div>

                            <div class="input-group col-md-2">
                              <button type="submit" class="btn btn-secondary ">Search</button>
                            </div>
                          </div>
                        </form>
                      </div>

                      
                      <div class="col-md-4 text-right">
                        <a href="loan_app_new.php">
                          <button type="button" class="btn btn-secondary "> <span class="icon-plus"></span> Create Loan Application</button>
                        </a>
                      </div>
                    </div>

                    <!-- <div class="row">
                      <div class="col-md-2">
                        <label class="col-form-label text-right">Date</label>
                      </div>

                      <div class="col-md-4">
                        <div class="input-group">
                              <input class="datepicker-here form-control digits text-small" type="text" data-language="en">
                            </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group form-row">
                          <label class="col-sm-3 col-form-label text-right">Date</label>
                          <div class="col-xl-5 col-sm-9">
                            <div class="input-group">
                              <input class="datepicker-here form-control digits text-small" type="text" data-language="en">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> -->


                  </div>
                  <div class="table-responsive">
                    <table class="table table-border-horizontal">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Purpose</th>
                          <th scope="col">txHash</th>
                          <th scope="col">Type</th>
                          <th scope="col">Legal</th>
                          <th scope="col">Audit</th>
                          <th scope="col">Credit Score</th>
                          <th scope="col">Finance Requested</th>
                          <th scope="col">Loan Granted</th>
                          <th scope="col">Apr/Yr</th>
                          <!-- <th scope="col">Paid</th> -->
                          <th scope="col">Create On</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <? 

                      $i=0;
                      foreach ($res as $r) { 
                          $i ++;
                          $doctype = $r['doc_type'];
                          $sql = "select * from loan_doc_type where doctypeid=$doctype";
                          $db->sql($sql);
                          $dts = $db->getResult();
                          $selectedType = $dts[0]['doctitle'];

                          $loan_grant = 0;

                          $score = $r['score'];
                          if ($score == -1)
                            $score = 'Pending';
                          else {
                            $loan_grant = ($score * $r['max_borrow']) /100;
                          }

                          $loan_grant  = floor($loan_grant);

                          $max_borrow = $r['max_borrow'];
                          if ($max_borrow==-1) 
                            $max_borrow = "Pending";
                          else 
                            $max_borrow = number_format($max_borrow,2,'.',',');

                          $sql = "select * from loan_token where docid=" . $r['id'];
                          $db->sql($sql);
                          $aa = $db->getResult();


                          $elementID = "paid_" . $r['id'];
                          

                      ?>
                        <tr>
                          <th scope="row"><?=$i?></th>
                          <td><a href="loan_app_view.php?id=<?=$r['id']?>"><?=$r['title']?></a></td>
                          <td>
                            <? if ($r['txhash']!='') { ?>
                            <a href="https://etherscan.io/tx/<?=$r['txhash']?>" target="_blank">
                              <?=substr($r['txhash'],0,10)?> .. 
                            </a>
                            <? } ?>
                          </td>
                          <td><?=$selectedType?></td>
                          <td><? if ($r['legal_approve']==1 && $r['legal_txhash']!='') { ?>
                                  <a href="https://etherscan.io/tx/<?=$r['legal_txhash']?>" target="_blank"><?=substr($r['legal_txhash'],0,10)?>...</a>
                              <? } ?>
                          </td>
                          <td>
                          <? if ($r['audit_approve']==1 && $r['audit_txhash']!='') { ?>
                              <a href="https://etherscan.io/tx/<?=$r['audit_txhash']?>" target="_blank"><?=substr($r['audit_txhash'],0,10)?>...</a>
                          <? } ?>
                          </td>
                          <td><?=$score?></td>
                          <td><?=$max_borrow?></td>
                          <td><?=number_format($loan_grant,2,'.',',')?></td>
                          <td><?=$r['apr']?></td>
                          
                          <!-- <td><div id="<?=$elementID?>"></div></td> -->
                          
                          <!-- <td><i data-feather="check" style="color: green;"></i></td> -->
                          <td><?=$r['createdate']?></td>
                          <td>
                            <? if ($r['status'] == 0) { ?> 
                                <a href="javascript:confirmSubmit(<?=$r['id']?>)" class="btn btn-success btn-xs">Submit</a> &nbsp;<a href="loan_app_edit.php?id=<?=$r['id']?>" class="btn btn-primary btn-xs">Edit</a>
                            <? } ?>
                            <? if ($r['status'] == 1) { ?> 
                              <span class="badge badge-pill badge-warning">Submited</span>
                            <? } ?>
                            <? if ($r['status'] == 2) { ?> 
                              <span class="badge badge-pill badge-warning">Approved</span>
                            <? } ?>
                            <? if ($r['status'] == 3) { ?> 
                              <span class="badge badge-pill badge-danger">Reject</span>
                            <? } ?>
                            <? if ($r['status'] == 4) { ?> 
                              <span class="badge badge-pill badge-warning">Process</span>
                            <? } ?>
                            <? if ($r['status'] == 5) { ?> 
                              <span class="badge badge-pill badge-success">Active</span>
                            <? } ?>
                            <? if ($r['status'] == 6) { ?> 
                              <span class="badge badge-pill badge-dark">Closed</span>
                            <? } ?>
                            <? if ($r['status'] == 7) { ?> 
                              <span class="badge badge-pill badge-danger">Creadit Line Fail</span>
                            <? } ?>

                            <!-- <? if ($r['legal_approve']==1 && $r['audit_approve']==1) { ?>
                                <a href="../creditline/creditline_create.php?id=<?=$r['id']?>" class="btn btn-success btn-xs">Start Loan.</a>
                            <? } ?> -->
                          </td>
                        </tr>
                      <? } ?>
                      <!-- 
                        <tr>
                          <th scope="row">2</th>
                          <td>INV UAT 02</td>
                          <td>0x0f85657eb04e2c1887 ..</td>
                          <td>18,500</td>
                          <td><i data-feather="activity" style="color: orange;"></i></td>
                          <td>2020-06-09 09:25:25</td>
                          <td><i data-feather="edit"></i> &nbsp;&nbsp;<i data-feather="trash-2"></i></td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>INV UAT 03</td>
                          <td>0x0f85657eb04e2c1887 ..</td>
                          <td>18,500</td>
                          <td><i data-feather="check" style="color: green;"></i></td>
                          <td>2020-06-09 09:25:25</td>
                          <td><button class='btn btn-success btn-xs'>Start Credit Line</button></td>
                        </tr>
                        <tr>
                          <th scope="row">4</th>
                          <td>INV UAT 04</td>
                          <td>0x0f85657eb04e2c1887 ..</td>
                          <td>18,500</td>
                          <td><i data-feather="x" style="color: red;"></i></td>
                          <td>2020-06-09 09:25:25</td>
                          <td><i data-feather="edit"></i> &nbsp;&nbsp;<i data-feather="trash-2"></i></td>
                        </tr> -->
                        
                      </tbody>
                    </table>
                  </div>
                </div>
                </div>

                <!-- <button id="btn_check"> Check Contact</button> -->
                
              </div>
              
          </div>
          
        </div>
        <div class="modal"><!-- Place at bottom of page --></div>
        <!-- footer start-->
        <? include '../include/footer.php'; ?>
      </div>
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <!-- Plugin used-->
    <script>
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

    function getDetail(tid, aa) {
      console.log("call get data");
      $.ajax({
          url: "../api/call_api.php",
          type: 'POST',
          data: {
              'command' : "contract_detail",
              'sectionid' : <?=$_SESSION['sectionid']?>,
              'tokenid' : tid,
          },
          success: function (data) {
            console.log(data);

            // var obj = JSON.parse(data);
            // if (obj.code==0) {
            //   var paid = obj.data.conInfo.paid;
            //   document.getElementById("paid_67").innerHTML = paid;
            // }
              
          }
      });
    }

    
    <? foreach ($res as $r) {  
      // $elementID = "paid_" . $r['id'];
      // $nextId = "next_" . $r['id'];
    ?>
      // getNextPeriod(<?=$r['id']?>,<?=$r['id']?> );
      //getDetail(<?=$tokenid?>, "<?=$elementID?>");  
    <? 
      } 
    ?>

    </script>
  </body>
</html>