<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/commitee_authen.php';?>
<? require_once ('../api/function.php'); ?>
<?
include '../include/database.php';
$db = new Database();  
$db->connect();

$userid = $_SESSION['userid'];
$dr = $_REQUEST['dr'];
$config = include ('../api/config.php');

$currdr = getDateRange($dr);

if ($_SESSION['role'] == 'audit') {
    $sql = "select * from loan_documents_v2 where status<>0 and audit_approve=0";
    if ($config['TEST']==1)
      $sql .= " and test=1 ";
    else $sql .= " and test=0 ";
    $db->sql($sql);
    $res = $db->getResult();
} else if ($_SESSION['role'] == 'legal') {
    $sql = "select * from loan_documents_v2 where status<>0 and legal_approve=0";
    if ($config['TEST']==1)
      $sql .= " and test=1 ";
    else $sql .= " and test=0 ";
    $db->sql($sql);
    $res = $db->getResult();
} else {
    $text = " [No permission.]";
}

$sql = "select * from loan_commitee where id=".$userid;
$db->sql($sql);
$comRes = $db->getResult();
$kyc_status = $comRes[0]['kyc_status'];


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
        <? include '../include/commitee_left_bar.php'; ?>
        <!-- Page Sidebar Ends-->
        <!-- Right sidebar Start-->
        <? include '../include/right_bar.php'; ?>
        <!-- Right sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">

            <? include '../include/header_space.php';?>

              <div class="row">
                <div class="col">
                  <div class="card">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-md-4">
                        <h5>Wait for approve</h5>

                      </div>

                      <div class="col-md-6">
                        <form action="" method="get">
                          <div class="row">

                            <div class="input-group col-md-7">
                              <input class="datepicker-here form-control digits" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" value="<?=trim($currdr[0])?> - <?=trim($currdr[1])?>" name="dr">
                            </div>

                            <div class="input-group col-md-2">
                              <button type="submit" class="btn btn-secondary ">Search</button>
                            </div>
                          </div>
                        </form>
                      </div>

                    </div>
                  </div>

                  <? if ($kyc_status==2) { ?> 
                  <div class="table-responsive">
                    <table class="table table-border-horizontal">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Date Create</th>
                          <th scope="col">Credit Score</th>
                          <!-- <th scope="col">Apr</th> -->
                          <th scope="col">Debt</th>
                          <!-- <th scope="col">Status</th> -->
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>

                      <? 
                      $count = 0;
                      foreach($res as $r) { 
                        $count ++;

                        $score = $r['score'];
                        if ($score == -1)
                          $score = "Pending";

                        $max_borrow = $r['max_borrow'];
                        if ($max_borrow == -1)
                          $max_borrow = "Pending";

                        ?>
                        <tr>
                          <th scope="row"><?=$count?></th>
                          <td><?=$r['title']?></td>
                          <td><?=$r['createdate']?></td>
                          <td><?=$score?></td>
                          <td><?=$max_borrow?></td>
                          <!-- <td><button class='btn btn-success btn-xs'>Success</button></td> -->
                          <td><a class="btn btn-primary btn-sm" href="wait_loan_detail.php?id=<?=$r['id']?>" data-original-title="" title=""> <span class="fa fa-info-circle"></span> Detail</a></td>
                        </tr>
                      <? } ?>
                       
                        
                      </tbody>
                    </table>
                  </div>
                  <? } else {?>
                    <div class="row card-body">
                      <div class="col-md-12">
                        You should have approved from admin.
                      </div>
                    </div>
                  <? } ?>
                </div>
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
  </body>
</html>