<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php'; ?>
<? require_once ('../api/function.php'); ?>
<?
$userid = $_SESSION['userid'];
$config = include ('../api/config.php');

$menuid = 3;

$thisdate = date("m/d/Y");
$date1 = date("m/d/Y", strtotime(' -1 month'));
$dr = $_REQUEST['dr'];

if ($dr!='') {

  $date_range = explode("-", $dr);
  $currdr = $date_range;
  if (count($date_range)==2) {
    $date_range[0] = date_format(date_create(trim($date_range[0])),"Y-m-d");
    $date_range[1] = date_format(date_create(trim($date_range[1])),"Y-m-d");
  }

}else {
  $date_range[0] = date_format(date_create(trim($date1)),"Y-m-d");
  $date_range[1] = date_format(date_create(trim($thisdate)),"Y-m-d");

  $currdr[0] = $date1;
  $currdr[1] = $thisdate;
}



include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "select c.*,d.title from loan_contract_deleted c left join loan_documents_v2 d on c.documentid=d.id where c.status=1 and c.userid=$userid and date(c.updatedate)>='$date_range[0]' and date(c.updatedate)<='$date_range[1]'";
if ($config['TEST']==1)
      $sql .= " and c.test=1 ";
    else $sql .= " and c.test=0 ";
$sql .= " order by c.updatedate desc";
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
          <div class="container-fluid">
            <? include '../include/header_space.php';?>

              <div class="row">
                <div class="col">
                  <div class="card">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-md-3">
                        <h5>Deleted Credit Line </h5>
                      </div>

                      <div class="col-md-5">
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
                  <div class="table-responsive">
                    <table class="table table-border-horizontal">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Credit ID.</th>
                          <th scope="col">Loan Title</th>
                          <th scope="col">txHash</th>
                          <th scope="col">Debt</th>
                          <th scope="col">Apr</th>
                          <th scope="col">Loan Date</th>
                          <th scope="col">Status</th>
                          <th scope="col">Deleted Date</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?
                          $i=0;
                          foreach ($res as $r) {  $i++; 
                      ?>

                        <tr>
                          <th scope="row"><?=$i?></th>
                          <td><?=$r['id']?></td>
                          <td><?=$r['title']?></td>
                          <td><a href="https://etherscan.io/tx/<?=$r['txhash']?>" target="_blank"><?=substr($r['txhash'],0,15)?> ...</a></td>
                          <td><?=number_format($r['amount'],2,'.',',')?></td>
                          <td><?=number_format($r['apr'],2,'.',',')?></td>
                          <td><?=$r['updatedate']?></td>
                          <td>
                          <? if ($r['status'] == 1) { // Pending ?>
                            <i class="fa fa-cogs" style="color: orange;"></i>
                          <? } ?>

                          <? if ($r['status'] == 2) { // Approve ?>
                            <i class="fa fa-check" style="color: green;"></i>
                          <? } ?>
                          
                          </td>
                          <td><?=$r['deletedate']?></td>
                        </tr>

                      <? } ?>

                      </tbody>
                    </table>
                  </div>
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