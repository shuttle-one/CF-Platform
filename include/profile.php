<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<? 
$userimage = $_SESSION['userimage'];
if ($userimage=='') {
  $userimage = "../assets/imgs/avatar/avatar.png";
}

?>
<div class="sidebar-user text-center">
  <div>
  	
  	<div class="circular--portrait">
	  <img src="<?=$userimage?>" />
	</div>
    <div class="profile-edit"><a href="../user/user-profile.php"><i data-feather="edit"></i></a></div>
  </div>
  <h6 class="mt-3 f-14"><?=$_SESSION['username']?></h6>
  <?=$_SESSION['sectionid']?>
  <!-- <p>general manager.</p> -->
</div>