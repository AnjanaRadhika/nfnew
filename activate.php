<?php
	include('db_connection.php');
	session_start();
	$activatemsg="";
	if($link = OpenCon()) {
			if(!empty($_GET)) {
				echo $_SERVER['QUERY_STRING'];
				parse_str(urldecode(base64_decode($_SERVER['QUERY_STRING'])),$string);
				$key=$string['key'];
				$email=rtrim($string['email'],'7');
				$query = "UPDATE `users` SET `activate`= true WHERE `email`='".$email."' and `username`='".$key."' LIMIT 1";
				echo $query;
				if(mysqli_query($link, $query)) {
					$activatemsg="<div class='alert alert-success'>
							<p>Hi <strong> {$key} </strong>,<br>
								Your account with NeighbourhoodFarmers.com has been activated.
								Please click on the below link and login using your credentials to access your account.<br><br>
								<a href='http://".$hosturl."/home.php'>http://{$hosturl}/home.php</a>
							</p>
							</div>";
				} else {
					$activatemsg='<div class="alert alert-danger">
							<p>Some problem occured while activating your account. Please try again later!</p>
							</div>';
				}
			} else {
					$activatemsg='<div class="alert alert-danger">
							<p>Some problem occured while activating your account. Please try again later!</p>
							</div>';
			}
			CloseCon($link);
		}

?>
<!DOCTYPE html>

<html lang="en">

  <head>
    <title>Neighbourhood Farmers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<link href="https://fonts.googleapis.com/css?family=Fira+Sans+Condensed|Russo+One" rel="stylesheet">
	<link rel="shortcut icon" href="images/logo.ico">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>

  <body data-spy="scroll" data-target="#navbar" data-offset="150">
		<!--Header -->
		<nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<a class="navbar-left">
						<img style="max-width:7%;" src="images/logo.ico">
					</a>
					<a id="head" class="navbar-brand" rel="home" href="#">
						NeighbourhoodFarmers.com
					</a>
				</div>
			</div>
		</nav>
		<br /><br /><br />
		<section class="container messagebody">
			<div class="message centered">
				<?php echo $activatemsg;?>
			</div>
		</section>

		<div class="messagefooter">
			<!-- Footer -->
			<?php include('footer.php'); ?>
		</div>

		<script src="js/jquery.min.js"></script>
		<script src="js/tether.min.js"></script>
	  <script src="js/bootstrap.min.js"></script>

		<script type="text/javascript" src="js/script.js"></script>

  </body>

</html>
