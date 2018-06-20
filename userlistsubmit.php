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
    $userid = isset($_GET['userid'])?$_GET['userid']:false;
    $action = isset($_GET['action'])?$_GET['action']:false;
    if(!$action && !$userid) {
      $userid = isset($_POST['userid'])?$_POST['userid']:false;
      $action = isset($_POST['action'])?$_POST['action']:false;
    }
    echo "<script>console.log(' user id ".$userid."');</script>";
    echo "<script>console.log(' action ".$action."');</script>";
    $html = $uselected =$aselected =$uactive = $uinactive ="";
    if($action && $userid){
      if($action == "edituser") {
        if($link = OpenCon()) {
          $query="SELECT * FROM `users` where `id`  = ".mysqli_real_escape_string($link, $userid)."";
          $results = runQuery($link,$query);
          $query ="SELECT * FROM `states` WHERE `countryid` = '101'";
          $results2 = runQuery($link, $query);
          if(!empty($results)) {
            foreach($results as $user) {
              $uselected = $user['role']=="User"? "selected='selected'":"";
              $aselected = $user['role']=="Admin"? "selected='selected'":"";
              $uactive = $user['activate']=="1"? "selected='selected'" : "";
              $uinactive=$user['activate']=="0"? "selected='selected'" : "";
              $html = "
                     <h3>Edit Detail</h3><hr /><br />
                        <div id='editusermsg'>

                        </div>
                        <form class='form editfrm' id='editfrm' method='post'>
                            <div class='input-group'>
                             <input type='hidden' name='edituserid' id='editfrmid' value='".$user['id']."' >
                             <input class='form-control' type='text' name='editusername' id='editfrmname' placeholder='Full Name *' value='".$user['username']."' required>
                            </div>
                            <br />
                            <div class='input-group'>
                             <input class='form-control' type='text' name='edituseremail' id='editfrmemail' placeholder='Email *' value='".$user['email']."' required>
                            </div>
                            <br />
                            <div class='input-group'>
                             <select class='form-control' name='edituserrole' id='editfrmrole'>
                               <option value=''>Select role</option>
                               <option value='User' ".$uselected.">User</option>
                               <option value='Admin' ".$aselected.">Admin</option>
                             </select>
                            </div>
                            <br />
                            <div class='input-group'>
                              <input type='hidden' name='edituseractive' id='edituseractive' value='".$user['activate']."'  />
                             <select class='form-control' name='edituseractivesel' id='edituseractivesel' onChange='changestatus($(this).val());'>
                               <option value=1 ".$uactive.">Active</option>
                               <option value=0 ".$uinactive.">Inactive</option>
                             </select>
                            </div>
                            <br />
                            <div class='input-group'>
                  						<input class='form-control' type='password' name='edituserpwd'id='editpassword' style='width:15%;background:white;border: 1px #ced4da solid;padding:2px;' placeholder='************' />
                  					</div>
                  					<br/>
                  					<div class='bar center-block' style='width:100%;height:22px;background:whitesmoke;border:solid 0.5px;border-radius:5px;'>
                  						<div class='progressbar' role='progressbar' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100'></div>
                  					</div>
                            <br />
                            <input id='phonevalid'  name='phonevalid' type='hidden' value='1'/>
                            <input type='hidden' id='phone' name='phone' size='10' maxlength='10' value='".$user['contactno']."' />
                            <div class='input-group' >
                                    <input type='tel' id='tel1' class='form-control tel' value='".substr($user['contactno'],0,3)."' placeholder='999' size='3' maxlength='3' required='required' >-
                                    <input type='tel' id='tel2' class='form-control tel' value='".substr($user['contactno'],3,3)."' placeholder='999' size='3' maxlength='3' required='required' >-
                                    <input type='tel' id='tel3' class='form-control tel' value='".substr($user['contactno'],6,4)."' placeholder='9999' size='4' maxlength='4' required='required' >
                                    <div class='invalid-feedback'>
                                      The phone number needs to be verified.
                                    </div>
                                    <div class='valid-feedback'>
                                      Number Verified!
                                    </div>
                                    &nbsp;
                                    <span class='input-group-btn'>
                                      <button id='showdiv' class='btn btn-success' data-toggle='modal' data-target='#verifydiv'><i class='fa fa-phone' aria-hidden='true'></i> Verify Phone</button>
                                    </span>
                            </div>
                            <br />
                            <input type='text' id='address' class='form-control ' name='address1' placeholder='Address Line1' value='".$user['address1']."'> <br />
                            <input type='text' class='form-control ' name='address2' placeholder='Address Line2' value='".$user['address2']."'> <br />
                            <input type='hidden' id='state' name='state' value='".$user['stateid']."' />
                            <select form='editfrm' id='state-list' class='form-control custom-select' onChange='getDistrict(this.value);' required>
                                <option value=''>Select State</option>";
                                foreach($results2 as $state) {
                                  $strselected = $state['stateid'] == $user['stateid']?'selected':'';
                                  $html = $html.
                                      "<option value='".$state['stateid']."' ".$strselected." >".$state['statename']."</option>";
                                }
                            $html = $html .
                            "</select><br />
                            <br />
                            <input type='hidden' id='district' name='district' value='".$user['districtid']."'  />
                            <select form='editfrm' id='district-list' class='form-control  custom-select' onChange='getCity(this.value);' required>
                                <option value=''>Select District</option>";
                                  if(!empty($user['stateid'])) {
                                      	$query ='SELECT * FROM districts WHERE stateid = ' . $user['stateid'];
                                      	$results1 = runQuery($link,$query);
                                    foreach($results1 as $district) {
                                        $strselected = $district['districtid'] == $user['districtid']?'selected':'';
                    	                  $html = $html. "<option value='".$district['districtid']."' ".$strselected.">".$district['districtname']."</option>";
                                  } }
                            $html = $html ."</select>
                            <br /><br />
                            <input type='text' class='form-control ui-autocomplete-input' name='town' id='town' placeholder='Town / Village' value='".$user['town']."' required><br />
                            <input type='text' class='form-control ui-autocomplete-input' name='nhood' id='nhood' placeholder='Neighbourhood' value='".$user['nhood']."'><br />
                            <input type='Number' class='form-control ui-autocomplete-input' name='zipcode' id='zipcode' placeholder='Zipcode' value='".$user['zipcode']."' required><br />
                            <input id='editfrmupdate' type='submit' class='btn' style='width: 50%;' value='Update' />
                            <input id='editfrmclose' type='submit' class='btn' style='width: 50%;' value='Cancel' />
                        </form>
                        <!-- Verify Phone Number -->
                        <div id='verifydiv' class='modal modal-open fade' tabindex='-1' role='dialog' aria-labelledby='msgdiv' aria-hidden='true'>
                          <div class='modal-dialog popup' role='document'>
                            <div class='modal-content'>
                              <div class='modal-header'>
                                <h2 class='modal-title'>
                                  Verify Mobile
                                </h2>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                  <span aria-hidden='true'>X</span>
                                </button>
                              </div>
                              <div class='modal-body'>
                                <form name='verifymodal' id='verifymodal' class='centered' action='getverificationcode.php'>
                                  <div class='form-group col-md-12'>
                                    <div id='msgsuccess'>

                                    </div>
                                    <input type='hidden' id='hdnmobno' name='mob_number' value='' />
                                    <label for='code'>Enter the 6 digit OTP send to <span id='verifyphone'></span> </label>
                                    <input type='tel' class='form-control' name='code' id='code' maxlength='6' placeholder='Enter OTP Code' required>
                                    <div class='invalid-feedback col-md-12'>
                                      Verification failed!
                                    </div>
                                  </div>
                                  <div align='center'>
                                    <input id='btnvalidate' type='button' class='btn cancel' value='Validate'/><br /><br />
                                    <strong><a id='resendotp' href='#'>Resend One-Time Password</a></strong><br />
                                    Entered a wrong number?
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- End Modal -->
                        <script>
                        $(function() {
                          $('.tel').keyup(function(e) {
                              if (this.value.length == this.maxLength) {
                                $(this).next('.tel').focus();
                              }
                              if(e.target.id=='tel1' || e.target.id=='tel2' || e.target.id=='tel3') {
                                $('#phone').val($('#tel1').val()+$('#tel2').val()+$('#tel3').val());
                              }
                          });
                        });
                        function changestatus(value) {
                          $('#edituseractive').val(value);
                        }
                        </script>
              ";
            } }
          CloseCon($link);
        }
      } else if($action == "updateuser") {
        $editusername = isset($_POST['editusername'])?$_POST['editusername']:false;
        $edituseremail = isset($_POST['edituseremail'])?$_POST['edituseremail']:false;
        $edituserrole = isset($_POST['edituserrole'])?$_POST['edituserrole']:false;
        $edituseractive = isset($_POST['edituseractive']) && $_POST['edituseractive']=='1'?1:0;
        $edituserpwd = isset($_POST['edituserpwd'])?$_POST['edituserpwd']:false;
        $edituserphone = isset($_POST['phone'])?$_POST['phone']:false;
        $edituserphonevalid = isset($_POST['phonevalid'])?$_POST['phonevalid']:false;
        $edituseraddress1 = isset($_POST['address1'])?$_POST['address1']:false;
        $edituseraddress2 = isset($_POST['address2'])?$_POST['address2']:false;
        $edituserstate = isset($_POST['state'])?$_POST['state']:false;
        $edituserdistrict = isset($_POST['district'])?$_POST['district']:false;
        $editusertown = isset($_POST['town'])?$_POST['town']:false;
        $editusernhood = isset($_POST['nhood'])?$_POST['nhood']:false;
        $edituserzipcode = isset($_POST['zipcode'])?$_POST['zipcode']:false;
        if($link = OpenCon()) {
          $query="SELECT * FROM `users` where `id`  = ".mysqli_real_escape_string($link, $userid)."";
          $results = runQuery($link,$query);
          if(!empty($results)) {
            foreach($results as $user) {
              //$editusername = $editusername != $user['username']?$editusername:false;
              $edituseremail = $edituseremail != $user['email']?$edituseremail:false;
              $useractive = $edituseractive != $user['activate']?$edituseractive:false;
              $edituserrole = $edituserrole != $user['role']?$edituserrole:false;
              $edituserpwd = $edituserpwd!="" && password_verify($edituserpwd, $user['password'])?$edituserpwd:false;
              $edituserphone = $edituserphone!="" && $edituserphonevalid == 1 && $edituserphone!=$user['contactno'] ?$edituserphone:false;
              $edituseraddress1 = $edituseraddress1 != $user['address1']?$edituseraddress1:false;
              $edituseraddress2 = $edituseraddress2 != $user['address2']?$edituseraddress2:false;
              $edituserstate = $edituserstate != $user['stateid']?$edituserstate:false;
              $edituserdistrict = $edituserdistrict != $user['districtid']?$edituserdistrict:false;
              $editusertown = $editusertown != $user['town']?$editusertown:false;
              $editusernhood = $editusernhood != $user['nhood']?$editusernhood:false;
              $edituserzipcode = $edituserzipcode != $user['zipcode']?$edituserzipcode:false;

              $nameqry=$emailqry=$activeqry=$roleqry=$pwdqry="";
              $phoneqry=$addressqry1=$addressqry2=$stateqry=$districtqry=$nhoodqry=$townqry=$zipcodeqry="";

              if($editusername || $edituseremail || $useractive==true || $edituserrole || $edituserpwd
                  || $edituserphone || $edituseraddress1 || $edituseraddress2 || $edituserstate || $edituserdistrict
                  || $editusertown ||$editusernhood ||  $edituserzipcode) {
                $query = "UPDATE `users` SET ";
                if($editusername) {
                  $nameqry = "`username` = '".mysqli_real_escape_string($link, $editusername)."'";
                }
                if($edituseremail) {
                  $emailqry = "`email` = '".mysqli_real_escape_string($link, $edituseremail)."'";
                }
                if($useractive==true) {
                  $activeqry = "`activate` = ".mysqli_real_escape_string($link, $edituseractive)."";
                }
                if($edituserrole) {
                  $roleqry = "`role` = '".mysqli_real_escape_string($link, $edituserrole)."'";
                }
                if($edituserpwd) {
                  $pwdqry = "`password` = '".mysqli_real_escape_string($link, password_hash($edituserpwd,PASSWORD_DEFAULT))."'";
                }
                if($edituserphone){
                  $phoneqry = "`contactno` = '".mysqli_real_escape_string($link, $edituserphone)."',`phonevalid` = 1";
                }
                if($edituseraddress1){
                  $addressqry1 = "`address1` = '".mysqli_real_escape_string($link, $edituseraddress1)."'";
                }
                if($edituseraddress2){
                  $addressqry2 = "`address2` = '".mysqli_real_escape_string($link, $edituseraddress2)."'";
                }
                if($edituserstate){
                  $stateqry = "`stateid` = '".mysqli_real_escape_string($link, $edituserstate)."'";
                }
                if($edituserdistrict){
                  $districtqry = "`districtid` = '".mysqli_real_escape_string($link, $edituserdistrict)."'";
                }
                if($editusertown){
                  $townqry = "`town` = '".mysqli_real_escape_string($link, $editusertown)."'";
                }
                if($editusernhood){
                  $nhoodqry = "`nhood` = '".mysqli_real_escape_string($link, $editusernhood)."'";
                }
                if($edituserzipcode){
                  $zipcodeqry = "`zipcode` = '".mysqli_real_escape_string($link, $edituserzipcode)."'";
                }
                $whereqry = " where `id` = " .mysqli_real_escape_string($link,$userid)." LIMIT 1";
                $query = $query . ($nameqry!=''?$nameqry:'')
                        . ($emailqry != '' ?' ,'.$emailqry:'')
                        . ($activeqry != '' ?' ,'.$activeqry:'')
                        . ($roleqry != ''?' ,'.$roleqry:'')
                        . ($pwdqry != ''?' ,'.$pwdqry:'')
                        . ($phoneqry != ''?' ,'.$phoneqry:'')
                        . ($addressqry1 != ''?' ,'.$addressqry1:'')
                        . ($addressqry2 != ''?' ,'.$addressqry2:'')
                        . ($stateqry != ''?' ,'.$stateqry:'')
                        . ($districtqry != ''?' ,'.$districtqry:'')
                        . ($townqry != ''?' ,'.$townqry:'')
                        . ($nhoodqry != ''?' ,'.$nhoodqry:'')
                        . ($zipcodeqry != ''?' ,'.$zipcodeqry:'')
                        . $whereqry;
                echo "<script>console.log(' query ".$query."');</script>";
                if(mysqli_query($link, $query)) {
                  $html = "
                    <p>
                    User details updated successfully!
                    </p>
                  ";
                } else {
                  $html = "
                    <p>
                    Failed to update. Please try again later.
                    </p>
                  ";
                }
              } else {
                $html = "
                  <p>
                  No update
                  </p>
                ";
              }
            } }
            CloseCon($link);
        }
      } else if($action == "deleteuser") {
          if($link = OpenCon()) {
            $query="DELETE FROM `users` where `id`  = '".mysqli_real_escape_string($link, $userid)."'";
            $query1="DELETE T FROM `images` T inner join `item` on `item`.`itemid` = T.`itemid` where `item`.`postedby`  = '".mysqli_real_escape_string($link, $userid)."'";
            $query2="DELETE FROM `item` where `postedby`  = '".mysqli_real_escape_string($link, $userid)."'";

            if(mysqli_query($link, $query1) or die(mysqli_error($link))) {
               if(mysqli_query($link, $query2) or die(mysqli_error($link))) {
                if(mysqli_query($link, $query) or die(mysqli_error($link))) {
                  $html = "
                    <p class='alert alert-success'>
                    User profile removed successfully!!
                    </p>
                  ";
            } else {
              $html = "
                <p class='alert alert-danger'>
                Failed to delete. Please try again later.
                </p>
              ";
            }}}
            CloseCon($link);
          }
      } else if($action == "deleteprofile") {
          if($link = OpenCon()) {
            $query="DELETE FROM `users` where `id`  = '".mysqli_real_escape_string($link, $userid)."'";
            $query1="DELETE T FROM `images` T inner join `item` on `item`.`itemid` = T.`itemid` where `item`.`postedby`  = '".mysqli_real_escape_string($link, $userid)."'";
            $query2="DELETE FROM `item` where `postedby`  = '".mysqli_real_escape_string($link, $userid)."'";

            if(mysqli_query($link, $query1) or die(mysqli_error($link))) {
               if(mysqli_query($link, $query2) or die(mysqli_error($link))) {
                if(mysqli_query($link, $query) or die(mysqli_error($link))) {
                  session_unset();
                  session_destroy();
                  exit();
            } else {
              $html = "
                <p class='alert alert-danger'>
                Failed to delete. Please try again later.
                </p>
              ";
            }}}
            CloseCon($link);
          }
      }
    }
    echo $html;

