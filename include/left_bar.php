<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<div class="page-sidebar">
          <div class="main-header-left d-none d-lg-block">
            <div class="logo-wrapper"><a href="../dashboard/"><img src="../assets/images/endless-logo.png" alt=""></a></div>
          </div>
          <div class="sidebar custom-scrollbar">

            <? include '../include/profile.php'; ?>

            <ul class="sidebar-menu">

              <li><a class="sidebar-header" href="../dashboard/"><i data-feather="home"></i><span> Dashboard</span></a></li>

              <!-- <li><a class="sidebar-header" href="../financing/"><i data-feather="dollar-sign"></i><span> Financing</span></a></li> -->

              <!-- <li><a class="sidebar-header" href="../financing/"><i data-feather="folder-plus"></i><span> Loan applications</span></a></li> -->

              <li<? if ($menuid==2)  echo ' class="active"';?>><a class="sidebar-header" href="#"><i data-feather="folder-plus"></i><span> Loan applications</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a href="../financing/"><i class="fa fa-circle"></i>Active Application</a></li>
                  <li><a href="../financing/loan_app_new.php"><i class="fa fa-circle"></i>Create Application</a></li>
                  <li><a href="../financing/loan_app_deleted_list.php"><i class="fa fa-circle"></i>Deleted Application</a></li>
                </ul>
              </li>

              <li<? if ($menuid==3)  echo ' class="active"';?>><a class="sidebar-header" href="../creditline/creditline_list.php"><i data-feather="briefcase"></i><span> Credit Line</span></a></li>

              <!-- <li<? if ($menuid==3)  echo ' class="active"';?>><a class="sidebar-header" href="#"><i data-feather="clipboard"></i><span> Credit Line</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a href="../creditline/creditline_list.php"><i class="fa fa-circle"></i>Active Credit Line</a></li>
                  <li><a href="../creditline/creditline_create.php"><i class="fa fa-circle"></i>Create Credit Line</a></li>
                  <li><a href="../creditline/creditline_deleted_list.php"><i class="fa fa-circle"></i>Deleted Credit Line</a></li>
                </ul>
              </li> -->

              <!-- <li<? if ($menuid==4)  echo ' class="active"';?>><a class="sidebar-header" href="#"><i data-feather="clipboard"></i><span> Wallet</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a href="../wallets/wallets.php"><i class="fa fa-circle"></i>Transactions</a></li>
                  <li><a href="../wallets/wallet_topup.php"><i class="fa fa-circle"></i>Topup Via Bank</a></li>
                  <li><a href="../wallets/wallet_topup_credit.php"><i class="fa fa-circle"></i>Topup Via CreditCard</a></li>
                  <li><a href="../wallets/wallet_withdraw.php"><i class="fa fa-circle"></i>Withdraw</a></li>
                </ul>
              </li>
 -->
 

              <li<? if ($menuid==4)  echo ' class="active"';?>><a class="sidebar-header" href="#"><i data-feather="briefcase"></i><span> Wallet</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <li><a href="../wallets/wallets.php"><i class="fa fa-circle"></i>Balance</a></li>
                  <li><a href="../wallets/wallet_topup.php"><i class="fa fa-circle"></i>Topup Via Bank</a></li>
                  <li><a href="../wallets/wallet_topup_credit.php"><i class="fa fa-circle"></i>Topup Via CreditCard</a></li>
                  
                </ul>
              </li>


              <li<? if ($menuid==5)  echo ' class="active"';?>><a class="sidebar-header" href="#"><i data-feather="clipboard"></i><span> Send/Receive</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                  <!-- <li><a href="../wallets/wallet_topup.php"><i class="fa fa-circle"></i>Topup Via Bank</a></li>
                  <li><a href="../wallets/wallet_topup_credit.php"><i class="fa fa-circle"></i>Topup Via CreditCard</a></li> -->
                  <li><a href="../wallets/wallet_withdraw.php"><i class="fa fa-circle"></i>Remittance</a></li>
                </ul>
              </li>


              <li><a class="sidebar-header" href="../payments/payment_list.php"><i data-feather="credit-card"></i><span> Repay Trade Loan</span></a></li>

              <li><a class="sidebar-header" href="../user/user-profile.php"><i data-feather="users"></i><span> Manage Profile</span></a></li>

              <li><a class="sidebar-header" href="../login/logout.php"><i data-feather="power"></i><span> Sign Out</span></a></li>

              <hr>
              <span style="color: white">Powered by ShuttleOne</span>


            </ul>
          </div>
        </div>