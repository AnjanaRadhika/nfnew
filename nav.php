<nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<a class="navbar-left">
				<img id="logo" src="images/logo.ico">
			</a>
			<span id="head" class="navbar-brand" rel="home" >
				NeighbourhoodFarmer's
			</span>
			<button class="navbar-toggler pull-right" type="button" data-toggle="collapse" data-target="#nav-content" aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="nav-content">
			<ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link" href="home.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
				<li class="nav-item"><a class="nav-link" href="home.php?action=about"><i class="fa fa-users" aria-hidden="true"></i>  About Us</a></li>
				<li class="nav-item"><a class="nav-link" href="home.php?action=contact"><i class="fa fa-comments-o" aria-hidden="true"></i>  Contact Us</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
		<ul class="navbar-nav">
			<li class="nav-item"><a class="nav-link" href="home.php?action=post"><i class="fa fa-bullhorn" aria-hidden="true"></i>  Post an Ad</a></li>
			<li class="nav-item">
				<?php
					$string=$name="";
					$signin="<a class='nav-link' id='signin-text' data-toggle='modal' data-target='#signindiv'>"
							."<i class='fa fa-user-circle' aria-hidden='true'></i> Sign up / Sign in</a>";
					$beforename="<a class='nav-link active'><i class='fa fa-user-circle'></i> ";
					$aftername="</a></li>"
					."<li class='nav-item dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-th' style='font-size:24px;color:white;position:relative;top:10px;'></i></a>"
					."<ul class='dropdown-menu'>"
					."<li class='nav-item'> <a href='home.php?action=myposts'> My Posts <i class='pull-right fa fa-file-audio-o' aria-hidden='true'></i></a></li>"
					."<hr/>"
					."<li class='nav-item'> <a href='home.php?action=mywishlist'> My Wishlist <i class='pull-right fa fa-list' aria-hidden='true'></i></a></li>"
					."<hr/>"
					."<li class='nav-item'> <a href='home.php?action=newwish'> New Wish <i class='pull-right fa fa-magic' aria-hidden='true'></i></a></li>"
					."<hr/>"
					."<li class='nav-item'> <a href='home.php?action=change'> Change Password <i class='pull-right fa fa-cog' aria-hidden='true'></i></a></li>";
					if(!empty($_SESSION)) {
						if(array_key_exists('role', $_SESSION) && $_SESSION['role']==='Admin') {
							$aftername=$aftername
												."<hr/>"
												."<li class='nav-item'> <a href='home.php?action=userlist'> User Maintenance <i class='pull-right fa fa-users' aria-hidden='true'></i></a></li>"
												."<hr/>"
												."<li class='nav-item'> <a href='home.php?action=site'> Site Maintenance <i class='pull-right fa fa-cogs' aria-hidden='true'></i></a></li>";
							}
					}
					$aftername=$aftername
										."<hr/>"
										."<li class='nav-item'> <a href='home.php?logout=1'> Sign Out <i class='pull-right fa fa-sign-out' aria-hidden='true'></i> </a></li>"
										."</ul></li>";

					if(!empty($_GET)) {
						if(array_key_exists('logout',$_GET)) {
								if($_GET['logout'] == 1) {
									session_unset();
									session_destroy();
									header("location:home.php");
									$logout_success="<div class='alert alert-success'>
											<p>Session logged out successfully!	</p>
											</div>";
									exit();
								}
							} else if(array_key_exists('key', $_GET)) {
									parse_str($_SERVER['QUERY_STRING'],$string);
									$name=urldecode(base64_decode($string['key']));
									echo $beforename." ".$name.$aftername;
							} else {
									echo $signin;
							}
						} else if(!empty($_SESSION)) {
								if(array_key_exists('name', $_SESSION)) {
									$name=$_SESSION['name'];
									echo $beforename.$name.$aftername;
								} else if(array_key_exists('signedin', $_SESSION) && $_SESSION['signedin'] === false) {
									echo $signin;
								} else if(array_key_exists('signupsubmitted', $_SESSION) && $_SESSION['signupsubmitted'] === false) {
									echo $signin;
								} else {
									echo $signin;
								}
							} else {
								echo $signin;
							}

						?>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
