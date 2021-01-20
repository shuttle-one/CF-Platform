<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen_admin.php';?>
<?
$menuid = 3;
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
        <? include '../include/admin_left_bar.php'; ?>
        <!-- Page Sidebar Ends-->
        <!-- Right sidebar Start-->
        <? include '../include/right_bar.php'; ?>
        <!-- Right sidebar Ends-->
        <div class="page-body">

          <? include '../include/header_space.php';?>

          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
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

                                  <embed src="../assets/docs/<?=$res[0]['file1']?>" width="150px" />
                                    <a href="../assets/docs/<?=$res[0]['file1']?>" target="_blank">
                                  <i class="icon-new-window"></i>
                                </a>
                                
                              <? } ?>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file2">Trade Invoice</label>
                            <div class="col-sm-9">
                              <?if ($res[0]['file2']!='') { ?>
                                <embed src="../assets/docs/<?=$res[0]['file2']?>" width="150px" />
                                    <a href="../assets/docs/<?=$res[0]['file2']?>" target="_blank">
                                  <i class="icon-new-window"></i>
                                  </a>
                              <? } ?>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file3">Month 1 Bank Statement</label>
                            <div class="col-sm-9">
                              <?if ($res[0]['file3']!='') { ?>
                                <embed src="../assets/docs/<?=$res[0]['file3']?>" width="150px" />
                                    <a href="../assets/docs/<?=$res[0]['file3']?>" target="_blank">
                                  <i class="icon-new-window"></i>
                                  </a>
                              <? } ?>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file4">Month 2 Bank Statement</label>
                            <div class="col-sm-9">
                              <?if ($res[0]['file4']!='') { ?>
                                <embed src="../assets/docs/<?=$res[0]['file4']?>" width="150px" />
                                    <a href="../assets/docs/<?=$res[0]['file4']?>" target="_blank">
                                  <i class="icon-new-window"></i>
                                  </a>
                              <? } ?>
                            </div>
                          </div>
                      </div>
                      <div class="card-footer">

                        <a href="finance_list.php"><button type="button" class="btn btn-secondary">Back</button></a>

                        <button type="button" class="btn btn-danger" id="btn_del_doc">Remove</button>
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
      </div>
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <!-- Plugin used-->
    <script>
    $("#btn_del_doc").on("click", function() {
        
        if (confirm("Do you realy want to delete?"))
        {
            $.ajax({
                url: "finance_del.php",
                type: 'POST',
                data: {
                    'id' : <?=$loandocid?>,
                },
                success: function (data) {
                  // alert(data);
                  
                    if (data=="1") {
                        alert("Success");
                        window.location.href = "index.php";
                    }
                }
            });
        }
    });
    </script>
    
  </body>
</html>