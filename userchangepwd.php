<?php
$pwdchangestatus=$userid ="";
if(!empty($_SESSION)) {
  if(array_key_exists('id', $_SESSION)) {
    $userid=$_SESSION['id'];
  }
}
echo '<script>console.log('.$userid.')</script>';
if($link = OpenCon()) {
  echo '<script>console.log("open connection")</script>';

    if(!empty($_POST)) {
      if(array_key_exists('updatepassword', $_POST) && $_POST['updatepassword']==="Update") {
        if($_POST['newpassword']==="" or $_POST['confirmpassword']==="" ){
          $pwdchangestatus .= '<div class="alert-danger">Please enter the new password and confirm. </div>';
        } else {
            if($_POST['newpassword']!=$_POST['confirmpassword']) {
  							$pwdchangestatus='<div class="alert alert-danger">
  									<p>Passwords do not match. Please try again!</p>
  									</div>';
            } else {
              $query = "UPDATE `users` SET `password`= '"
							.mysqli_real_escape_string($link, password_hash($_POST['newpassword'],PASSWORD_DEFAULT))
							."' where `id` = " .mysqli_real_escape_string($link,$userid)." LIMIT 1";
							if(mysqli_query($link, $query)) {
								$pwdchangestatus="<div class='alert alert-success'>
										<p>
											Your password with NeighbourhoodFarmers.com has been changed successfully.
										</p>
										</div>";
            }
					}
        }
      }
    }
  	CloseCon($link);
}
 ?>
<div class="col-lg-6 col-md-6 col-sm-6">
  <div class="content-box">
    <h3>Change Password</h3><br />
    <div id="successmessage">
        <?php echo $pwdchangestatus ?>
    </div>
    <hr />
    <form class="form" action="home.php?action=change" id="changepwdform" method="post">
      <label for="newpassword">New Password : <span>*</span></label>
      <div class="input-group">
        <input class="form-control" type="password" name="newpassword" id="newpassword" style="width:15%;background:white;border: 1px #ced4da solid;padding:2px;" placeholder="************" required />
      </div>
      <br/>
      <div class="bar center-block" style="width:100%;height:22px;background:whitesmoke;border:solid 0.5px;border-radius:5px;">
        <div class="progressbar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
      </div>

      <label for="confirmpassword">Confirm Password : <span>*</span></label>
      <div class="input-group">
        <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" style="width:15%;background:white;border: 1px #ced4da solid;padding:2px;" placeholder="************" required />
      </div>
      <br/>
      <div id="message" style="text-align:center"></div>
      <input type="submit" class="btn" name="updatepassword" value="Update" />
      <br/><hr/>

    </form>
  </div>
</div>
