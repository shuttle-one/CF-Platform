<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php'; ?>
<?
$menuid = 3;
$docid = $_REQUEST['did'];
$creditid = $_REQUEST['cid'];
$userid = $_SESSION['userid'];

$config = include ('../api/config.php');

include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "select * from loan_documents_v2 where id=$docid";

if ($config['TEST']==1)
    $sql .= " and test=1 ";
  else $sql .= " and test=0 ";

$db->sql($sql);
$res = $db->getResult();

$sql = "select * from loan_contract_v2 where id=$creditid";

if ($config['TEST']==1)
    $sql .= " and test=1 ";
  else $sql .= " and test=0 ";

$db->sql($sql);
$cres = $db->getResult();

$statustext = "";

if (count($res) == 1) {

    if ($res[0]['status']==0) 
        $statustext = "Create";
    else if ($res[0]['status']==1) 
        $statustext = "Submit";
    else if ($res[0]['status']==2) 
        $statustext = "Opened";
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

          <div class="container-fluid">

          <? include '../include/header_space.php';?>

              <div class="row">
                <div class="col-xl-7 xl-50 col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <h5>Credit Line Information</h5>
                    </div>
                    <div class="card-body">
                      <!-- <form class="form-horizontal needs-validation" action="creditline_create_submit.php"> -->
                        <input type="hidden" name="docid" value="<?=$res[0]['id']?>">
                        <fieldset>
                        <!-- Text input-->
                        <div class="form-group row">
                          <label class="col-lg-12 control-label text-lg-left" for="amount">Amount</label>  
                          <div class="col-lg-12">
                            <h4><?=number_format($cres[0]['amount'],2,'.',',')?></h4>
                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group row">
                          <label class="col-lg-12 control-label text-lg-left" for="currency">Currency</label>  
                          <div class="col-lg-12">
                            <h4><?=$cres[0]['currency']?></h4>
                          </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group row">
                          <label class="col-lg-12 control-label text-lg-left" for="btn_create"></label>
                          <div class="col-lg-12">
                            <!-- <button id="btn_create" name="btn_create" class="btn btn-primary">Create</button> -->
                            <a href="creditline_list.php"><button type="button" class="btn btn-secondary">Back</button></a>

                            <? if ($cres[0]['status']!=2) { ?>
                            <button type="button" class="btn btn-danger" id="btn_del">Remove</button>
                            <? } ?>
                          </div>
                        </div>

                        </fieldset>

                    </div>
                  </div>
                </div>

                <div class="col-xl-5 xl-50 col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h5>Invoice Status : <span class="text-success"><?=$statustext?></span></h5>
                  </div>
                  <div class="card-body">
                    <div class="progress-block">
                      <h6><span>Invoice No.</span><span class="pull-right"><b><?=$res[0]['title']?></b></span></h6>
                    </div>


                    <div class="progress-block">
                      <span>Maximum Borrow Amount</span><span class="pull-right"><b><?=number_format($res[0]['max_borrow'],6,'.',',')?> USD</b></span>
                    </div>

                    <div class="progress-block">
                      <span>Debt</span><span class="pull-right"><b><?=number_format($res[0]['debit'],6,'.',',')?> USD</b></span>
                    </div>

                    <div class="progress-block">
                      <span>Interest Rate.</span><span class="pull-right"><b><?=number_format($res[0]['apr'],2,'.',',')?> %</b></span>
                    </div>

                    <div class="progress-block">
                      <span>Score</span><span class="pull-right"><b><?=$res[0]['score']?></b></span>
                    </div>

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
  </body>
    <script>

var interTimeout;
var interSubmit;

function callLoading() {
    
    var amount = $("#amount").val();
    var currency = $("#currency").val();
    if (amount == '' || currency =='') {
        alert("Please field amount and currency");
        return false;
    }else {
        $body = $("body");
        $body.addClass("loading");
        $("#btn_new_doc").css("display","none");
        // $("#btn_resubmit").css("display","block");
        // submit();
        interSubmit = setTimeout(function(){ submit(); } , 500);
        interTimeout = setTimeout(function(){ timeout(); } , 15000);
    }

    return false;

}

$("#btn_del").on('click', function() {
  if (confirm("Confirm remove this credit line.")){
    $.ajax({
        url: "creditline_del.php",
        type: 'POST',
        data: {
            'cid' : <?=$creditid?>,
        },success: function (data) {
          if (data==1)
          {
            window.location.href='creditline_list.php';
          }else {
            alert("Delete fail, please try again.");
          }
        }
    });
  }
});

function timeout() {
    // $("#btn_new_doc").css("display","block");
    $("#btn_new_doc").css("display","block");
    $body = $("body");
    $body.removeClass("loading");
    clearTimeout(interTimeout);
}

function submit() {
    clearTimeout(interSubmit);
    console.log("submit");
    $("#frm").submit();
}

function goBack() {
  window.history.back();
}
</script>
</html>