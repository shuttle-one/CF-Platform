<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<? require_once ('../api/function.php'); ?>
<?
$datefrom = $_REQUEST['datefrom'];
$dateto = $_REQUEST['dateto'];
$sectionid = $_SESSION['sectionid'];
$userid = $_SESSION['userid'];

$config = include ('../api/config.php');

if ($datefrom =='' || $dateto=='') {
  $dateto = date("yy/M");
  $datefrom = date("yy/M", strtotime(" -6 month"));
    
}

$month = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

function myMonth($aa) {
  $m = array (
      "Jan" => "01",
      "Feb" => "02",
      "Mar" => "03",
      "Apr" => "04",
      "May" => "05",
      "Jun" => "06",
      "Jul" => "07",
      "Aug" => "08",
      "Sep" => "09",
      "Oct" => "10",
      "Nov" => "11",
      "Dec" => "12"
      );


  $arr = explode("/", $aa);
  // return $m[$arr[1]];
  // return "0";
  return $arr[0]. '/'. $m[$arr[1]] . '/01';
}


// $qMonthFrom = date_format(date_create(trim($datefrom."/01")),"Y-m-d");

  $qMonthFrom = date_format(date_create(myMonth(trim($datefrom))),"m");
  $qYearFrom = date_format(date_create(myMonth(trim($datefrom))),"Y");

  $qMonthTo = date_format(date_create(myMonth(trim($dateto))),"m");
  $qYearTo = date_format(date_create(myMonth(trim($dateto))),"Y");



include '../include/database.php';
$db = new Database();  
$db->connect();

$sql = "SELECT sum(max_borrow) as s,  month(createdate) as mo, year(createdate) as yr FROM `loan_documents_v2` where userid=$userid and month(createdate)>='$qMonthFrom' and month(createdate)<='$qMonthTo' and year(createdate)>='$qYearFrom' and year(createdate)<='$qYearTo' ";

if ($config['TEST']==1)
    $sql .= " and test=1 ";
  else $sql .= " and test=0 ";

$sql .= "group by month(createdate), year(createdate)";



$db->sql($sql);
$res1 = $db->getResult();

$sql = "select sum(amount) as s, month(updatedate) as mo, year(updatedate) as yr from loan_contract_v2 where userid=$userid  and month(updatedate)>='$qMonthFrom' and month(updatedate)<='$qMonthTo' and year(updatedate)>='$qYearFrom' and year(updatedate)<='$qYearTo' ";

if ($config['TEST']==1)
    $sql .= " and test=1 ";
  else $sql .= " and test=0 ";
  
$sql .= "group by month(updatedate), year(updatedate)";



$db->sql($sql);
$res2 = $db->getResult();


$wallet = getWallet($sectionid);

if ($wallet['code']=='0') { //---- SUCCESS
  $summary = $wallet['summary'];
  $currency = $wallet['currency'];
  $szoAmount = $wallet['xse'];
}else if ($wallet['code'] == 2) {
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

          <!-- Container-fluid starts-->
          <div class="container-fluid">
          	<div style="padding-bottom: 30px">
            </div>


            <div class="row">

              <div class="col-sm-8">
                <div class="card">
                  <div class="card-header">
                    <div class="row">
                      <div class="col-md-4">
                        <h5>Financing Overview</h5>
                      </div>
                      <div class="col-md-8">
                        <form action="" method="get">
                          <div class="row">

                            <div class="input-group col-md-8">
                              <div class="row">
                                <div class="col-xl-5 col-sm-5">
                                  <input class="datepicker-here form-control digits" type="text" data-language="en" data-min-view="months" data-view="months" data-date-format="yyyy/M" name="datefrom" value="<?=$datefrom?>">
                                </div>
                                <div class="col-xl-2 col-md-2">
                                 -
                                </div>
                                <div class="col-xl-5 col-sm-5">
                                  <input class="datepicker-here form-control digits" type="text" data-language="en" data-min-view="months" data-view="months" data-date-format="yyyy/M" name="dateto" value="<?=$dateto?>">
                                </div>
                              </div>
                            </div>

                            <div class="input-group col-md-2">
                              <button type="submit" class="btn btn-secondary ">Search</button>
                            </div>

                          </div>
                        </form>
                      </div>
                    </div>

                  </div>
                  <div class="card-body charts-box" style="height: 500px">
                    <div id="bar-example" style="height: 500px"></div>
                  </div>
                </div>
              </div>

              <!-- <div class="col-lg-6 col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Stacked Bars Chart</h5>
                  </div>
                  <div class="card-body chart-block">
                    <div class="flot-chart-container">
                      <div class="flot-chart-placeholder" id="stacked-bar-chart"></div>
                    </div>
                  </div>
                </div>
              </div> -->

              <div class="col-sm-4">
                <div class="card">
                  <div class="card-header">
                    <h5>Your Wallet Overview</h5>
                    
                  </div>
                  <div class="card-body">
                    <div class="show-value-top d-flex">
                      <div class="value-left d-inline-block">
                        <div class="square d-inline-block" style="background-color: #429A3C"></div><span>Balance (USD)</span>
                      </div>
                      <div class="value-right d-inline-block">
                        <div class="square d-inline-block" style="background-color: #0068A6"></div><span>Maintain</span>
                      </div>
                    </div>
                    <div id="donut-example"></div>
                    
                  </div>
                </div>
              </div>


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
    <!-- Plugin used-->
    <script>
      var data = [
      <? foreach ($res1 as $r) { 
      $y = $r['yr'];
      $m = $month[$r['mo']];
      $s1 = $r['s'];
      $s2 = 0;
      foreach ($res2 as $r2) {
        if ($r2['yr'] == $y && $r2['mo']==$m) {
          $s2 = $r2['s'];
        }
      }
    ?>

      { y: '<?=$y?> <?=$m?>', a: <?=$s1?>, b: <?=$s2?> },
    <? } ?>
    ];

    Morris.Bar({
    	resize: true,
  element: 'bar-example',
  data: data.length ? data : [ { y: 'No data', a:0, b: 0 },],
 
  xkey: 'y',
  ykeys: ['a', 'b'],
  labels: ['Max', 'Loan'],
  barColors: [ "#1531B2","#B21516",],
  // stacked: true,
});

    Morris.Donut({
    	resize: true,
  element: 'donut-example',
  data: [
    {label: "Balance  (USD)", value: '<?=str_replace(",","",$summary)?>'},
    {label: "Maintain", value: <?=$szoAmount?>},
  ],

  colors: [
   '#429A3C',
   '#0068A6',
   // '#E81922'
   ],
});

    Morris.Line({
    	resize: true,
  element: 'line-example',
  data: [
    { y: '2006', a: 100, b: 90 },
    { y: '2007', a: 75,  b: 65 },
    { y: '2008', a: 50,  b: 40 },
    { y: '2009', a: 75,  b: 65 },
    { y: '2010', a: 50,  b: 40 },
    { y: '2011', a: 75,  b: 65 },
    { y: '2012', a: 100, b: 90 }
  ],
  xkey: 'y',
  ykeys: ['a', 'b'],
  labels: ['Series A', 'Series B']
});


console.log('<?=str_replace(",","",$summary)?>');
    </script>
  </body>
</html>