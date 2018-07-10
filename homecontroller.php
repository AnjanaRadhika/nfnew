<?php
  include('db_connection.php');
	session_start();
  if(array_key_exists('last_activity', $_SESSION) && array_key_exists('expire_time', $_SESSION)) {
		if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) { //have we expired?
		    //redirect to logout.php
        session_unset();
        session_destroy();
        header("location:home.php");
        exit();
		} else{ //if we haven't expired:
		    $_SESSION['last_activity'] = time(); //this was the moment of last activity.
		}
	}
	$error=$script=$forgotpwderror=$loginerror=$hash=$query="";

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
          } else if($_POST['password'] != $_POST['confirmpassword']){
            $error .= '<div class="alert-danger" >Passwords do not match.</div>';
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
							if($row['activate']==1) {
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
						$query = "SELECT `id`, `activate`, `password`, `username`, `role`, `viewpolicy` FROM `users` WHERE `email` = '".mysqli_real_escape_string($link, $_POST['username'])
									."'";
						$result = mysqli_query($link, $query);
						if(mysqli_num_rows($result) > 0) {
							$row=mysqli_fetch_array($result);
							if($row['activate']==1) {
								$hash=$row['password'];
								if(password_verify($_POST['password'], $hash)) {
									$_SESSION['name'] = $row['username'];
									$_SESSION['email'] = $_POST['username'];
                  $_SESSION['id'] = $row['id'];
                  $_SESSION['role'] = $row['role'];
                  $_SESSION['viewpolicy'] = $row['viewpolicy'];
									$_SESSION['signedin'] = true;
                  $_SESSION['last_activity'] = time(); //your last activity was now, having logged in.
                  $_SESSION['expire_time'] = 60*60; //expire time in seconds: 1 hour (you must change this)
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
				 if($_SESSION['viewpolicy'] === '0') {
           $script =  "<script>
            $('#termsofusediv1').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#termsofusediv1').modal('show');
           </script>"; // Show modal
           session_write_close();
         }
			 } else {
					$script =  "<script>$('#signindiv').modal('show')</script>"; // Show modal
			 }
		 }

		CloseCon($link);
	}
?>
