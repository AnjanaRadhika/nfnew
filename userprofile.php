<?php
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
        }
			}
    }
  	CloseCon($link);
}
 ?>
<div class="col-lg-6 col-md-6 col-sm-6">
  <div class="content-box">
    <h3>Update Profile</h3><br />
    <div id="successmessage">
        <?php echo $updateprofile; ?>
    </div>
    <hr />
    <form name="profileform" class="form" action="home.php?action=profile" id="changeprofile" method="post">
      <?php
      foreach($results1 as $user) {      ?>
        <div class="form-row">
            <div class="form-group col-md-6">
              <label><?php echo $user['username'];?></label>
            </div>
            <div class="form-group col-md-6">
              <label><?php echo $user['email'];?></label>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
               <label>Phone *</label>
               <input id="phonevalid"  name="phonevalid" type="hidden" value="1"/>
               <input type="hidden" id="phone" name="phone" value="<?php echo $user['contactno'];?>" />
               <div class="input-group" onKeyUp="$('#phone').val($('#tel1').val() + $('#tel2').val() + $('#tel3').val())">
                       <input type="tel" id="tel1" class="form-control" value="<?php echo substr($user['contactno'],0,3);?>" size="3" maxlength="3" required="required" >-
                       <input type="tel" id="tel2" class="form-control" value="<?php echo substr($user['contactno'],3,3);?>" size="3" maxlength="3" required="required" >-
                       <input type="tel" id="tel3" class="form-control" value="<?php echo substr($user['contactno'],6,4);?>" size="4" maxlength="4" required="required" >
                       <div class="invalid-feedback">
                         The phone number needs to be verified.
                       </div>
                       <div class="valid-feedback">
                         Number Verified!
                       </div>
                       &nbsp;
                       <span class="input-group-btn">
                         <button id="showdiv" class="btn btn-success" data-toggle="modal" data-target="#verifydiv"><i class="fa fa-phone" aria-hidden="true"></i> Verify Phone</button>
                       </span>
               </div>
            </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="address">Address </label>
          <input type="text" id="address" class="form-control " name="address1" placeholder="Address Line1" value="<?php echo $user['address1'];?>"> <br />
          <input type="text" class="form-control " name="address2" placeholder="Address Line2" value="<?php echo $user['address2'];?>" >
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="state-list">State *</label>
          <input type="hidden" id="state" name="state" value="<?php echo $user['stateid']; ?>" />
          <select form="profileform" id="state-list" class="form-control custom-select" onChange="getDistrict(this.value);" required>
              <option value="">Select State</option>
              <?php
              foreach($results2 as $state) {
                $strselected = $state['stateid'] == $user['stateid']?'selected':'';
              ?>
              <option value="<?php echo $state['stateid']; ?>" <?php echo $strselected;?> ><?php echo $state['statename']; ?></option>
              <?php
              }
              ?>
          </select>
          <div class="invalid-feedback col-md-6">
            Please choose the State.
          </div>
        </div>
        <div class="form-group col-md-6">
          <label for="district-list">District *</label>
          <input type="hidden" id="district" name="district" value="<?php echo $user['districtid']; ?>"  />
          <select form="profileform" id="district-list" class="form-control  custom-select" required>
              <option value="">Select District</option>
            <?php
                if(!empty($user['stateid'])) {
                  if($link = OpenCon()) {
                    	$query ="SELECT * FROM districts WHERE stateid = " . $user['stateid'];
                    	$results = runQuery($link,$query);
                      CloseCon($link);
                    }

                  foreach($results as $district) {
                      $strselected = $district['districtid'] == $user['districtid']?'selected':'';    ?>
  	                   <option value="<?php echo $district['districtid']; ?>" <?php echo $strselected;?> ><?php echo $district['districtname']; ?></option>
            <?php } } ?>
            <div>
              <?php echo $district['districtname'];?>
            </div>
          </select>
          <div class="invalid-feedback col-md-6">
            Please enter the district.
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="town">Town / Village * </label>
          <input type="text" class="form-control ui-autocomplete-input" name="town" id="town" placeholder="Town / Village" value="<?php echo $user['town'];?>" required>
          <div class="invalid-feedback col-md-6">
            Please enter the Town / Village.
          </div>
        </div>
        <div class="form-group col-md-6">
          <label for="nhood">Neighbourhood </label>
          <input type="text" class="form-control ui-autocomplete-input" name="nhood" id="nhood" placeholder="Neighbourhood" value="<?php echo $user['nhood'];?>">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="zipcode">Zipcode *</label>
          <input type="Number" class="form-control ui-autocomplete-input" name="zipcode" id="zipcode" placeholder="Zipcode" value="<?php echo $user['zipcode'];?>" required>
          <div class="invalid-feedback col-md-6">
            Please enter the zipcode.
          </div>
        </div>
      </div>
    <?php } ?>
      <div id="message" style="text-align:center"></div>
      <button class="btn btn-success button-submit form-element" type="submit">Update</button>
      <br/><hr/>

    </form>
  </div>
  <!-- Verify Phone Number -->
  <div id="verifydiv" class="modal modal-open fade" tabindex="-1" role="dialog" aria-labelledby="msgdiv" aria-hidden="true">
    <div class="modal-dialog popup" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title">
            Verify Mobile
          </h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">X</span>
          </button>
        </div>
        <div class="modal-body">
          <form name="verifymodal" id="verifymodal" class="centered" action="getverificationcode.php">
            <div class="form-group col-md-12">
              <div id="msgsuccess">

              </div>
              <input type="hidden" id="hdnmobno" name="mob_number" value="" />
              <label for="code">Enter the 6 digit OTP send to <span id="verifyphone"></span> </label>
              <input type="tel" class="form-control" name="code" id="code" maxlength="6" placeholder="Enter OTP Code" required>
              <div class="invalid-feedback col-md-12">
                Verification failed!
              </div>
            </div>
            <div align="center">
              <button class="btn btn-success button-submit " type="submit">
              <strong><a id="resendotp" href="#">Resend One-Time Password</a></strong><br />
              Entered a wrong number?
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal -->
</div>
