<div class="leftNav col-lg-3 col-md-3 col-sm-3">
	<ul class="menu list-unstyled">
		<li class="sidebar-nav"> <a href="home.php?action=myposts"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> My Posts</a></li>
		<?php
		if(!empty($_SESSION)) {
			if(array_key_exists('role', $_SESSION) && $_SESSION['role']==='Admin') {
		?>
		<li class="sidebar-nav"> <a href="home.php?action=editposts"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Edit Posts by Users</a></li>
		<?php
		} } ?>
		<li class="sidebar-nav"> <a href="home.php?action=mywishlist"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> My Favorites</a></li>
		<li class="sidebar-nav"> <a href="home.php?action=change"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Change Password</a></li>
		<li class="sidebar-nav"> <a href="home.php?action=profile"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Update Profile</a></li>
		<?php
		if(!empty($_SESSION)) {
			if(array_key_exists('role', $_SESSION) && $_SESSION['role']==='Admin') {
		?>
		<hr>
		<li class="sidebar-nav"> <a href="home.php?action=userlist"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> User Maintenance</a></li>
		<li class="sidebar-nav"> <a href="home.php?action=site"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Site Maintenance</a></li>
		<?php
		} } ?>
		<li class="sidebar-nav"> <a href="home.php?logout=1"><i class="fa fa-sign-out" aria-hidden="true"></i> LogOut</a></li>
	</ul>
	<div class="veradv1 row"><br />

	</div>
</div>
