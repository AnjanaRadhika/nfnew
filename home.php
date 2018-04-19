
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
	<link rel="stylesheet" href="css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>

  <body>

		<!--Header -->
		<?php include('nav.php'); ?>

    <!--Section Start-->
    <section class="container"><br />
			<?php
			if(array_key_exists('action',$_GET)) {
			?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="horiadv row"><br /><br />
			<!-- Row for advertisement -->
        </div>
			</div>
			<?php } ?>
        <div class="row">

						<?php //include('leftnav.php'); ?>
						<?php
						if(array_key_exists('action',$_GET)) {
							if($_GET['action'] == 'search') {
									include('itemlist.php');
							} else if($_GET['action'] == 'terms') {
									include('termsofuse.php');
							} else if($_GET['action'] == 'myposts') {
									include('myposts.php');
							} else if(strpos($_GET['action'], 'detail') !== false) {
									include('itemdetail.php');
									include('contentadv.php');
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
								}
								include('contentadv.php');
							}
						} else {
							 	include('searchfarmer.php');
						}

						?>

						<?php //include('searchfarmer.php'); ?>

						<?php //include('contentadv.php'); ?>

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


  <script src="js/jquery.min.js"></script>
	<script src="js/tether.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.knob.js"></script>

	<!-- jQuery File Upload Dependencies -->
	<script src="js/jquery.ui.widget.js"></script>
	<script src="js/jquery.iframe-transport.js"></script>
	<script src="js/jquery.fileupload.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript">

	</script>
 	<?php
		if(!empty($script)) {
			echo $script;
			session_unset();
			session_destroy();
			exit();
		}
	?>

  </body>

</html>
