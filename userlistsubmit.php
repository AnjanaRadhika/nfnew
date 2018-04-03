<?php
    include('db_connection.php');
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
                             <input class='form-control' type='text' name='editusername' id='editfrmname' placeholder='Full Name' value='".$user['username']."'>
                            </div>
                            <br />
                            <div class='input-group'>
                             <input class='form-control' type='text' name='edituseremail' id='editfrmemail' placeholder='Email' value='".$user['email']."'>
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
                             <select class='form-control' name='edituseractive' id='edituseractive'>
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
                            <input id='editfrmupdate' type='submit' class='btn' style='width: 50%;' value='Update' />
                            <input id='editfrmclose' type='submit' class='btn' style='width: 50%;' value='Cancel' />
                        </form>
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
        if($link = OpenCon()) {
          $query="SELECT * FROM `users` where `id`  = ".mysqli_real_escape_string($link, $userid)."";
          $results = runQuery($link,$query);
          if(!empty($results)) {
            foreach($results as $user) {
              $editusername = $editusername != $user['username']?$editusername:false;
              $edituseremail = $edituseremail != $user['email']?$edituseremail:false;
              $useractive = $edituseractive != $user['activate']?true:false;
              $edituserrole = $edituserrole != $user['role']?$edituserrole:false;
              $edituserpwd = $edituserpwd!="" && password_verify($edituserpwd, $user['password'])?$edituserpwd:false;

              $nameqry=$emailqry=$activeqry=$roleqry=$pwdqry="";
              if($editusername || $edituseremail || $useractive || $edituserrole || $edituserpwd) {
                $query = "UPDATE `users` SET ";
                if($editusername) {
                  $nameqry = "`username` = '".mysqli_real_escape_string($link, $editusername)."'";
                }
                if($edituseremail) {
                  $emailqry = "`email` = '".mysqli_real_escape_string($link, $edituseremail)."'";
                }
                if($useractive) {
                  $activeqry = "`activate` = '".mysqli_real_escape_string($link, $edituseractive)."'";
                }
                if($edituserrole) {
                  $roleqry = "`role` = '".mysqli_real_escape_string($link, $edituserrole)."'";
                }
                if($edituserpwd) {
                  $pwdqry = "`password` = '".mysqli_real_escape_string($link, password_hash($edituserpwd,PASSWORD_DEFAULT))."'";
                }
                $whereqry = " where `id` = " .mysqli_real_escape_string($link,$userid)." LIMIT 1";
                $query = $query . ($nameqry!=''?$nameqry:'')
                        . ($nameqry!='' && $emailqry != '' ?' ,'.$emailqry:$emailqry)
                        . ($nameqry!='' && $emailqry != '' && $activeqry != '' ?' ,'.$activeqry:$activeqry)
                        . ($nameqry!='' && $emailqry != '' && $activeqry != '' && $roleqry != ''?' ,'.$roleqry:$roleqry)
                        . ($nameqry!='' && $emailqry != '' && $activeqry != '' && $roleqry != '' && $pwdqry != ''?' ,'.$pwdqry:$pwdqry)
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
              } else if(!$editusername && !$edituseremail && !$edituseractive && !$edituserrole && !$edituserpwd) {
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
            $query="DELETE FROM `users` where `id`  = ".mysqli_real_escape_string($link, $userid)."";
            if(mysqli_query($link, $query)) {
              $html = "
                <p class='alert alert-success'>
                User deleted successfully!
                </p>
              ";
            } else {
              $html = "
                <p class='alert alert-danger'>
                Failed to delete. Please try again later.
                </p>
              ";
            }
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