?>
<script src="js/jquery.min.js"></script>

<script type="text/javascript">
$("#editpassword").bind("keyup", function () {
 
     //Regular Expressions.
      var regex = [];
      regex.push("[A-Z]"); //Uppercase Alphabet.
      regex.push("[a-z]"); //Lowercase Alphabet.
      regex.push("[0-9]"); //Digit.
      regex.push("[$@$!%*#?&]"); //Special Character.
   
      var passed = 0;
   
      //Validate for each Regular Expression.
      for (var i = 0; i < regex.length; i++) {
         if (new RegExp(regex[i]).test($(this).val())) {
               passed++;
          }
      }
   
   
      //Validate for length of Password.
      if (passed > 2 && $(this).val().length > 8) {
          passed++;
      }
   
       //Display status.
      var color = "";
      var strength = "";
    var width = "";

              switch (passed) {
                  case 0:
                  case 1:
                      strength = "<p>Weak</p>";
                      color = "darkorange";
            width = "25%";

                      break;
                  case 2:
                      strength = "<p>Good</p>";
                      color = "darkcyan";
            width = "50%";

                      break;
                  case 3:
                  case 4:
                      strength = "<p>Strong</p>";
                      color = "darkturquoise";
            width = "75%";

                      break;
                  case 5:
                      strength = "<p>Very Strong</p>";
                      color = "#4CAF50";
            width = "100%";

                      break;
              }

  $(".progressbar").css("width", width);
  $(".progressbar").css("background", color);
  $(".progressbar").css("color", "white");
  $(".progressbar").css("border-radius", "5px");
  $(".progressbar").css("text-align", "center");
  $(".progressbar").html(strength);

});

