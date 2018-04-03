<?php

	session_start();
  $hosturl = "localhost/nfnew";
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
	if(!empty($_SESSION)) {
		$name=$_SESSION['name'];
		$email=$_SESSION['forgotemail'];
		$sent=$mail_sent="";
		// Set content-type header for sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		$headers .= "From: anjana.rajeevv@gmail.com" . "\\r\
		" . "Reply-to: rajeevvasudevan@outlook.com";

		$message = "<div class='container' style='background:whitesmoke'><br>Hello <strong>{$name}</strong>,<br><br> To reset your NeighbourhoodFarmers.com password,
				please click on the below link or copy and paste the address onto your web browser\'s address window.
				Once you\'re on the web page, you will be asked to enter and confirm your password.<br><br>".
				"<a href='http://".$hosturl."/changepwd.php?".urlencode(base64_encode("key=".$name."&email=".$email))
			."'>http://".$hosturl."/changepwd.php?".urlencode(base64_encode("key=".$name."&email=".$email))
			."</a><br><br>Thanks & Regards,<br>support@NeighbourhoodFarmers.com </div>";

		$subject = "How to change Your NeighbourhoodFarmers.com Account";

		$to = $email; // you should run that through a cleaning function or clean it some how

		$sent=mail($to,$subject,$message,$headers);
		if(!$sent) {
			$mail_sent='<div class="alert alert-danger">
					<p>Some problem occured. Please try again later!</p>
					</div>';
		} else {
			$mail_sent="<div class='alert alert-success'>
					<p>Hi <strong> {$name} </strong>,<br>
					An email has been send to <strong> {$email} </strong>.
					Please click on the link provided in the email to reset your NeighbourhoodFarmers.com account password.
					</p>
					</div>";
		}
	} else {
			$mail_sent='<div class="alert alert-danger">
					<p>Some problem occured. Please try again later!</p>
					</div>';
	}
	session_unset();
	session_destroy();
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
			<div class="message centered" style="height:70%">
				<?php echo $mail_sent;?>
			</div>
		</section>
		<br /><br /><br />
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
