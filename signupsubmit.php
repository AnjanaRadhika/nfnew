<?php
	include('db_connection.php');
	session_start();
	if(array_key_exists('last_activity', $_SESSION) && array_key_exists('expire_time', $_SESSION)) {
		if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) { //have we expired?
		    //redirect to logout.php
				//redirect to logout.php
				session_unset();
				session_destroy();
				header("location:home.php");
				exit();
		} else{ //if we haven't expired:
		    $_SESSION['last_activity'] = time(); //this was the moment of last activity.
		}
	}
	if($link = OpenCon()) {
		if(!empty($_SESSION)) {
			$name=$_SESSION['name'];
			$email=$_SESSION['email'];
			$sent=$mail_sent="";
			// Set content-type header for sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			$headers .= "From: support@neighbourhoodfarmers.com" . "\\r\
			" . "Reply-to: support@neighbourhoodfarmers.com";

			$message = "<div class='container' style='background:whitesmoke'><br>Hello <strong>{$name}</strong>,<br><br> Welcome to NeighbourhoodFarmers.com! Thanks so much for joining us!".
				" <p>You can login with: {$email} and your the password you entered.".
				"Before you can use your account you need to activate your neighbourhoodfarmer's account! Please click below link to procced with the activation process.
				</p>
				<a href='http://".$hosturl."/activate.php?".urlencode(base64_encode("key=".$name."&email=".$email))
				."'>http://".$hosturl."/activate.php?".urlencode(base64_encode("key=".$name."&email=".$email))
				."</a><br><br><p>
				If at any point of time, you would like to delete your profile from neighbourhoodfarmer's 'Delete Profile' option is provided in 'Update Profile' page.
				For any issues or concerns, kindly contact administrator at <a href="mailto:admin@neighbourhoodfarmers.com">admin@neighbourhoodfarmers.com</a>
				</p>Thanks & Regards,<br>support@NeighbourhoodFarmers.com </div>";

			$subject = "Your NeighbourhoodFarmers.com Account";

			$to = $email; // you should run that through a cleaning function or clean it some how
			$query = "INSERT INTO `users`(`username`,`email`, `password`, `role`) VALUES('" . mysqli_real_escape_string($link, $_SESSION['name'])."','"
				. mysqli_real_escape_string($link, $_SESSION['email'])."','"
				.mysqli_real_escape_string($link, password_hash($_SESSION['password'],PASSWORD_DEFAULT))."','User')";

			if(mysqli_query($link, $query)) {
				$sent=mail($to,$subject,$message,$headers);
				if($sent) {
					$mail_sent="<div class='alert alert-success'>
							<p>Hi <strong> {$name} </strong>,<br>
							An email has been send to <strong> {$email} </strong>.
							Please click on the link provided in the email to activate your account with NeighbourhoodFarmers.com.
							</p>
							</div>";
				}else {
					$mail_sent='<div class="alert alert-danger">
							<p>Some problem occured. Please try again later!</p>
							</div>';
				}
			} else {
					$mail_sent='<div class="alert alert-danger">
							<p>Some problem occured while signing up. Please try again later!</p>
							</div>';
			}
		} else {
				$mail_sent='<div class="alert alert-danger">
						<p>Some problem occured while signing up. Please try again later!</p>
						</div>';
		}
		session_unset();
		session_destroy();
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>

  <body data-spy="scroll" data-target="#navbar" data-offset="150">
		<nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<a href="home.php" class="navbar-left">
						<img id="logo" src="images/logo.ico">
					</a>
					<span id="head" class="navbar-brand" rel="home" >
						<a href="home.php" class="navbar-brand" rel="home"> NeighbourhoodFarmer's </a>
					</span>
				</div>
			</div>
		</nav>
		<br />
		<section class="container messagebody">
			<div class="message centered">
				<?php echo $mail_sent;?>
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
