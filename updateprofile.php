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
$updateprofile=$userid=$username="";
if(!empty($_SESSION)) {
  if(array_key_exists('id', $_SESSION)) {
    $userid=$_SESSION['id'];
  }
  if(array_key_exists('name', $_SESSION)) {
    $username=$_SESSION['name'];
  }
}
echo '<script>console.log('.$userid.')</script>';
if($link = OpenCon()) {
  $query ="SELECT * FROM users WHERE id = '". $userid ."'";
  $results1 = runQuery($link, $query);

  $query ="SELECT * FROM states WHERE countryid = '101'";
  $results2 = runQuery($link, $query);

    if(!empty($_POST)) {
      $phone=$_POST['phone'];
      $phonevalid = $_POST['phonevalid'];
      $address1=$_POST['address1'];
      $address2=$_POST['address2'];
      $state=$_POST['state'];
      $district=$_POST['district'];
      $town=$_POST['town'];
      $nhood=$_POST['nhood'];
      $zipcode=$_POST['zipcode'];

      if($_POST['phone']==="") {
        $updateprofile .= '<div class="alert-danger">Please enter the phone number and get it verfied. </div>';
      } else {
        if($_POST['phonevalid']!=1){
                  $updateprofile .= '<div class="alert-danger">Phone number needs to be verfied. </div>';
        }
      }
      if($_POST['state']==="") {
        $updateprofile .= '<div class="alert-danger">Please select the state. </div>';
      }
      if($_POST['district']==="") {
        $updateprofile .= '<div class="alert-danger">Please select the district. </div>';
      }
      if($_POST['town']==="") {
        $updateprofile .= '<div class="alert-danger">Please enter the town. </div>';
      }
      if($_POST['zipcode']==="") {
        $updateprofile .= '<div class="alert-danger">Please enter the zipcode. </div>';
      }

      if($_POST['phone']!="" && $_POST['phonevalid']!= 0 && $_POST['state']!="" && $_POST['district']!=="" && $_POST['town']!=="" && $_POST['nhood']!=="" && $_POST['zipcode']!==""){
          $query = "UPDATE `users` SET `contactno`= '"
					.mysqli_real_escape_string($link, $phone) ."', `phonevalid`=1, `address1` = '"
					.mysqli_real_escape_string($link, $address1) ."', `address2` = '"
          .mysqli_real_escape_string($link, $address2) ."', `stateid` = "
          .mysqli_real_escape_string($link, intval($state)) .", `districtid` = "
          .mysqli_real_escape_string($link, intval($district)) .", `town` = '"
          .mysqli_real_escape_string($link, $town) ."', `nhood` = '"
          .mysqli_real_escape_string($link, $nhood) ."', `zipcode` = '"
          .mysqli_real_escape_string($link, $zipcode) ."'"
					." where `id` = " .mysqli_real_escape_string($link,$userid)." LIMIT 1";
					if(mysqli_query($link, $query)) {
						$updateprofile="<div class='alert alert-success'>
								<p>
									Your profile with NeighbourhoodFarmers.com has been changed successfully.
								</p>
								</div>";
        } else {
            $updateprofile="<div class='alert alert-danger'>
                <p>
                  Failed to update. Please try again later.
                </p>
                </div>";
        }
			}
    }
  	CloseCon($link);
}
 ?>
