<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?
$config = include ('../api/config.php');
$root = $config["ROOT_PATH"];

$score = $_REQUEST['s'];
$apr = $_REQUEST['a'];
$credit = $_REQUEST['b'];

// echo "Score = " . $score;
// echo "APR = " . $apr;
// echo "Max Borrow = " . $max_borrow;
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


      <!-- Page Body Start-->
      <!-- <div class="page-body-wrapper"> -->

        <!-- Right sidebar Ends-->
        <div class="page-body">


          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">

                <div class="card">
                      <div class="card-header text-center">
                        <h5>Your Credit Line is</h5>
                        <!-- <span>Using the <a href="#">card</a> component, you can extend the default collapse behavior to create an accordion.</span> -->
                      </div>
                      <div class="card-body">

                          <div class="form-group row">

                            <div class="col-sm-12 text-center">
                              <h3 class="text-center">$<?=number_format($credit,2,'.',',')?></h3>
                              <br>
                              <h5>Your Estimated Credit Score</h5>
                              <h3 class="text-center"><?=$score?></h3>
                            </div>

                          </div>



                      </div>

                      <div class="card-footer text-center">
                        <a href="<?=$root?>login/login.php"><button type="button" class="btn btn-success">Sign Up</button></a>
                        <a href="<?=$root?>login/login.php"><button type="button" class="btn btn-secondary" id="btn_sign_in">Sign In</button></a>
                      </div>

                      <!-- <div class="card-footer text-center">
                        <a href="widget_loan_new.php"><button type="button" class="btn btn-success">Submit New Documents</button></a>
                        <button type="button" class="btn btn-secondary" id="btn_close">Close</button>
                      </div> -->
                    </div>

              </div>
            </div>
          </div>
          
        </div>
        <div class="modal"><!-- Place at bottom of page --></div>
        <!-- footer start-->
        <? include '../include/footer.php'; ?>
      <!-- </div> -->
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <!-- Plugin used-->.
   
  </body>
</html>