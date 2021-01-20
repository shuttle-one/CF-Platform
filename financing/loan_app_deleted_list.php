<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?
$menuid = 2;
$userid = $_SESSION['userid'];
$config = include ('../api/config.php');

$thisdate = date("m/d/Y");
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

  $currdr[0] = $date1;//$thisdate;
  $currdr[1] = $thisdate;
}

include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "select * from loan_documents_deleted where userid=$userid and complete_agreement=0 and date(deletedate)>='$date_range[0]' and date(deletedate)<='$date_range[1]'";
if ($config['TEST']==1)
    $sql .= " and test=1 ";
  else $sql .= " and test=0 ";
$sql .= " order by deletedate";

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
                      <div class="col-md-4">
                        <h5>Deleted Loan Applications</h5>
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
                    </div>
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
                          <th scope="col">Debt</th>
                          <th scope="col">Created Date</th>
                          <th scope="col">Deleted Date</th>
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

                          $score = $r['score'];
                          if ($score == -1)
                            $score = 'Pending';

                          $max_borrow = $r['max_borrow'];
                          if ($max_borrow==-1) 
                            $max_borrow = "Pending";

                      ?>
                        <tr>
                          <th scope="row"><?=$i?></th>
                          <td><?=$r['title']?></td>
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
                          <!-- <td><i data-feather="check" style="color: green;"></i></td> -->
                          <td><?=$r['createdate']?></td>
                          <td>
                            <?=$r['deletedate']?>
                          </td>
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
    </script>
  </body>
</html>