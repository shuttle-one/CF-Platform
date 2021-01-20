<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? 
$userimage = $_SESSION['userimage'];
if ($userimage=='') {
  $userimage = "../assets/imgs/avatar/avatar.png";
}
?>
<div class="page-main-header">
  <div class="main-header-right row">
    <div class="main-header-left d-lg-none">
      <div class="logo-wrapper"><a href="index.html"><img src="../assets/images/endless-logo.png" alt=""></a></div>
    </div>
    <div class="mobile-sidebar d-block">
      <div class="media-body text-right switch-sm">
        <label class="switch"><a href="#"><i id="sidebar-toggle" data-feather="align-left"></i></a></label>
      </div>
    </div>
    <div class="nav-right col p-0">
      <ul class="nav-menus">

        <li>

        </li>

        <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>

      </ul>
      <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
    </div>
    
  </div>
</div>