//user edit form Update
$('#editfrmupdate').click(function(e){
  e.preventDefault();
  $('#editfrmupdate').addClass('disabled');
    var formdata = new FormData();
    var userid = $('#editfrmid').val();
    $.each($('.editfrm input'), function(i, v) {
  			if (v.type !== 'submit') {
  					formdata.append(v.name,v.value)
  			}
  	});
    $.each($('.editfrm select'), function(i, v) {
  					formdata.append(v.name,v.value)
  	});
    formdata.append('action', 'updateuser');
    formdata.append('userid', userid);
    console.log('form data');
    $.ajax({
      type: "POST",
      data: formdata,
      url: 'userlistsubmit.php',
      contentType: false,
      processData: false,
      success: function (response) {
          console.log('success');
          successbool = "true";
          $('#editusermsg').html("");
          $('#editusermsg').removeClass("alert alert-danger");
          $('#editusermsg').removeClass("alert alert-success");
          try {
            $('#editusermsg').html(response);
            $('#editusermsg').addClass("alert alert-success");
          } catch(e) {
              successbool = "false";
    					$('#editusermsg').html(response);
              $('#editusermsg').addClass("alert alert-danger");
          }
          $('#editfrmupdate').removeClass('disabled');
      },
      complete:function(){
        $('body, html').animate({scrollTop:$('.form').parent().parent().offset().top - 200}, 'slow');
     	},
  		error: function(err) {
  			alert("error " + err.status + " " + err.statusText);
  		}

    });
});

</script>
