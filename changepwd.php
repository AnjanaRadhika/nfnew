<?php
	include('db_connection.php');
	session_start();
	$pwdchangestatus =$script=$error=$active="";
	if($link = OpenCon()) {
		if(!empty($_GET) && isset($_POST)) {
			echo $_SERVER['QUERY_STRING'];
			parse_str(urldecode(base64_decode($_SERVER['QUERY_STRING'])),$string);
			$key=$string['key'];
			$email=rtrim($string['email'],'7');
			if(array_key_exists('updatepassword', $_POST) && $_POST['updatepassword']==="Update Password") {
				if($_POST['newpassword']==="" or $_POST['confirmpassword']==="" ){
					$pwdchangestatus .= '<div class="alert-danger">Please enter the new password and confirm. </div>';
				} else {
					if($_POST['newpassword']!=$_POST['confirmpassword']) {
							$pwdchangestatus='<div class="alert alert-danger">
									<p>Passwords do not match. Please try again!</p>
									</div>';
					} else {
						$query = "SELECT `activate` FROM `users` "
								." WHERE `email`='".$email."' and `username`='".$key."'";
						$result = mysqli_query($link, $query);

						if(mysqli_num_rows($result) > 0) {
							$row=mysqli_fetch_array($result);
							$active = $row['activate'];
						} else {
							$pwdchangestatus='<div class="alert alert-danger">
									<p>You have used a different email for signing up. Please try with the registered email.</p>
									</div>';
						}

						if($active) {
							echo("<script>console.log('inside active')</script>");
							$query = "UPDATE `users` SET `password`= '"
							.mysqli_real_escape_string($link, password_hash($_POST['newpassword'],PASSWORD_DEFAULT))
							."' WHERE `email`='".$email."' and `username`='".$key."' LIMIT 1";
							if(mysqli_query($link, $query)) {
								$pwdchangestatus="<div class='alert alert-success'>
										<p>Hi <strong> {$key} </strong>,<br>
											Your password with NeighbourhoodFarmers.com has been changed successfully.
										</p>
										</div>";
							} else {
								$pwdchangestatus='<div class="alert alert-danger">
										<p>Some problem occured while changing the password. Please try again later!</p>
										</div>';
							}
						} else {
							$pwdchangestatus='<div class="alert alert-danger">
									<p>The account is not activated yet. The activation link has been sent to your registered email. </p>
									</div>';
						}
					}
				}
				if(!empty($pwdchangestatus)) {
					$script =  "<script>$('#updatepwddiv').modal('show')</script>"; // Show modal
				}
			}
		} else {
				$error='<div class="alert alert-danger">
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
		<br /><br /><br /><br />
		<?php if(!empty($error)) {
			echo $error;
		} else { ?>

		<section class="container" style="text-align:center">
			<div class="popup">
			<br>
				<form class="form" action="#" id="changepwdform" method="post">
					<h2>Change Password</h2>
					<label for="newpassword">New Password : <span>*</span></label>
					<div class="input-group">
						<input class="form-control" type="password" name="newpassword" id="newpassword" style="width:15%" placeholder="************" required />
					</div>
					<br/>
					<div class="bar center-block" style="width:100%;height:22px;background:whitesmoke;border:solid 0.5px;border-radius:5px;">
						<div class="progressbar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
					</div>

					<label for="confirmpassword">Confirm Password : <span>*</span></label>
					<div class="input-group">
						<input class="form-control" type="password" name="confirmpassword" id="confirmpassword" style="width:15%" placeholder="************" required />
					</div>
					<br/>
					<div id="message" style="text-align:center"></div>
					<input type="submit" class="btn" name="updatepassword" value="Update" />
					<br/><hr/>

				</form>
			</div>
		</section>
		<?php } ?>
		<div id="updatepwddiv" class="modal modal-open fade" tabindex="-1" role="dialog" aria-labelledby="updatepwddiv" aria-hidden="true">
			<div class="modal-dialog popup" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="modal-title">Password Reset</h2>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">X</span>
						</button>
					</div>
					<form id="changepwd" class="centered" action="home.php"><br/><br/>
							<?php if(isset($pwdchangestatus)) echo $pwdchangestatus;?>
						<div align="center">
						<input type="submit" class="btn" value="Home" />
						<input type="button" class="btn cancel" data-dismiss="modal" value="Cancel"/>
						</div>
					</form>
				</div>
			</div>
		</div>

	<br /><br /><br />
		<!-- Footer -->
		<?php include('footer.php'); ?>


		<script src="js/jquery.min.js"></script>
		<script src="js/tether.min.js"></script>
	  <script src="js/bootstrap.min.js"></script>

	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript">
		$('#newpassword, #confirmpassword').on('keyup', function () {
		  if ($('#newpassword').val() == $('#confirmpassword').val()) {
			$('#message').html('Matching').css('color', 'green');
		  } else
			$('#message').html('Not Matching').css('color', 'red');
		});
	</script>
 	<?php
		if(!empty($script)) {
			echo $script;
		}
	?>
  </body>

</html>
