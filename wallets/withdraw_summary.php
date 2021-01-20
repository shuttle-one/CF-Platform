<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
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
                    <div class="card">
                      <div class="card-header">
                        <h4 class="card-title mb-0">WITHDRAW SUMMARY</h4>
                        <div class="card-options"><a class="card-options-collapse" href="#" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                      </div>

                      <div class="card-body">
                        <form class="form-horizontal">
                          <fieldset>


                          

                          <!-- Text input-->
                          <div class="form-group row">
                            <label class="col-lg-12 control-label text-lg-left" for="textinput">Text Input</label>  
                            <div class="col-lg-12">
                            <input id="textinput" name="textinput" type="text" placeholder="placeholder" class="form-control btn-square input-md" readonly>
                            </div>
                          </div>

                          <!-- Text input-->
                          <div class="form-group row">
                            <label class="col-lg-12 control-label text-lg-left" for="textinput">Text Input</label>  
                            <div class="col-lg-12">
                            <input id="textinput" name="textinput" type="text" placeholder="placeholder" class="form-control btn-square input-md">
                            <p class="help-block">help</p>  
                            </div>
                          </div>

                          <!-- Text input-->
                          <div class="form-group row">
                            <label class="col-lg-12 control-label text-lg-left" for="textinput">Text Input</label>  
                            <div class="col-lg-12">
                            <input id="textinput" name="textinput" type="text" placeholder="placeholder" class="form-control btn-square input-md">
                            <p class="help-block">help</p>  
                            </div>
                          </div>

                          <div class="form-group row">

                            <div class="col-lg-12">
                              <button id="singlebutton" name="singlebutton" class="btn btn-info">Back</button>
                            </div>
                          </div>

                          </fieldset>
                          </form>
                      </div>
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