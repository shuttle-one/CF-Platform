<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<div class="page-sidebar">
  <div class="main-header-left d-none d-lg-block">
    <div class="logo-wrapper"><a href="index.html"><img src="../assets/images/endless-logo.png" alt=""></a></div>
  </div>
  <div class="sidebar custom-scrollbar">

    <? include '../include/profile.php'; ?>

    <ul class="sidebar-menu">

      <!-- <li><a class="sidebar-header" href=""><i data-feather="home"></i><span> Dashboard</span></a></li> -->

      <li><a class="sidebar-header" href="wait_list.php"><i data-feather="mail"></i><span> Loan Application</span></a></li>
      <li><a class="sidebar-header" href="approved_loan_list.php"><i data-feather="check-square"></i><span> Approved Application</span></a></li>

      <li><a class="sidebar-header" href=""><i data-feather="clipboard"></i><span> KYC</span></a></li>

      <!-- <li<? if ($menuid==3)  echo ' class="active"';?>><a class="sidebar-header" href="#"><i data-feather="clipboard"></i><span> Report</span><i class="fa fa-angle-right pull-right"></i></a>
        <ul class="sidebar-submenu">
          <li><a href="finance_list.php"><i class="fa fa-circle"></i>Finance</a></li>
          <li><a href="#"><i class="fa fa-circle"></i>Payment </a></li>
          <li><a href="#"><i class="fa fa-circle"></i>Wallets</a></li>
        </ul>
      </li> -->
      <li><a class="sidebar-header" href="../login/logout.php"><i data-feather="power"></i><span> Sign Out</span></a></li>

      <hr>
      <span style="color: white">Powered by ShuttleOne</span>
      
    </ul>
  </div>
</div>