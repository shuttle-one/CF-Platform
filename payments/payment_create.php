<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<? require_once ('../api/function.php'); ?>
<?
include '../include/database.php';
$db = new Database();  
$db->connect();

$userid = $_SESSION['userid'];
$sectionid = $_SESSION['sectionid'];

$config = include ('../api/config.php');

$wallet = getWallet($sectionid);

if ($wallet['code']=='0') { //---- SUCCESS
  $summary = $wallet['summary'];
  $currency = $wallet['currency'];
  $szoAmount = $wallet['xse'];
}else if ($wallet['code'] == 2) {
  ?>
<script>
  alert('<?=$arr['data']?>');
  window.location.href = '../login/logout.php';
</script>
  <?
}

$sql = "select ct.*, v2.title from loan_contract_v2 ct inner join loan_documents_v2 v2 on ct.documentid=v2.id where ct.userid=$userid and ct.status=2";

if ($config['TEST']==1)
    $sql .= " and ct.test=1 ";
  else $sql .= " and ct.test=0 ";

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

        <? include '../include/header_space.php';?>


            <div class="container-fluid">
              <div class="row">

                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-header">
                      <h5>Balance</h5>

                    </div>

                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-8">
                          <h5><?=$summary ?> <?=$currency?></h5>
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
                          <h5><?=$szoAmount?></h5>
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
                      <h5>Repay Detail</h5>
                    </div>
                    <div class="card-body">
                      <form class="form-horizontal" id="frm" method="post" action="payment_submit.php">
                        <fieldset>


                        <div class="form-group row">
                          <label class="col-sm-12 col-form-label" for="type">Select loan you want to repay</label>
                          <div class="col-sm-12">
                            <select id="loanid" name="loanid" style="border: 1px" class="form-control">
                              <? foreach($res as $r) { 
                                $sum = $r['principle'] + $r['interest'];
                              ?>
                                <option value="<?=$r['id']?>"><?=$r['title']?> | (<?=number_format($sum,4,'.',',')?>) | <?=number_format($r['principle'],2,'.',',')?> <?=$r['currency']?> | <?=number_format($r['interest'],2,'.',',')?> <?=$r['currency']?></option>
                              <? } ?>
                            </select>
                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group row">
                          <label class="col-lg-12 control-label text-lg-left" for="amount">Amount</label>  
                          <div class="col-lg-12">
                          <input id="amount" name="amount" type="text" placeholder="0.000000" class="form-control input-md">
                          </div>
                        </div>

                        <input type="hidden" name="txhash" id="txhash" value="">

                        <!-- Button -->
                        <div class="form-group row">

                          <div class="col-lg-12">
                            <button type="button" id="btn_create" name="btn_create" class="btn btn-primary">REPAY</button>
                          </div>
                        </div>

                        </fieldset>
                      </form>
                    </div>
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

        if (!confirm("Are you sure to pay with this amount?"))
          return;
        
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
            
            

            // alert(data);
            // location.reload();
          }
        });
      });
    </script>
    <!-- Plugin used-->
  </body>
</html>