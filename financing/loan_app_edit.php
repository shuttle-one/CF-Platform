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
              <div class="col-sm-12">
              <? if (count($res)==1) { ?>
                <!-- <form action="loan_app_update.php" onsubmit="return validateForm(this)" method="post" enctype="multipart/form-data"> -->
                <form id="frm">
                <input type="hidden" name="id" value="<?=$res[0]['id']?>">
                <div class="card">
                      <div class="card-header">
                        <h5>Create Loan Application</h5>
                        <!-- <span>Using the <a href="#">card</a> component, you can extend the default collapse behavior to create an accordion.</span> -->
                      </div>
                      <div class="card-body">
                        

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="title">Invoice Title</label>
                            <div class="col-sm-9">
                              <input class="form-control" name="title" id="title" type="text" placeholder="" value="<?=$res[0]['title']?>">
                            </div>
                          </div>


                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="type">Invoice Type</label>
                            <div class="col-sm-9">
                              <select id="doctype" name="doctype" style="border: 1px" class="form-control">
                                  <option value='0'> - Select Type -</option>
                                  <? foreach($typeRes as $r) { ?>
                                  <option value="<?=$r['doctypeid']?>"<?if($r['doctypeid']==$res[0]['doc_type']) echo ' selected'; ?>><?=$r['doctitle']?></option>
                                  <? } ?>
                              </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="type">Pay Period</label>
                            <div class="col-sm-9">
                              <select id="payperiod" name="payperiod" style="border: 1px" class="form-control">
                                <option value="7" <?if ($res[0]['payperiod']==7) echo ' selected';?>>1 Week</option>
                                <option value="14" <?if ($res[0]['payperiod']==14) echo ' selected';?>>2 Weeks</option>
                                <option value="30" <?if ($res[0]['payperiod']==30) echo ' selected';?>>1 Month</option>

                              </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="type">Due Month</label>
                            <div class="col-sm-9">
                              <select id="duemonth" name="duemonth" style="border: 1px" class="form-control">
                                <? for ($i=1;$i<=12;$i++) { ?>
                                <option value="<?=$i?>"<?if ($res[0]['duemonth']==$i) echo ' selected';?>><?=$i?> Month</option>
                                <? } ?>
                              </select>
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
                                <input class="form-control" name="filename1" id="file1" type="file" onchange="ValidateSize(this)">
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
                                <input class="form-control" name="filename2" id="file2" type="file" onchange="ValidateSize(this)">
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
                                <input class="form-control" name="filename3" id="file3" type="file" onchange="ValidateSize(this)">
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
                                <input class="form-control" name="filename4" id="file4" type="file" onchange="ValidateSize(this)">
                            </div>
                          </div>


                      </div>
                      <div class="card-footer">

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="index.php"><button type="button" class="btn btn-secondary">Cancel</button></a>

                        <button type="button" class="btn btn-danger" id="btn_del_doc">Remove</button>
                      </div>
                    </div>
                    </form>
                  <? } else { echo "Not found this loan application."; }?>
              </div> 
            </div>
          </div>
          
        </div>
        <div class="modal"><!-- Place at bottom of page --></div>
        <!-- footer start-->
        <? include '../include/footer.php'; ?>
      </div>
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <!-- Plugin used-->.
    <script>
    $("#upload1").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $("#filename1").html(fileName);
    });

    $("#upload2").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $("#filename2").html(fileName);
    });

    $("#upload3").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $("#filename3").html(fileName);
    });

    $("#upload4").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $("#filename4").html(fileName);
    });

    $("#btn_del_doc").on("click", function() {
        
        if (confirm("Do you realy want to delete?"))
        {
            $.ajax({
                url: "loan_app_del.php",
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

    function ValidateSize(file) {
        var FileSize = file.files[0].size / 1024 / 1024; // in MB
        if (FileSize > 5) {
            alert('Please choose file less then 5 MB.');
           $(file).val(''); //for clearing with Jquery
        } else {

        }
    }

    $( '#frm' )
      .submit( function( e ) {

        var t = $("#title").val();
        var doctype = $("#doctype").val();

        if (t=='' || doctype=='0'){
          alert("Invoice title and Documents type must have value");
        }else {

          $body = $("body");
          $body.addClass("loading");

          $.ajax( {
            url: 'loan_app_update.php',
            type: 'POST',
            data: new FormData( this ),
            processData: false,
            contentType: false,
            success: function(data){
              console.log(data);
              $body.removeClass("loading");
              if (data==1) {
                alert("Update success");
                window.location.href='index.php';
              }else {
                alert(data);
              }
            },
            error : function(data) {
              alert( "Have error occured, Please try again");
              
              $body.removeClass("loading");
            }

          } );
        } // End If 

          e.preventDefault();
      } );


    function validateForm(frm) {
        var t = frm['title'].value;
        var doctype = frm['doctype'].value;
        if (t=='' || doctype=='0'){
            alert("Invoice title and Documents type must have value");
            return false;
        }else 
            return true;
    }

    </script>
  </body>
</html>