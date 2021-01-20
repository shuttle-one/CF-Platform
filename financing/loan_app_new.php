<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? include '../include/authen.php';?>
<?
$menuid = 2;
require_once ('../include/database.php');
$db = new Database();  
$db->connect();

$menuindex = 1;

$userid = $_SESSION['userid'];

$sql = "select * from loan_doc_type";
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
                <!-- <form action="loan_app_submit.php" onsubmit="return validateForm(this)" method="post" enctype="multipart/form-data" id="frm"> -->
                <form id="frm">
                <div class="card">
                      <div class="card-header">
                        <h5>Create Loan Application</h5>
                        <!-- <span>Using the <a href="#">card</a> component, you can extend the default collapse behavior to create an accordion.</span> -->
                      </div>
                      <div class="card-body">
                        

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="title">Invoice Title</label>
                            <div class="col-sm-9">
                              <input class="form-control" name="title" id="title" type="text" placeholder="">
                            </div>
                          </div>


                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="type">Invoice Type</label>
                            <div class="col-sm-9">
                              <select id="doctype" name="doctype" style="border: 1px" class="form-control">
                                  <option value='0'> - Select Type -</option>
                                  <? foreach($res as $r) { ?>
                                  <option value="<?=$r['doctypeid']?>"><?=$r['doctitle']?></option>
                                  <? } ?>
                              </select>
                            </div>
                          </div>

                          <!-- <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="type">Pay Period</label>
                            <div class="col-sm-9">
                              <select id="payperiod" name="payperiod" style="border: 1px" class="form-control">
                                <option value="7">1 Week</option>
                                <option value="14">2 Weeks</option>
                                <option value="30">1 Month</option>

                              </select>
                            </div>
                          </div> -->

                          <input type="hidden" id="payperiod" name="payperiod" value="30">


                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="type">Due Month</label>
                            <div class="col-sm-9">
                              <select id="duemonth" name="duemonth" style="border: 1px" class="form-control">
                                <? for ($i=1;$i<=2;$i++) { ?>
                                <option value="<?=$i?>"><?=$i?> Month</option>
                                <? } ?>
                              </select>
                            </div>
                          </div>
                          

                          <hr>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file1">Banker's Guarantee</label>
                            <div class="col-sm-9">
                              <input class="form-control" id="file1" name="file1" type="file" onchange="ValidateSize(this)">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file2">Trade Invoice</label>
                            <div class="col-sm-9">
                              <input class="form-control" id="file2" name="file2" type="file" onchange="ValidateSize(this)">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file3">Month 1 Bank Statement</label>
                            <div class="col-sm-9">
                              <input class="form-control" id="file3" name="file3" type="file" onchange="ValidateSize(this)">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file4">Month 2 Bank Statement</label>
                            <div class="col-sm-9">
                              <input class="form-control" id="file4" name="file4" type="file" onchange="ValidateSize(this)">
                            </div>
                          </div>
                      </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="btn_submit">Submit</button>
                        <a href="index.php"><button type="button" class="btn btn-secondary">Cancel</button></a>
                      </div>
                    </div>
                    </form>
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

        var f1 = $("#file1").val();
        var f2 = $("#file2").val();
        var f3 = $("#file3").val();
        var f4 = $("#file4").val();
        var t = $("#title").val();
        var doctype = $("#doctype").val();

        if (f1.length > 128 || f2.length > 128 || f3.length > 128 || f4.length > 128 )
        {
          alert("File name length must less than 128 characters.");
          // return;
        } 

        else if (t=='' || doctype=='0'){
          alert("Invoice title and Documents type must have value");
        }
        else {

          $body = $("body");
          $body.addClass("loading");

          $.ajax( {
            url: 'loan_app_submit.php',
            type: 'POST',
            data: new FormData( this ),
            processData: false,
            contentType: false,
            success: function(data){
              console.log(data);
              $body.removeClass("loading");
              if (data==1) {
                alert("Create success");
                window.location.href='index.php';
              }else {
                alert(data);
              }
            },
            error : function(data) {
              alert( "Have error occured, Please try again" + data);
              console.log(data);
              
              $body.removeClass("loading");
            }

          } );
        } // End If 

          e.preventDefault();
      } );



    function validateForm(frm) {



      return false;

      var t = frm['title'].value;
      var doctype = frm['doctype'].value;
      if (t=='' || doctype=='0'){
          alert("Invoice title and Documents type must have value");
          return false;
      }else 
          return true;

    }

    function checkIfFileLoaded(fileName) {
      $.get(fileName, function(data, textStatus) {
          if (textStatus == "success") {
              // execute a success code
              console.log("file loaded!");
          }
      });
    }

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
          // $('#blah').attr('src', e.target.result);
          console.log(e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }


    </script>
  </body>
</html>