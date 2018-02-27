<div class="leftNav col-lg-3 col-md-3 col-sm-3 col-sm-pull-6">
	<br /><br /><br /><br />
	<ul class="menu list-unstyled">
		<li class="sidebar-nav"> <a href="#"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> My Posts</a></li>
		<li class="sidebar-nav"> <a href="#"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> My Wishlist</a></li>
		<li class="sidebar-nav"> <a href="#"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Change Password</a></li>
		<?php
		if(!empty($_SESSION)) {
			if(array_key_exists('role', $_SESSION) && $_SESSION['role']==='Admin') {
		?>
		<hr>
		<li class="sidebar-nav"> <a href="#"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> User Maintenance</a></li>
		<li class="sidebar-nav"> <a href="#"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Site Maintenance</a></li>
		<?php
		} } ?>
	</ul>
</div>
