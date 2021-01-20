<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<? require_once ('../api/function.php'); ?>
<?
$menuid = 4;
$sectionid = $_SESSION['sectionid'];

if ($arr['code']==2) {
?>
<script>
  alert('<?=$arr['data']?>');
  window.location.href = '../login/logout.php';
</script>
<?
}

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

                <div class="col-xl-12 xl-50 col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h5>Topup With Credit Card</h5>
                    </div>
                    <div class="card-body">
                      <div class="row">

                        <div class="col">
                          <div class="form-group m-t-15 m-checkbox-inline mb-0 custom-radio-ml">
                            <div class="radio radio-primary">
                              <input id="radioinline2" type="radio" name="token" value="GET" checked="" onclick="changeCurrency(this)">
                              <label class="mb-0" for="radioinline2">BALANCE</label>
                            </div>

                            <div class="radio radio-primary">
                              <input id="radioinline1" type="radio" name="token" value="SZO" onclick="changeCurrency(this)">
                              <label class="mb-0" for="radioinline1">POINT</label>
                            </div>
                            

                          </div>
                        </div>

                      </div>
                      <br><br>
                        <fieldset>

                        <!-- Text input-->
                        <div class="form-group row">

                            

                          <div class="col-lg-5">
                            <label class="col-lg-12 control-label text-lg-left" for="amount">Amount you want</label>
                            <div class="input-group mb-3">
                              <input class="form-control" type="text" id="famount" name="famount" onchange="resetPrice()">
                              <div class="input-group-append"><span id="cshow" class="input-group-text">USD</span></div>
                            </div>

                            <div class="col-lg-12">
                              <button type="button" id="btn_cal" name="btn_cal" class="btn btn-success">CHECK PRICE</button>
                            </div>
                          </div>


                          <div class="col-lg-2 text-center">
                            <i data-feather="chevrons-right"></i>
                          </div>

                          <div class="col-lg-5">
                            
                            <form class="form-horizontal" method="post" action="wallet_topup_credit_prepare.php" id="frm_credit">
                              <fieldset>


                              <!-- Text input-->
                              <!-- <div class="form-group row">
                                <label class="col-lg-12 control-label text-lg-left" for="textinput">Price</label>  
                                <div class="col-lg-12">
                                <input id="showprice" name="showprice" type="text" class="form-control btn-square input-md" readonly="">
                                </div>
                              </div> -->

                              <div class="form-group row">
                                <label class="col-lg-12 control-label text-lg-left" for="amount">You will pay</label>  
                                <div class="col-lg-12">
                                <input id="showamount" name="showamount" type="text" class="form-control btn-square input-md" readonly="">
                                </div>
                              </div>



                              <input type="hidden" id="sum" name="sum">
                              <input type="hidden" id="symbol" name="symbol" value="GET">
                              <input type="hidden" id="camount" name="camount">
                              <input type="hidden" id="sectionid" name="sectionid">
                              <input type="hidden" id="wallet" name="wallet">
                              <input type="hidden" id="price" name="price">
                              <input type="hidden" id="fee" name="fee">
                              <input type="hidden" id="resv" name="resv">
                              <input type="hidden" id="orderno" name="orderno">
                              <input type="hidden" id="currency" name="currency">
                              <input type="hidden" id="total" name="total">

                              </fieldset>

                              <div class="col-lg-6 text-right">
                                <button type="button" id="btn_next" name="btn_next" class="btn btn-primary">CONTINUE</button>
                              </div>

                            </form>

                          </div>

                        </div>
                        <div class="col-lg-12 text-right">
                            <br>
                            *the amount of value topped up may vary according to the payment processor
                          </div>

                        <!-- Button -->
                        <div class="form-group row">

                        </div>

                        </fieldset>
                  </div>
                </div>
              </div>

          </div>
          <!-- Container-fluid Ends-->
        </div>
      </div>
      <div class="modal"><!-- Place at bottom of page --></div>
        <!-- footer start-->
        <? include '../include/footer.php'; ?>
      </div>
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <script src="../assets/js/tools.js"></script>
    <script>

      function changeCurrency(th) {
        // alert("Change to " + th.value);
        if (th.value == 'SZO'){
          $("#cshow").text("POINT");
          $("#symbol").val('SZO');
        }
        if (th.value == 'GET'){
          $("#cshow").text("USD");
          $("#symbol").val('GET');
        }


      }

      function convertRate(amount) {

        $body = $("body");
        $body.addClass("loading");

        $.ajax({
          url: "../api/call_api.php",
          type: 'GET',
          data: {
              'command' : "topup_check_price",
              'sectionid' : <?=$sectionid?>,
              'amount' : amount,
              'token' : $("#symbol").val(),
          },
          success: function (data) {
            

            var obj = JSON.parse(data);
            console.log(data);

            if (obj.code == 0) {
              var d = new Date();
              var n = d.getTime();
              var orderno = obj.data.price.symbol.toUpperCase() + n;
              var p = format(obj.data.price.price) + ' ' + obj.data.price.currency + '/ USD';// + obj.data.price.symbol;

              // $("#showamount").val(format(obj.data.price.total));
              var showcurrency = obj.data.price.showcurrency;
              $("#showamount").val(format(obj.data.price.showtotal) + ' ' + showcurrency);
              $("#showprice").val(p);

              $("#camount").val(obj.data.price.amount);
              // $("#symbol").val(obj.data.price.symbol);
              // $("symbol").val(token[0].value);
              $("#currency").val(obj.data.price.currency);
              $("#fee").val(obj.data.price.fee);
              $("#price").val(obj.data.price.price);
              $("#resv").val(obj.data.price.resv);
              $("#sum").val(obj.data.price.sum);
              $("#total").val(obj.data.price.total);
              $("#wallet").val(obj.data.wallet_internal);
              $("#orderno").val(orderno);



            }else if (obj.code == 2)
            {
              alert(obj.data);
              window.location.href = '../login/logout.php';
            }

            $body.removeClass("loading");
          }
        });
      }

      $("#btn_cal").on("click", function() {
        var amount = $("#famount").val();

        convertRate(amount);

      });

      $("#btn_next").on("click", function() {
        reserve();
      })

      function reserve() {

        if ($("#resv").val()=='') {
          var amount = $("#famount").val();
          alert("Please click Check Price before continue.");
          // convertRate(amount);
          return;
        }

        $body = $("body");
        $body.addClass("loading");

        $.ajax({
          url: "../api/call_api.php",
          type: 'GET',
          data: {
              'command' : "topup_reserve",
              'sectionid' : <?=$sectionid?>,
              'resv' : $("#resv").val(),
          },
          success: function (data) {

            $body.removeClass("loading");
            console.log(data);

            var obj = JSON.parse(data);
            console.log("Code = " + obj.code);

            if (obj.code==0) {
              $("#frm_credit").submit();
            }else {
              alert(obj.data);
            }

          }
        });
      }



    </script>
    <!-- Plugin used-->
  </body>
</html>