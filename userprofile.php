<?php
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

      if($phone==="") {
        $updateprofile .= '<div class="alert-danger">Please enter the phone number and get it verfied. </div>';
      } else {
        if($phonevalid!=1){
                  $updateprofile .= '<div class="alert-danger">Phone number needs to be verfied. </div>';
        }
      }
      if($state==="") {
        $updateprofile .= '<div class="alert-danger">Please select the state. </div>';
      }
      if($district==="") {
        $updateprofile .= '<div class="alert-danger">Please select the district. </div>';
      }
      if($town==="") {
        $updateprofile .= '<div class="alert-danger">Please enter the town. </div>';
      }
      if($zipcode==="") {
        $updateprofile .= '<div class="alert-danger">Please enter the zipcode. </div>';
      }

      if($_POST['phone']!="" || $_POST['phonevalid']!= 0 || $_POST['state']!="" || $_POST['district']!=="" || $_POST['town']!=="" || $_POST['zipcode']!==""){
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
<div id="updateprofile" class="col-lg-6 col-md-6 col-sm-6">
  <div class="content-box">
    <h3>Update Profile</h3><br />
    <div id="successmessage">
        <?php echo $updateprofile; ?>
    </div>
    <input type="hidden" id="hosturl" value="<?php echo $hosturl;?>" >
    <hr />
    <form name="profileform" class="form" action="home.php?action=profile" id="changeprofile" method="post">
      <?php
      if($link = OpenCon()) {
        $query ="SELECT * FROM users WHERE id = '". $userid ."'";
        $results = runQuery($link, $query);
        CloseCon($link);
      }
      foreach($results as $user) {      ?>
        <div class="form-row">
            <div class="form-group col-md-4">
              <label><?php echo $user['username'];?></label>
            </div>
            <div class="form-group col-md-5">
              <label><?php echo $user['email'];?></label>
            </div>
            <div class="form-group col-md-3">
              <button class="btn btn-danger btn-xs deleteuserbtn" data-title="Delete" data-userid="<?php echo $user['id']?>" data-toggle="modal" data-target="#delete" >Delete Profile</button>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
               <label>Phone </label>
               <input id="phonevalid"  name="phonevalid" type="hidden" value="1"/>
               <input type="hidden" id="phone" name="phone" value="<?php echo $user['contactno'];?>" />
               <div class="input-group" onKeyUp="$('#phone').val($('#tel1').val() + $('#tel2').val() + $('#tel3').val())">
                       <input type="tel" id="tel1" class="form-control" value="<?php echo substr($user['contactno'],0,3);?>" size="3" maxlength="3" >-
                       <input type="tel" id="tel2" class="form-control" value="<?php echo substr($user['contactno'],3,3);?>" size="3" maxlength="3" >-
                       <input type="tel" id="tel3" class="form-control" value="<?php echo substr($user['contactno'],6,4);?>" size="4" maxlength="4" >
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
          <label for="state-list">State </label>
          <input type="hidden" id="state" name="state" value="<?php echo $user['stateid']; ?>" />
          <select form="profileform" id="state-list" class="form-control custom-select" onChange="getDistrict(this.value);" >
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
          <label for="district-list">District </label>
          <input type="hidden" id="district" name="district" value="<?php echo $user['districtid']; ?>"  />
          <select form="profileform" id="district-list" class="form-control  custom-select" onChange="getCity(this.value);">
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
          <label for="town">Town / Village </label>
          <input type="text" class="form-control ui-autocomplete-input" name="town" id="town" placeholder="Town / Village" value="<?php echo $user['town'];?>">
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
          <label for="zipcode">Zipcode </label>
          <input type="Number" class="form-control ui-autocomplete-input" name="zipcode" id="zipcode" placeholder="Zipcode" value="<?php echo $user['zipcode'];?>">
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
              <input id="btnvalidate" type="button" class="btn cancel" value="Validate"/><br /><br />
              <strong><a id="resendotp" href="#">Resend One-Time Password</a></strong><br />
              Entered a wrong number?
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal -->
  <!-- Delete User -->
  <div class="modal modal-open fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog popup">
     <div class="modal-content">
       <div class="modal-header">
         <h2>Delete entry</h2>
         <form>

         </form>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">X</span>
         </button>
       </div>
        <div class="modal-body">

     <div class="alert alert-danger"><i class="fa fa-warning"></i> Are you sure you want to delete your profile from NeighbourhoodFarmers.com?</div>
     <input id="hdnuserid" type="hidden" value="" />
    </div>
      <div class="modal-footer ">
      <button id="delbutton" type="button" class="btn btn-success" ><i class="fa fa-ok-sign"></i> Yes</button>
      <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> No</button>
    </div>
      </div>
  <!-- /.modal-content -->
</div>
</div>
<!-- End Modal -->
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
    $("#delbutton").click(function(e){
      e.preventDefault();
      var userid = $('#hdnuserid').val();
      $.ajax({
        url: 'userlistsubmit.php',
        data: {userid: userid, action: 'deleteprofile'},
        type: 'GET',
        dataType: 'HTML'
      }).done(function(res){
        $('#delete').modal('hide');
        if(res!=""){
          $('#updateprofile').find('#successmessage').html(res);
        }
        window.location = 'http://'+ $('#hosturl').val() +'/home.php';
      });
    });

/*    $('#delete').on('hidden', function () {
      setTimeout(function(){ location.reload(); }, 5000);
   });*/
</script>
</div>
