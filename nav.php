<!-- Top Navigation -->
<nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
	<div id="opendiv" style="color:white;font-size:23px;cursor:pointer"><span onclick="openNav()">&#9776;</span>
				<a href="home.php" class="navbar-left"><img style="width:35px;height:35px;" src="images/logo.ico"></a>
				<span id="head" rel="home" >
					<a href="home.php" class="navbar-brand" rel="home">NeighbourhoodFarmer's</a>
				</span>
				<a title="Home" href="home.php"><i class="fa fa-home" style="color:lightblue;"></i></a>
				<?php			if(!empty($_SESSION)) {
										if(array_key_exists('name', $_SESSION)) {?>
				<a title="Sign Out" href="home.php?logout=1"><i class="fa fa-sign-out" style="color:lightblue;"></i></a>
			<?php }}?>
	</div>
	<!-- sideNav -->
	<div class="container-fluid sidenav" id="canNav">
		<a style="color:white;font-size:30px;cursor:pointer" onclick="closeNav()">
			<img src="images/logo.ico" style="width:35px;height:35px;">
			<span style="font-family: 'Fira Sans Condensed', sans-serif!important;
				font-weight:bold;
				font-stretch:ultra-expanded;font-size:14px;">NeighbourhoodFarmer's</span>&nbsp;&times;
		</a>
		<?php
		if(!empty($_GET)) {
			if(array_key_exists('logout',$_GET)) {
					if($_GET['logout'] == 1) {
						session_unset();
						session_destroy();
						header("location:home.php");
						exit();
					}
				} else if(array_key_exists('key', $_GET)) {
						parse_str($_SERVER['QUERY_STRING'],$string);
						$name=urldecode(base64_decode($string['key']));
						?>
						<a class='active' style="color:lightblue; font-weight: bold; text-align:center;"><i class='fa fa-user-circle'></i> <?php echo $name;?> </a><br />
						<?php
				}
			}

			if(!empty($_SESSION)) {
					if(array_key_exists('name', $_SESSION)) {
						$name=$_SESSION['name'];
						?>
						<a class='active' style="color:lightblue; font-weight: bold; text-align:center;"><i class='fa fa-user-circle'></i> <?php echo $name;?> </a><br />
						<?php
					} }?>

		<a href="javascript:void(0);" style="color:rgb(255, 255, 255, 255);font-weight:bold;text-align:center;">
			Toll Free -
			<i class="fa fa-volume-control-phone" style="font-size:10px;"></i>
			<i class="fa fa-volume-control-phone"></i> &nbsp;999 999 9999
		</a> <br />		<br />

				<?php
					$aftername="<a class='nav-link' href='home.php?action=post'>  Submit an Ad<i class='pull-right fa fa-bullhorn' aria-hidden='true'></i></a>"
					."<a class='nav-link' href='home.php?action=myposts'> My Posts <i class='pull-right fa fa-file-audio-o' aria-hidden='true'></i></a>"
					."<a class='nav-link' href='home.php?action=mywishlist'> My Favorites <i class='pull-right fa fa-list' aria-hidden='true'></i></a>"
					."<a class='nav-link' href='home.php?action=change'> Change Password <i class='pull-right fa fa-cog' aria-hidden='true'></i></a>"
					."<a class='nav-link' href='home.php?action=profile'> Update Profile <i class='pull-right fa fa-user' aria-hidden='true'></i></a>";
					if(!empty($_SESSION)) {
						if(array_key_exists('role', $_SESSION) && $_SESSION['role']==='Admin') {
							$aftername=$aftername
												."<a class='nav-link' href='home.php?action=editposts'> Edit Posts by Users<i class='pull-right fa fa-object-group' aria-hidden='true'></i></a>"
												."<a class='nav-link' href='home.php?action=userlist'> User Maintenance <i class='pull-right fa fa-users' aria-hidden='true'></i></a>"
												."<a class='nav-link' href='home.php?action=site'> Site Maintenance <i class='pull-right fa fa-cogs' aria-hidden='true'></i></a>";
							}
					}

					$signin="<a class='nav-link' id='signin-text' data-toggle='modal' data-target='#signindiv'>"
							."<i class='fa fa-user-circle' aria-hidden='true'></i> My Account</a>"
							."<a class='nav-link' href='home.php?action=post'>  Submit an Ad<i class='pull-right fa fa-bullhorn' aria-hidden='true'></i></a>";

					if(!empty($_SESSION))		{
							if(array_key_exists('name', $_SESSION)) {
								echo $aftername;
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
						<a class="nav-link" href="home.php?action=about">  About Us<i class="pull-right fa fa-users" aria-hidden="true"></i></a>
						<a class="nav-link" href="home.php?action=contact"> Contact Us<i class="pull-right fa fa-comments-o" aria-hidden="true"></i></a>

		</div><!-- /.navbar-collapse -->

		<!--top Nav -->
	<div class="container-fluid" id="topNav">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<a href="home.php" class="navbar-left">
				<img id="logo" src="images/logo.ico">
			</a>
			<span id="head" rel="home" >
				<a href="home.php" class="navbar-brand" rel="home"> NeighbourhoodFarmer's </a>
			</span>
			<button class="navbar-toggler pull-right" type="button" data-toggle="collapse" data-target="#nav-content" aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="nav-content">
			<ul class="navbar-nav toplinks">
				<li class="nav-item"><a class="nav-link" href="home.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
				<li class="nav-item"><a class="nav-link" href="home.php?action=about"><i class="fa fa-users" aria-hidden="true"></i>  About Us</a></li>
				<li class="nav-item"><a class="nav-link" href="home.php?action=contact"><i class="fa fa-comments-o" aria-hidden="true"></i>  Contact Us</a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
		<div style="color:rgb(255, 255, 255, 255);font-weight:bold;margin-right: 20px;">
			<i class="fa fa-volume-control-phone" style="font-size:10px;"></i>
			<i class="fa fa-volume-control-phone"></i> &nbsp;999 999 9999
		</div>
		<ul class="navbar-nav">
			<li class="nav-item"><a class="nav-link btn btn-success" href="home.php?action=post" style="color:rgb(255, 255, 255, 150);">&nbsp;<i class="fa fa-bullhorn" aria-hidden="true"></i>  Submit an Ad&nbsp;</a></li>
			<li class="nav-item">
				<?php
					$string=$name="";
					$signin="<a class='nav-link active' id='signin-text' data-toggle='modal' data-target='#signindiv'>"
							."<i class='fa fa-user-circle' aria-hidden='true'></i> My Account</a>";
					$beforename="<a class='nav-link active'><i class='fa fa-user-circle'></i> ";
					$aftername="</a></li>"
					."<li class='nav-item dropdown'><a class='dropdown-toggle' data-toggle='dropdown' href='#' aria-expanded='false'><i class='fa fa-caret-down' style='font-size:20px;color:white;position:relative;top:10px;'></i></a>"
					."<ul class='dropdown-menu'>"
					."<li class='nav-item'> <a href='home.php?action=myposts'> My Posts <i class='pull-right fa fa-file-audio-o' aria-hidden='true'></i></a></li>"
					."<hr/>"
					."<li class='nav-item'> <a href='home.php?action=mywishlist'> My Favorites <i class='pull-right fa fa-list' aria-hidden='true'></i></a></li>"
					."<hr/>"
					."<li class='nav-item'> <a href='home.php?action=change'> Change Password <i class='pull-right fa fa-cog' aria-hidden='true'></i></a></li>"
					."<hr/>"
					."<li class='nav-item'> <a href='home.php?action=profile'> Update Profile <i class='pull-right fa fa-user' aria-hidden='true'></i></a></li>";
					if(!empty($_SESSION)) {
						if(array_key_exists('role', $_SESSION) && $_SESSION['role']==='Admin') {
							$aftername=$aftername
												."<hr/>"
												."<li class='nav-item'> <a href='home.php?action=editposts'> Edit Posts by Users<i class='pull-right fa fa-object-group' aria-hidden='true'></i></a></li>"
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
							}
						}

						if(!empty($_SESSION)) {
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
