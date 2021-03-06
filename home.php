
<?php include('homecontroller.php');
		$logout_success="";
	?>
<html>
<head>
    <title>Neighbourhood Farmers</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fira+Sans+Condensed|Russo+One">
	<link rel="shortcut icon" href="images/logo.ico">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<script type="text/javascript">
		window.addEventListener("beforeunload", function (event) {
		  document.body.style.cursor = 'wait';
		  setTimeout(function(){document.body.style.cursor = 'default';},3000);
		});
	</script>
  </head>

  <body>

		<!--Header -->
		<?php include('nav.php');
		if(empty($_GET)) {?>
			<div class="col scrollmessage">
			<h6>“Every time you buy organic, you’re persuading more farmers to grow organic.” </h6>
			</div>
		<?php } ?>
    <!--Section Start-->
    <section id="main" class="container">
			<?php
			if(array_key_exists('action',$_GET) && empty($_SESSION) &&
							($_GET['action'] == 'myposts' || $_GET['action'] == 'userlist' || $_GET['action'] == 'site'
							|| $_GET['action'] == 'mywishlist' || $_GET['action'] == 'newwish' || $_GET['action'] == 'change')) {
				header('Location: '.$_SERVER['PHP_SELF']);
				exit;
			}
			if(array_key_exists('action',$_GET)) {
			?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="horiadv row"><br /><br />
			<!-- Row for advertisement -->
        </div>
			</div>
		<?php } ?>
        <div class="row">
						<?php
						if(array_key_exists('action',$_GET)) {
							if($_GET['action'] == 'search') {
									include('itemlist.php');
							} else {
								if(!empty($_SESSION)) {
									if(array_key_exists('name', $_SESSION)) {
										include('leftnav.php');
									} else {
											include('images.php');
									}
								} else {
										include('images.php');
								}


								if($_GET['action'] == 'post') {
										include('postitem.php');
								} else if($_GET['action'] == 'myposts') {
										include('myposts.php');
								} else if($_GET['action'] == 'editposts') {
										include('editposts.php');
								} else if($_GET['action'] == 'about') {
										include('aboutus.php');
								} else if($_GET['action'] == 'contact') {
										include('contactus.php');
								} else if($_GET['action'] == 'userlist') {
										include('userlist.php');
								} else if($_GET['action'] == 'site') {
										include('sitemaintenance.php');
								} else if($_GET['action'] == 'mywishlist') {
										include('mywishlist.php');
								} else if($_GET['action'] == 'newwish') {
										include('newwish.php');
								} else if($_GET['action'] == 'change') {
										include('userchangepwd.php');
								} else if($_GET['action'] == 'profile') {
										include('userprofile.php');
								}
								include('contentadv.php');
							}
						} else {
							 	include('searchfarmer.php');
								echo '<style type="text/css">
						        footer {
											position:absolute;
											left:0;
											right:0;
											bottom:0;
						        }
						        </style>';
						}

						?>

        </div>
				<?php
				if(array_key_exists('action',$_GET)) {
				?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="horiadv row"><br /><br />
				<!-- Row for advertisement -->
					</div>
				</div>
				<br />
			<?php } ?>
    </section>
    <!--Section End-->

	<!-- Footer -->
	<?php include('footer.php'); ?>

	<!--Login Form -->
	<?php include('loginform.php'); ?>

	<!--Sign Up Form -->
	<?php include('signup.php'); ?>

	<!--Forgot Password Form -->
	<?php include('forgotpwd.php'); ?>

	<!--Message Div-->
	<?php include('msgdiv.php'); ?>

	<!-- Terms & Policy -->
	<?php include('termsofuse.php'); ?>


  <script src="js/jquery.min.js"></script>
	<script src="js/tether.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.knob.js"></script>

	<!-- jQuery File Upload Dependencies -->
	<script src="js/jquery.ui.widget.js"></script>
	<script src="js/jquery.iframe-transport.js"></script>
	<script src="js/jquery.fileupload.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
 	<?php
		if(!empty($script)) {
			echo $script;
		}
	?>
  </body>
</html>
