<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?
$timeout = 100 * 1000; // 100 Sec

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


      <!-- Page Body Start-->
      <!-- <div class="page-body-wrapper"> -->

        <!-- Right sidebar Ends-->
        <div class="page-body">


          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12">
                <!-- <form action="loan_app_submit.php" onsubmit="return validateForm(this)" method="post" enctype="multipart/form-data" id="frm"> -->
                <form id="frm">
                <div class="card">
                      <div class="card-header">
                        <h5>Submit Documents</h5>
                        <!-- <span>Using the <a href="#">card</a> component, you can extend the default collapse behavior to create an accordion.</span> -->
                      </div>
                      <div class="card-body">
                        

                          
                          <!-- <div class="form-group row">
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
                          </div> -->
                          <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for="file3">Bank Statement</label>

                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file3">Month 1</label>
                            <div class="col-sm-9">
                              <input class="form-control" id="file3" name="file3" type="file" onchange="ValidateSize(this)">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="file4">Month 2</label>
                            <div class="col-sm-9">
                              <input class="form-control" id="file4" name="file4" type="file" onchange="ValidateSize(this)">
                            </div>
                          </div>
                      </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="btn_submit">Check Credit</button>
                        <button type="button" class="btn btn-secondary" id="btn_close">Close</button>
                        <!-- <button type="button" class="btn btn-secondary" id="btn_check">Check</button> -->
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
      <!-- </div> -->
    </div>
    <!-- latest jquery-->
    <? include '../include/bottom_script.php'; ?>
    <!-- Plugin used-->.
    <script>

    var timeInter;

    function ValidateSize(file) {
        var FileSize = file.files[0].size / 1024 / 1024; // in MB
        if (FileSize > 5) {
            alert('Please choose file less then 5 MB.');
           $(file).val(''); //for clearing with Jquery
        } else {

        }
    }

    $("#btn_close").on("click", function() {
      window.close();
    });

    // $("#btn_check").on("click", function() {
    //   checkScore(10);
    // });

    $( '#frm' )
      .submit( function( e ) {

        // var f1 = $("#file1").val();
        // var f2 = $("#file2").val();
        var f3 = $("#file3").val();
        var f4 = $("#file4").val();

        if (f3=='' && f4==''){
        // if (f1=='' && f2=='' && f3=='' && f4==''){
          alert("Please upload file(s) for calculate.");
        }else {

          $body = $("body");
          $body.addClass("loading");

          $.ajax( {
            url: 'widget_loan_submit.php',
            type: 'POST',
            data: new FormData( this ),
            processData: false,
            contentType: false,
            success: function(data){
              // alert(data);
              console.log(data);
              if (data==0) { // Error
                alert("Server Error, Please try again.");
                $body.removeClass("loading");
              }else {

                timeInter = setInterval( function() { checkScore(data); }  , 1000);
                setTimeout(function(){ alert("Time out"); clearLocalInter() ; }, <?=$timeout?>);

                //------ MOCKUP -----//
                // setTimeout(function(){ checkScore(data) }, 1500);

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


    function checkScore(id) {
      console.log("check score " + id);
      $.ajax({
        url: '../api/widget_scoring.php',
        type: 'GET',
        data: {
            'id' : id,
        },
        success: function (data) {
          console.log(data);
          if (data!=0) {
            var obj = JSON.parse(data);
            window.location.href = "widget_result.php?s=" + obj.score + "&b=" + obj.max_borrow + "&a=" + obj.apr;
            clearLocalInter();
          }else {
            console.log("Check Score Fail");
            console.log(data);
            // clearLocalInter();
          }
        }
      });

    }

    function clearLocalInter() {
      console.log("Clear Interval");
      clearInterval(timeInter);
      $body.removeClass("loading");
    }


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