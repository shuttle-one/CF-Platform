<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?
$e = $_REQUEST['e'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="endless admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, endless admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="../assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    <title>Calista Finance - Powered by ShuttleOne</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="../assets/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="../assets/css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="../assets/css/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link id="color" rel="stylesheet" href="../assets/css/light-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/responsive.css">
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
                url('../assets/imgs/FhHRx.gif') 
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
  </head>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="loader bg-white">
        <div class="whirly-loader"> </div>
      </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
      <div class="container-fluid p-0">
        <!-- login page start-->
        <div class="authentication-main">
          <div class="row">
            <div class="col-md-12">
              <div class="auth-innerright">
                <div class="authentication-box">
                  <div class="text-center"><img src="../assets/images/endless-logo.png" alt=""></div>
                  <div class="card mt-4">
                    <div class="card-body">
                      <div class="text-center">
                        <h4>LOGIN</h4>
                        <h6>Enter your Username and Password </h6>
                      </div>
                      <form class="theme-form" action="login_submit.php" method="post" id="login_frm">
                        <div class="form-group">
                          <label class="col-form-label pt-0">Email</label>
                          <input class="form-control" type="email" id="email" name="email" required="" value="">
                        </div>
                        <div class="form-group">
                          <label class="col-form-label">Password</label>
                          <input class="form-control" type="password" id="pass" name="pass" required="" value="">
                        </div>
                        <div class="form-group">
                          <label class="col-form-label">Role</label>
                          <select name="role" style="border: 1px" class="form-control">
                            <option value="user">USER</option>
                            <option value="audit">AUDIT</option>
                            <option value="legal">LEGAL</option>
                            <option value="admin">ADMIN</option>
                          </select>
                        </div>
                        <div class="form-group form-row mt-3 mb-0">
                          <button type="button" class="btn btn-primary btn-block" id="btn_login">Login</button>
                        </div>

                        <div class="form-group form-row mt-3 mb-0">
                           <a href="forgot_password.php">Forgot Password?</a>
                        </div>


                        <!-- <div class="form-group form-row mt-3 mb-0">
                          <button class="btn btn-secondary btn-block" type="submit">Login With Auth0</button>
                        </div>
                        <div class="login-divider"></div>
                        <div class="social mt-3">
                          <div class="form-group btn-showcase d-flex">
                            <button class="btn social-btn btn-fb d-inline-block"> <i class="fa fa-facebook"></i></button>
                            <button class="btn social-btn btn-twitter d-inline-block"><i class="fa fa-google"></i></button>
                            <button class="btn social-btn btn-google d-inline-block"><i class="fa fa-twitter"></i></button>
                            <button class="btn social-btn btn-github d-inline-block"><i class="fa fa-github"></i></button>
                          </div>
                        </div> -->
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- login page end-->

        <div class="modal"><!-- Place at bottom of page --></div>

      </div>
    </div>
    <!-- latest jquery-->
    <script src="../assets/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="../assets/js/bootstrap/popper.min.js"></script>
    <script src="../assets/js/bootstrap/bootstrap.js"></script>
    <!-- feather icon js-->
    <script src="../assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="../assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <script src="../assets/js/sidebar-menu.js"></script>
    <script src="../assets/js/config.js"></script>
    <!-- Plugins JS start-->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="../assets/js/script.js"></script>

    <script type="text/javascript">
      <?if ($e == 1) { ?>
        alert('Please check username / password');
        window.location.href = "login.php";
      <? } else if ($e==3) { ?>
        alert('Cannot connect server.');
        window.location.href = "login.php";
      <? }  ?>

      var myinter;
      var key = '<?=uniqid()?>';
      var count = 0;
      var limit = 10;

      $("#btn_login").on("click", function() {

        //------ NOT USE APP --
        $("#login_frm").submit();
        return;
        //------ NOT USE APP --


        $body = $("body");
        $body.addClass("loading");


        $.ajax({
          url: "login_web.php",
          type: 'POST',
          data: {
            'email' : $("#email").val(),
            'check' : 0,
            'key' : key,
          },
          success: function (data) {
            console.log("From login " + data);
            if (data==1) {
              myinter = setInterval(function(){ waitForAppLogin() }, 1000);
            }
          }
        });

      });

      function waitForAppLogin() {
        count ++;
        if (count > limit) {
          clearInterval(myinter);
          alert("Time out");
          $body.removeClass("loading");
        }
        $.ajax({
          url: "login_web.php",
          type: 'POST',
          data: {
            'email' : $("#email").val(),
            'check' : 1,
            'key' : key,
          },
          success: function (data) {
            if (data==1) {
              clearInterval(myinter);
              $body.removeClass("loading");
              alert("Login From App Success");
              $("#login_frm").submit();
            }
            console.log("wait count " );
          }
        });
      }
    </script>

    <!-- Plugin used-->
  </body>
</html>