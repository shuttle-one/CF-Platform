<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<? require_once ('../api/function.php'); ?>
<?
$menuid = 4;
$sectionid = $_SESSION['sectionid'];

$arr = getTopupCountry($sectionid);

$country = array();

if ($arr['code']==2) {
?>
<script>
  alert('<?=$arr['data']?>');
  window.location.href = '../login/logout.php';
</script>
<?
}
if ($arr['code']==0) {
  $country = $arr['data']['country'];
}


$arr = getWallet($sectionid);

if ($arr['code']==0) { //---- SUCCESS
  $summary = $arr['summary'];
  $currency = $arr['currency'];
  $szoAmount = $arr['xse'];
}

$arr = topupBankList($sectionid);
if ($arr['code']==0) {
  $trans = $arr['data']['transection'];
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

        <? include '../include/header_space.php';?>


            <div class="container-fluid">
              
              <div class="row">

                <div class="col-xl-12 xl-50 col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h5>Topup With Bank Transfer</h5>
                    </div>
                    <div class="card-body">
                      <form class="form-horizontal" method="post" action="wallet_topup_prepare.php" id="topup_form">
                        <fieldset>


                        <!-- Text input-->
                        <div class="form-group row">
                          <label class="col-lg-12 control-label text-lg-left" for="amount">Select Country </label>  
                          <div class="col-lg-12">
                          
                          <select id="countryid" name="countryid" class="form-control input-md" onchange="updateCurrency(this)">
                            <? foreach ($country as $c) { ?>
                              <option value="<?=$c['code']?>"><?=$c['name']?></option>

                            <? } ?>
                          </select>
                          </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group row">

                           <!--  <div class="col-lg-5">
                              <input id="famount" name="famount" type="text" placeholder="0.000000" class="form-control input-md">
                            </div> -->

                            <div class="col-lg-5">
                              <label class="col-lg-12 control-label text-lg-left" for="amount">Amount to topup</label>  
                              <div class="input-group mb-3">
                                <input class="form-control" type="text" id="famount" name="famount">
                                <div class="input-group-append"><span class="input-group-text" id="fromCurrency"><?=$currency?></span></div>
                              </div>
                            </div>


                            <div class="col-lg-2 text-center">
                                <i data-feather="chevrons-right" style="margin-top: 20px"></i>
                              
                            </div>

                             
                            <div class="col-lg-5">
                              <label class="col-lg-12 control-label text-lg-left" for="amount">You Will Receive</label>
                              <div class="input-group mb-3">
                                <input class="form-control" type="text" id="camount" name="camount">
                                <div class="input-group-append"><span class="input-group-text" id="currency">USD</span></div>
                              </div>
                            </div>

                        </div>

                        <!-- Button -->
                        <div class="form-group row">

                          <div class="col-lg-6">
                            <button type="button" id="btn_cal" name="btn_cal" class="btn btn-success">CALCULATE</button>
                          </div>

                          <div class="col-lg-6 text-right">
                            <button type="button" id="btn_next" name="btn_next" class="btn btn-primary">CONTINUE</button>
                          </div>
                        </div>

                        </fieldset>
                      </form>

                  </div>
                </div>

                <div class="card">
                  <div class="table-responsive">
                    <table class="table table-border-horizontal">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Amount</th>

                          <th scope="col">Company</th>
                          <th scope="col">Date</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <? foreach($trans as $t) { 
                        $badge_color = "success";

                        if (strtolower($t['detail'])=='fail') {
                          $badge_color = "danger";
                        }else if (strtolower($t['detail'])=='complete') {
                          $badge_color = "primary";
                        }else if (strtolower($t['detail'])=='cancel') {
                          $badge_color = "warning";
                        }

                        $showDetail = $t['detail'];

                        if (strtolower($t['detail'])=="submited")
                          $showDetail = "Submit Document";
                        if (strtolower($t['detail'])=="wait document")
                          $showDetail = "Pending Document";
                      ?>
                        <tr>
                          <td scope="row">
                            <span class="badge badge-pill badge-<?=$badge_color?>"> <?=$showDetail?></span>
                          </td>
                          <td><?=$t['amountToPaid']?></td>
                          <td><?=$t['bank']?></td>
                          <td><?=$t['time']?></td>
                          <td>
                            <? if (strtolower($t['detail'])=='wait document') { ?>
                              <a href="wallet_topup_check.php?id=<?=$t['tranid']?>">
                                <button type="button" id="btn_next" name="btn_next" class="btn btn-primary">SUBMIT DOCUMENT</button>
                              </a>
                            <? } ?>
                          </td>
                        </tr>
                      <? } ?>
                      </tbody>
                    </table>
                      
                  </div>
                </div>

              </div>

          </div>
          <!-- Container-fluid Ends-->
        </div>
      </div>
        <!-- footer start-->
        <? include '../include/footer.php'; ?>
      </div>
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <script>

      var currArr = [ <? foreach ($country as $c) {
        echo "'".$c['currency']. "',";
      }
      ?> ];

      function updateCurrency(th) {
        var test = currArr[th.selectedIndex];
        $("#fromCurrency").text(test);
      }

      function convertRate(amount, ccode) {
        $.ajax({
          url: "../api/call_api.php",
          type: 'GET',
          data: {
              'command' : "topup_rate",
              'sectionid' : <?=$sectionid?>,
              'amount' : amount,
              'ccode' : ccode,
          },
          success: function (data) {

            var obj = JSON.parse(data);
            if (obj.code == 0) {
              $("#camount").val(obj.data.amount);
              $("#currency").text(obj.data.currency);
            }else if (obj.code == 2)
            {
              alert(obj.data);
              window.location.href = '../login/logout.php';
            }

            console.log(data);
            return;
          }
        });
      }

      $("#btn_cal").on("click", function() {
        var amount = $("#famount").val();
        var ccode = $("#countryid").val();

        convertRate(amount, ccode);

      });

      $("#btn_next").on("click", function() {
        var amount = $("#famount").val();
        var ccode = $("#countryid").val();

        if (amount!='') {
          $("#topup_form").submit();
        }
      });


      var test = currArr[0];
      $("#fromCurrency").text(test);


    </script>
    <!-- Plugin used-->
  </body>
</html>