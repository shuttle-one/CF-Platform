<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<? require_once ('../api/function.php'); ?>
<?
$menuid = 5;
$userid = $_SESSION['userid'];
$sectionid = $_SESSION['sectionid'];
$walletid = $_SESSION['walletid'];

$arr = getWallet($sectionid);

if ($arr['code']=='0') { //---- SUCCESS
  $summary = $arr['summary'];
  $currency = $arr['currency'];
  $szoAmount = $arr['xse'];
}else if ($arr['code']==2) {
?>
<script>
  alert('<?=$arr['data']?>');
  window.location.href = '../login/logout.php';
</script>
<?
} else {?>
<script>
  alert('<?=$arr['data']?>');
</script>
<?
}


$cObj = withdrawCountry($sectionid);

if ($cObj['code']==0) {
  $countrylist = $cObj['data']['country'];

  for($i=0;$i<count($countrylist);$i++) {
    $countrylist[$i]['cname'] = explode(" ", $countrylist[$i]['name'])[0];
  }

}

// $sql = "select * from withdraw_bkk where fromid=$walletid order by tranid desc";
// $db->sql($sql);
// $res = $db->getResult();

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
                      <h5>CalistaPay
                      </h5>
                    </div>
                    <div class="card-body">
                      <!-- <form class="form-horizontal" method="post" action="wallet_withdraw_submit.php" onsubmit="return validateFrm(this);"> -->
                      <form>
                        <fieldset>

                        <div class="form-group row">
                          <label class="col-lg-12 control-label text-lg-left" for="amount">Send To</label>  
                          <div class="col-lg-12">

                            <select class="form-control input-md" name="country" id="country" onchange="selectCountry();">
                                <option value=""> -- Select --</option>
                              <? foreach($countrylist as $l) { ?>
                                <option value="<?=$l['code']?>"><?=$l['name']?></option>
                              <? } ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-lg-12 control-label text-lg-left" for="amount">Bank Account</label>  
                          <div class="col-lg-12">

                            <select class="form-control input-md" id="bank_account" name="bank_account">
                                <option value=""> -- Select --</option>
                              <? foreach($bankRes as $r) { ?>
                                <option value="<?=$r['id']?>"><?=$r['account_name']?> <?=$r['bank_name']?> - [Account No. <?=$r['account_number']?>]</option>
                              <? } ?>
                            </select>
                          </div>
                        </div>


                        <!-- Text input-->
                        <div class="form-group row">
                          <label class="col-lg-4 control-label text-lg-left" for="amount">You Send</label> 

                          <label class="col-lg-3 control-label text-lg-left" for="amount"></label> 

                          <label class="col-lg-4 control-label text-lg-left" for="amount">Recipient Receives</label> 

                          <div class="col-lg-4">
                            <div class="input-group mb-3">
                              <input class="form-control" type="text" id="amount" name="amount">
                              <div class="input-group-append"><span class="input-group-text"><?=$currency?></span></div>
                            </div>
                          </div>

                          <div class="col-lg-3">
                           <button type="button" class="btn btn-success" id="btn_check_rate"> CALCULATE </button>
                          </div>

                          <div class="col-lg-4">
                            <div class="input-group mb-3">
                              <input class="form-control" type="text" id="camount" name="camount" readonly="">
                            </div>
                          </div>


                        </div>

                        <!-- Button -->
                        <div class="form-group row text-lg-right">
                          <label class="col-lg-12 control-label text-lg-left" for="btn_create"></label>
                          <div class="col-lg-12">
                            <button type="button" id="btn_create" name="btn_create" class="btn btn-primary">SEND</button>
                          </div>
                        </div>

                        </fieldset>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header">
                        <h5>Last Transactions</h5>
                      </div>
                      <div class="card-body">
                        <div class="table-responsive">
                          <table class="display" id="basic-2">
                            <thead>
                              <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Account</th>
                                <th scope="col">No.</th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                              <? foreach ($trans as $t) { 
                                $badge_color = "success";
                                $inout_icon = "<i data-feather=\"arrow-down-left\"></i>";

                                if (strtolower($t['detail'])=='fail') {
                                  $badge_color = "danger";
                                }else if (strtolower($t['detail'])=='success') {
                                  $badge_color = "success";
                                }else if (strtolower($t['detail'])=='cancel') {
                                  $badge_color = "warning";
                                }

                                if (strtolower($t['type'])=='in') {
                                  $inout_icon = "<i data-feather=\"arrow-down-left\"></i>";
                                } else if (strtolower($t['type'])=='out') {
                                  $inout_icon = "<i data-feather=\"arrow-up-right\"></i>";
                                }
                              ?>
                              <tr>
                                <th scope="row"><?=$t['createdate']?></th>
                                <td><?=$t['amount']?></td>
                                <td><?=$t['account_name']?></td>
                                <td><?=$t['account_number']?></td>
                                <td>action</td>
                              </tr>
                            <? } ?>


                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div> -->

              </div>

          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <? include '../include/footer.php'; ?>
      </div>
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <script src="../assets/js/tools.js"></script>
    <script>

      var countrys = [
      <?foreach ($countrylist as $c) { ?>
        '<?=$c['cname']?>',
      <? } ?>]
      function validateFrm(t) {

        if ($("#bank_account").val() == 0)
        {
          alert("Please select Bank Account");
          return false;
        }


        var a = t['amount'].value;
        var val = Number(a);

        if(String(val) == 'NaN' || val==0) {
          alert('Please input amount with number and more than 0.00');
          t['amount'].value = '0.00';

          return false;
        }

        return true;
      }

      function selectCountry() {
        var ccode = $("#country").val();
        // if (ccode==0) {
          // alert("Select country you want to pay");
          // return;
        // }

        $("#amount").val('');
        $("#camount").val("");

//---- GET BANK COUNTRY

        $.ajax({
          url: "../api/call_api.php",
          type: 'GET',
          data: {
              'command' : "bank_select",
              'uid' : <?=$userid?>,
              'country' : countrys[document.getElementById("country").selectedIndex - 1],// $("#country").val(),
          },
          success: function(data) {

            var obj = JSON.parse(data);
            var data = obj.data;

            $('#bank_account').empty();
            $('#bank_account')
                .append($('<option>').val('0').text("-- Select --"));

            for (i=0;i<data.length;i++) {
              var text = data[i].account_name + " [ " + data[i].account_number + " ] " + data[i].bank_name;
              $('#bank_account')
                .append($('<option>').val(data[i].id).text(text));
            }
          }
        });


      }

      function checkRate () {


//---- CHECK RATE

        $.ajax({
          url: "../api/call_api.php",
          type: 'GET',
          data: {
              'command' : "withdraw_rate",
              'sectionid' : <?=$sectionid?>,
              'amount' : $("#amount").val(),
              'country' : $("#country").val(),
          },
          success: function (data) {
            
            // console.log(data);

            var obj = JSON.parse(data);
            if (obj.code == 0) {
              $("#camount").val(obj.data.amount + ' ' + obj.data.currency);
              // $("#currency").text(obj.data.currency);
            }else if (obj.code == 2)
            {
              alert(obj.data);
              window.location.href = '../login/logout.php';
            }
          }
        });


      }

      $("#btn_check_rate").on("click", function() {
        checkRate();
      });

      $("#btn_create").on("click", function() {
        submit ();
      });

      function submit () {
        var bankaccount = $("#bank_account").val();
        var amount = $("#amount").val();
        var country = $("#country").val();
        if (bankaccount=='' || amount=='' || country=='') {
          alert("Please enter all field before submit");
        } else {

          $.ajax({
            url: "wallet_withdraw_submit.php",
            type: 'POST',
            data: {
                'bank_account' : <?=$sectionid?>,
                'amount' : $("#amount").val(),
                'country' : $("#country").val(),
            },
            success: function (data) {

              var obj = JSON.parse(data);
              if (obj.code == 0) {
                
              }
            }
          });

        }


      }

    </script>
    <!-- Plugin used-->
  </body>
</html>