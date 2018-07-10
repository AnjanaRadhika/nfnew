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
  $query=$msg="";
if($link = OpenCon()) {
  if(isset($_SESSION['signedin'])) {
    if($_SESSION['signedin'] === true) {
      if($_SESSION['viewpolicy'] === '0') {
        $_SESSION['viewpolicy'] = '1';
        $query="UPDATE `users` SET `viewpolicy` = 1 where `id` = '". mysqli_real_escape_string($link, $_SESSION['id'])."'";
        if(mysqli_query($link, $query)) {
          $msg = "Success";
        } else {
          $msg = "Failure";
        }
      } else {
          $msg= "Failure";
      }
    } else {
      $msg= "Failure";
    }
  } else {
    $msg = "Failure";
  }

  CloseCon($link);
}
echo $msg;
?>
