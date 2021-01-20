<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php'; ?>
<? require_once ('../api/function.php'); ?>
<?

$config = include ('../api/config.php');

$userid = $_SESSION['userid'];

$menuid = 3;

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



include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "select c.*,d.title,d.id as did from loan_contract_v2 c left join loan_documents_v2 d on c.documentid=d.id where c.userid=$userid ";

//--- status --//
//  0 : Create
//  1 : Created on blockchain
//  2 : Approve and active
//  3 : Contract Close

if ($config['TEST']==1)
    $sql .= " and c.test=1 ";
else $sql .= " and c.test=0 ";

$sql .= " and date(c.updatedate)>='$date_range[0]' and date(c.updatedate)<='$date_range[1]' order by c.active_date desc";

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
                        <h5>Credit Line </h5>
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


                      <!-- <div class="col text-right">
                        <a href="creditline_create.php">
                          <button type="button" class="btn btn-secondary "> <span class="icon-plus"></span> Create Credit Line</button>
                        </a>
                      </div> -->
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-border-horizontal">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Credit ID.</th>
                          <th scope="col">Loan Title</th>
                          <th scope="col">txHash</th>
                          <th scope="col">Debt</th>
                          <th scope="col">Apr/Yr</th>
                          <th scope="col">Estimated 24hr Interest Rate</th>
                          <th scope="col">Principle</th>
                          <th scope="col">Loan Date</th>
                          <th scope="col">Maturity Date</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?
                          $i=0;
                          foreach ($res as $r) {  $i++; 
                            $status = $r['status'];

                            $nextId = "next_" . $r['id'];
                      ?>

                        <tr>
                          <th scope="row"><?=$i?></th>
                          <td><?=$r['id']?></td>
                          <td><?=$r['title']?></td>
                          <td><a href="https://etherscan.io/tx/<?=$r['txhash']?>" target="_blank"><?=substr($r['txhash'],0,15)?> ...</a></td>
                          <td><?=number_format($r['amount'],4,'.',',')?></td>
                          <td><?=number_format($r['apr'],2,'.',',')?></td>
                          <td>
                            <? if ($r['status']==2) { ?>
                            <div id="int_<?=$r['id']?>">loading ...</div>
                            <? } ?>
                          </td>
                          <td><?=number_format($r['principle'],4,'.',',')?></td>
                          <td><?=$r['active_date']?></td>
                          <td><div id="<?=$nextId?>"></div></td>
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

    function contractActive(cid) {
      $body = $("body");
      $body.addClass("loading");

      $.ajax({
          url: "../api/call_api.php",
          type: 'POST',
          data: {
              'command' : "contract_active",
              'sectionid' : <?=$_SESSION['sectionid']?>,
              'contractid' : cid,
          },
          success: function (data) {
            $body.removeClass("loading");

            var obj = JSON.parse(data);
            if (obj.code==0) {
              console.log("Return From contract_active");
              console.log(data);

              var name = "start_" + cid;
              document.getElementById(name).innerHTML = "<span class=\"badge badge-pill badge-success\">Started</span>"; 

            }else {
              alert(obj.data);

            }
            
            // var obj = JSON.parse(data);
            // if (obj.code==0) {
            //   var paid = obj.data.conInfo.paid;
            //   document.getElementById("paid_67").innerHTML = paid;
            // }
              
          }
      });
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

    function getNextPeriod(cid, eid) {

      var nextId = "next_" + eid;

      $.ajax({
          url: "../api/call_api.php",
          type: 'POST',
          data: {
              'command' : "next_period",
              'sectionid' : <?=$_SESSION['sectionid']?>,
              'contractid' : cid,
          },
          success: function (data) {
            // console.log("set to id " + nextId);
            // console.log(data);

            var obj = JSON.parse(data);

            if (obj.code==0) {
              var n = obj.data;
              document.getElementById(nextId).innerHTML = n;
            }else if (obj.code == 2) {
              alert(obj.data);
              window.location.href = '../login/login.php';
            }else 
              alert(obj.data);
          }
      });
    }

    function callPeriod() {

      
      <? foreach ($res as $r) { 
      // $nextId = "next_" . $r['id'];
      ?>
      <? if ($r['status']==2) {?>
        getNextPeriod(<?=$r['id']?>,<?=$r['id']?>);
      <? } ?>
    <? } ?>
    }

    function refreshInter () {


    <? foreach ($res as $r) { ?>
      <? if ($r['status']==2) {?>
        checkInterest(<?=$r['id']?>);
      <? } ?>
    <? } ?>
    }

    
    setInterval(function(){ refreshInter (); }, 5000);
    refreshInter ();
    callPeriod();

    </script>
  </body>

</html>