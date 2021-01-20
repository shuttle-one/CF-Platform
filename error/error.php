<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php'; ?>
<?

$nextURL = $_REQUEST['bp'];
$err = $_REQUEST['e'];

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
        <br>
          <!-- <div class="page-header"> -->
          
            <div class="container-fluid">
              <div class="edit-profile">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="alert alert-danger" role="alert">
                      <h4 class="alert-heading">Sorry!</h4>
                        <p>Have an error occured with your process.</p>
                        <p><?=$err?></p>
                        <hr>
                        <a href="<?=$nextURL?>" class="btn btn-success">GO BACK</a>
                    </div>
                  </div>


                </div>
              </div>
            </div>
          <!-- </div> -->

          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <? include '../include/footer.php'; ?>
      </div>
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <!-- Plugin used-->
  </body>
</html>