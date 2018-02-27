<?php
  include('db_connection.php');
	session_start();

	$error=$script=$forgotpwderror=$loginerror=$hash="";

	if($link = OpenCon()) {
		if(isset($_POST)) {
			if(array_key_exists('signup-submit', $_POST) && $_POST['signup-submit']=='Sign Up'){
				if(array_key_exists('name', $_POST) OR array_key_exists('password', $_POST) OR array_key_exists('email', $_POST)) {
					if($_POST['name']==""){
						$error .= '<div class="alert-danger">User Name is required.</div>';
						$_SESSION['signupsubmitted'] = false;
					}else if($_POST['email']==""){
						$error .= '<div class="alert-danger">Email is required.</div>';
						$_SESSION['signupsubmitted'] = false;
					} else if($_POST['password']==""){
						$error .= '<div class="alert-danger" >Password is required.</div>';
						$_SESSION['signupsubmitted'] = false;
					} else {
						$query = "SELECT * FROM `users` WHERE `username` = '".mysqli_real_escape_string($link, $_POST['name'])."'";
						$result = mysqli_query($link, $query);
						$query = "SELECT * FROM `users` WHERE `email` = '".mysqli_real_escape_string($link, $_POST['email'])."'";
						$result1 = mysqli_query($link, $query);
						if(mysqli_num_rows($result) > 0) {
							$error .= '<div class="alert-danger" >User Name has already been taken.</div>';
							$_SESSION['signupsubmitted'] = false;
						}
						if(mysqli_num_rows($result1) > 0) {
								$error .= '<div class="alert-danger">Email has already been taken.</div>';
								$_SESSION['signupsubmitted'] = false;
						} else {
							$_SESSION['email'] = $_POST['email'];
							$_SESSION['name'] = $_POST['name'];
							$_SESSION['password'] = $_POST['password'];
							$_SESSION['signupsubmitted'] = true;
						}
					}
				}
			} else if(array_key_exists('forgotpwd-submit', $_POST) && $_POST['forgotpwd-submit']==='Send'){
				if(array_key_exists('forgotemail', $_POST)) {
					if($_POST['forgotemail']==""){
						$forgotpwderror .= '<div class="alert-danger" >Please enter the email address.</div>';
						$_SESSION['forgotpwdsubmitted'] = false;
					}else {
						$query = "SELECT `username`,`activate` FROM `users` WHERE `email` = '".mysqli_real_escape_string($link, $_POST['forgotemail'])."'";
						$result = mysqli_query($link, $query);
						if(mysqli_num_rows($result) > 0) {
							$row=mysqli_fetch_array($result);
							if($row['activate']) {
								$_SESSION['name'] = $row['username'];
								$_SESSION['forgotemail'] = $_POST['forgotemail'];
								$_SESSION['forgotpwdsubmitted'] = true;
							} else {
								$forgotpwderror .= '<div class="alert-danger">You need to get your account activated. Your account activation link has been sent to your registered email address.</div>';
								$_SESSION['forgotpwdsubmitted'] = false;
							}
						} else {
							$forgotpwderror .= '<div class="alert-danger">Please enter a valid email address.</div>';
							$_SESSION['forgotpwdsubmitted'] = false;
						}
					}
				}
			} else if(array_key_exists('login', $_POST) && $_POST['login']=='Login'){
				if(array_key_exists('username', $_POST) OR array_key_exists('password', $_POST)) {
					if($_POST['username']==""){
						$loginerror .= '<div class="alert-danger">Login email is required.</div>';
						$_SESSION['signedin'] = false;
					} else if($_POST['password']==""){
						$loginerror .= '<div class="alert-danger" >Password is required.</div>';
						$_SESSION['signedin'] = false;
					} else {
						$query = "SELECT `id`, `activate`, `password`, `username`, `role` FROM `users` WHERE `email` = '".mysqli_real_escape_string($link, $_POST['username'])
									."'";
						$result = mysqli_query($link, $query);
						if(mysqli_num_rows($result) > 0) {
							$row=mysqli_fetch_array($result);
							if($row['activate']) {
								$hash=$row['password'];
								if(password_verify($_POST['password'], $hash)) {
									$_SESSION['name'] = $row['username'];
									$_SESSION['email'] = $_POST['username'];
                  $_SESSION['id'] = $row['id'];
                  $_SESSION['role'] = $row['role'];
									$_SESSION['signedin'] = true;
								} else {
									$loginerror .= '<div class="alert-danger">Invalid credentials. Please try again.</div>';
									$_SESSION['signedin'] = false;
								}
							} else {
									$loginerror .= '<div class="alert-danger">You need to get your account activated. Your account activation link has been sent to your registered email address.</div>';
									$_SESSION['signedin'] = false;
							}
						} else {
							$loginerror .= '<div class="alert-danger">Please enter a valid email address.</div>';
							$_SESSION['signedin'] = false;
						}
					}
				}
			}
		}

		 if(isset($_SESSION['signupsubmitted'])){
			 if($_SESSION['signupsubmitted'] === true) {
					header("Location:signupsubmit.php");
			 } else {
					$script =  "<script>$('#signupdiv').modal('show')</script>"; // Show modal
			 }
		 } else if(isset($_SESSION['forgotpwdsubmitted'])){
			 if($_SESSION['forgotpwdsubmitted'] === true) {
					header("Location:forgotpwdsubmit.php");
			 } else {
					$script =  "<script>$('#forgotpassworddiv').modal('show')</script>"; // Show modal
			 }
		 } else if(isset($_SESSION['signedin'])) {
			 if($_SESSION['signedin'] === true) {
				 echo("<script>console.log('signed in')</script>");
			 } else {
					$script =  "<script>$('#signindiv').modal('show')</script>"; // Show modal
			 }
		 }
		CloseCon($link);
	}
?>
