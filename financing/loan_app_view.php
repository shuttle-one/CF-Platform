<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?

include '../include/database.php';
$db = new Database();  
$db->connect();

$userid = $_SESSION['userid'];
$loandocid = $_REQUEST['id'];
$config = include ('../api/config.php');

$sql = "select * from loan_doc_type";
$db->sql($sql);
$typeRes = $db->getResult();


$sql = "select * from loan_documents_v2 where id=$loandocid and userid=$userid";
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
        <? include '../include/left_bar.php'; ?>
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
                            <label class="col-sm-3 col-form-label" for="file1">Banker's Guarantee</label>
                            <div class="col-sm-9">
                              <?if ($res[0]['file1']!='') { ?>
                                
                                <? 
                                  $ar = explode('.',$res[0]['file1']);
                                  $ex = $ar[count($ar)-1];

                                  if (strtolower($ex)=='pdf') {
                                ?>
                                <a href="../assets/docs/<?=$res[0]['file1']?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Click to open attatched file</a>
                                <br>
                                <embed src="../assets/docs/<?=$res[0]['file1']?>" type="application/pdf" width="200px" height="200px" />

                                <? 
                                  } else if (strtolower($ex)=='jpg' || strtolower($ex)=='jpeg' || strtolower($ex)=='gif' || strtolower($ex)=='png') { // IMAGE
                                  ?>
                                  <a href="../assets/docs/<?=$res[0]['file1']?>" target="_blank"><i class="fa fa-file-image-o"></i> Click to open attatched file</a>
                                  <br>
                                  <img src="../assets/docs/<?=$res[0]['file1']?>" width="200px">
                                  <?
                                  }else if (strtolower($ex)=='xls' || strtolower($ex)=='xlsx') {
                                    ?>
                                    <a href="../assets/docs/<?=$res[0]['file1']?>" target="_blank"><i class="fa fa-file-excel-o"></i> Click to open attatched file</a>
                                    <?
                                  }else if (strtolower($ex)=='doc' || strtolower($ex)=='docs') {
                                    ?>
                                    <a href="../assets/docs/<?=$res[0]['file1']?>" target="_blank"><i class="fa fa-file-word-o"></i></a>
                                    <?
                                  }
                                } 
                                ?>

                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file2">Trade Invoice</label>
                            <div class="col-sm-9">
                              <?if ($res[0]['file2']!='') { ?>

                                <!-- <a href="../assets/docs/<?=$res[0]['file2']?>" target="_blank">Click to show</a>
                                <br> -->

                                <? 
                                  $ar = explode('.',$res[0]['file2']);
                                  $ex = $ar[count($ar)-1];

                                  if (strtolower($ex)=='pdf') {
                                ?>
                                <a href="../assets/docs/<?=$res[0]['file2']?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Click to open attatched file</a>
                                <br>
                                <embed src="../assets/docs/<?=$res[0]['file2']?>" type="application/pdf" width="200px" height="200px" />

                                <? 
                                  } else if (strtolower($ex)=='jpg' || strtolower($ex)=='jpeg' || strtolower($ex)=='gif' || strtolower($ex)=='png') { // IMAGE
                                  ?>
                                  <a href="../assets/docs/<?=$res[0]['file2']?>" target="_blank"><i class="fa fa-file-image-o"></i> Click to open attatched file</a>
                                  <br>
                                  <img src="../assets/docs/<?=$res[0]['file2']?>" width="200px">
                                  <?
                                  }else if (strtolower($ex)=='xls' || strtolower($ex)=='xlsx') {
                                    ?>
                                    <a href="../assets/docs/<?=$res[0]['file2']?>" target="_blank"><i class="fa fa-file-excel-o"></i> Click to open attatched file</a>
                                    <?
                                  }else if (strtolower($ex)=='doc' || strtolower($ex)=='docs') {
                                    ?>
                                    <a href="../assets/docs/<?=$res[0]['file2']?>" target="_blank"><i class="fa fa-file-word-o"></i> Click to open attatched file</a>
                                    <?
                                  }
                                } 
                                ?>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file3">Month 1 Bank Statement</label>
                            <div class="col-sm-9">
                              <?if ($res[0]['file3']!='') { ?>

                                <!-- <a href="../assets/docs/<?=$res[0]['file3']?>" target="_blank">Click to show</a>
                                <br> -->

                                <? 
                                  $ar = explode('.',$res[0]['file3']);
                                  $ex = $ar[count($ar)-1];

                                  if (strtolower($ex)=='pdf') {
                                ?>
                                <a href="../assets/docs/<?=$res[0]['file3']?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Click to open attatched file</a>
                                <br>
                                <embed src="../assets/docs/<?=$res[0]['file3']?>" type="application/pdf" width="200px" height="200px" />
                                <? 
                                  } else if (strtolower($ex)=='jpg' || strtolower($ex)=='jpeg' || strtolower($ex)=='gif' || strtolower($ex)=='png') { // IMAGE
                                  ?>
                                  <a href="../assets/docs/<?=$res[0]['file3']?>" target="_blank"><i class="fa fa-file-image-o"></i> Click to open attatched file</a>
                                  <br>
                                  <img src="../assets/docs/<?=$res[0]['file3']?>" width="200px">
                                  <?
                                  }else if (strtolower($ex)=='xls' || strtolower($ex)=='xlsx') {
                                    ?>
                                    <a href="../assets/docs/<?=$res[0]['file3']?>" target="_blank"><i class="fa fa-file-excel-o"></i> Click to open attatched file</a>
                                    <?
                                  }else if (strtolower($ex)=='doc' || strtolower($ex)=='docs') {
                                    ?>
                                    <a href="../assets/docs/<?=$res[0]['file3']?>" target="_blank"><i class="fa fa-file-word-o"></i> Click to open attatched file</a>
                                    <?
                                  }
                                } 
                                ?>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file4">Month 2 Bank Statement</label>
                            <div class="col-sm-9">
                              <?if ($res[0]['file4']!='') { ?>

                                <!-- <a href="../assets/docs/<?=$res[0]['file4']?>" target="_blank">Click to show</a>
                                <br> -->

                                <? 
                                  $ar = explode('.',$res[0]['file4']);
                                  $ex = $ar[count($ar)-1];

                                  if (strtolower($ex)=='pdf') {
                                ?>
                                <a href="../assets/docs/<?=$res[0]['file4']?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Click to open attatched file</a>
                                <br>
                                <embed src="../assets/docs/<?=$res[0]['file4']?>" type="application/pdf" width="200px" height="200px" />

                                <? 
                                  } else if (strtolower($ex)=='jpg' || strtolower($ex)=='jpeg' || strtolower($ex)=='gif' || strtolower($ex)=='png') { // IMAGE
                                  ?>
                                  <a href="../assets/docs/<?=$res[0]['file4']?>" target="_blank"><i class="fa fa-file-image-o"></i> Click to open attatched file</a>
                                  <br>
                                  <img src="../assets/docs/<?=$res[0]['file4']?>" width="200px">
                                  <?
                                  }else if (strtolower($ex)=='xls' || strtolower($ex)=='xlsx') {
                                    ?>
                                    <a href="../assets/docs/<?=$res[0]['file4']?>" target="_blank"><i class="fa fa-file-excel-o"></i> Click to open attatched file</a>
                                    <?
                                  }else if (strtolower($ex)=='doc' || strtolower($ex)=='docs') {
                                    ?>
                                    <a href="../assets/docs/<?=$res[0]['file4']?>" target="_blank"><i class="fa fa-file-word-o"></i> Click to open attatched file</a>
                                    <?
                                  }
                                } 
                                ?>
                            </div>
                          </div>
                      </div>
                      <div class="card-footer">

                        <a href="index.php"><button type="button" class="btn btn-secondary">Cancel</button></a>
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
    <!-- Plugin used-->.
    
  </body>
</html>