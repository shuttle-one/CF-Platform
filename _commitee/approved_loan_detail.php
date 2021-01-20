<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/commitee_authen.php';?>
<?

include '../include/database.php';
$db = new Database();  
$db->connect();

$loandocid = $_REQUEST['id'];
$config = include ('../api/config.php');

$sql = "select * from loan_doc_type";
$db->sql($sql);
$typeRes = $db->getResult();


$sql = "select * from loan_documents_v2 where id=$loandocid";
if ($config['TEST']==1)
    $sql .= " and test=1 ";
else $sql .= " and test=0 ";

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
        <? include '../include/commitee_left_bar.php'; ?>
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
                    <h5>Audit</h5>
                  </div>

                    <div class="card-body">
                      <div class="row form-group">
                        <div class="col-sm-12 form-group">
                          <label>Score</label>
                          <input class="form-control" name="score" id="score" type="text" placeholder="" value="<?=$res[0]['score']?>" readonly>
                        </div>

                        <div class="col-sm-12 form-group">
                          <label>Debt</label>
                          <input class="form-control" name="debt" id="maxborrow" type="maxborrow" placeholder="" value="<?=$res[0]['max_borrow']?>" readonly>
                        </div>

                        <div class="col-sm-12 form-group">
                          <label>Audit Approve Date</label>
                          <input class="form-control" name="debt" id="maxborrow" type="maxborrow" placeholder="" value="<?=$res[0]['audit_approve_date']?>" readonly>
                        </div>

                        <div class="col-sm-12 form-group">
                          <label>Legal Approve Date</label>
                          <input class="form-control" name="debt" id="maxborrow" type="maxborrow" placeholder="" value="<?=$res[0]['legal_approve_date']?>" readonly>
                        </div>
                      </div>

                      <button type="button" id="btn_back" class="btn btn-primary">Back</button>
                    </div>


                </div>
              </div>

              <div class="col-sm-6">
              <? if (count($res)==1) { ?>

                <div class="card">
                      <div class="card-header">
                        <h5>Create Loan Application</h5>
                        <!-- <span>Using the <a href="#">card</a> component, you can extend the default collapse behavior to create an accordion.</span> -->
                      </div>
                      <div class="card-body">
                        

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="title">Invoice Title</label>
                            <div class="col-sm-9">
                              <h6><?=$res[0]['title']?></h6>
                            </div>
                          </div>


                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="type">Invoice Type</label>
                            <div class="col-sm-9">
                            <? foreach($typeRes as $r) { 
                                if($r['doctypeid']==$res[0]['doc_type']) {
                              ?>
                                <h6><?=$r['doctitle']?></h6>
                            <? } }?>
                              
                            </div>
                          </div>

                          <hr>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file1">Banker's Guarantee
                              </label>
                            <div class="col-sm-9">
                              <?if ($res[0]['file1']!='') { ?>
                                <a href="../assets/docs/<?=$res[0]['file1']?>" target="_blank"><img src="../assets/docs/<?=$res[0]['file1']?>" width="100"></a>
                              <? } ?>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file2">Trade Invoice</label>
                            <div class="col-sm-9">
                              <?if ($res[0]['file2']!='') { ?>
                                <a href="../assets/docs/<?=$res[0]['file2']?>" target="_blank"><img src="../assets/docs/<?=$res[0]['file2']?>" width="100"></a>
                              <? } ?>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file3">Month 1 Bank Statement</label>
                            <div class="col-sm-9">
                              <?if ($res[0]['file3']!='') { ?>
                                <a href="../assets/docs/<?=$res[0]['file3']?>" target="_blank"><img src="../assets/docs/<?=$res[0]['file3']?>" width="100"></a>
                              <? } ?>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file4">Month 2 Bank Statement</label>
                            <div class="col-sm-9">
                              <?if ($res[0]['file4']!='') { ?>
                                <a href="../assets/docs/<?=$res[0]['file4']?>" target="_blank"><img src="../assets/docs/<?=$res[0]['file4']?>" width="100"></a>
                              <? } ?>
                            </div>
                          </div>
                      </div>

                    </div>
                    </form>
                  <? } else { echo "Not found this loan application."; }?>
              </div> 
            </div>
          </div>
          
        </div>
        <!-- footer start-->
        <? include '../include/footer.php'; ?>
        <div class="modal"><!-- Place at bottom of page --></div>

      </div>
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <!-- Plugin used-->.
    <script>


    $("#btn_back").click(function() {
      window.history.back();
    });

    
    </script>
  </body>
</html>