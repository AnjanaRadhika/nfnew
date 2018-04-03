<?php
if($link = OpenCon()) {
  $query="SELECT * FROM users";
  if(!empty($_POST)){
    $where = " where ";
    if(array_key_exists('nameoremail', $_POST) && $_POST['nameoremail'] !== "") {
      $query = $query . $where . " ((`username` like '%" .mysqli_real_escape_string($link,$_POST['nameoremail']) . "%')"
                . "or (`email` like '%".mysqli_real_escape_string($link,$_POST['nameoremail'])."%'))";
    }
    if(array_key_exists('searchuserrole', $_POST) && $_POST['searchuserrole'] !== "") {
      if(strpos($query,'where') !== false) {
        $query = $query . " and ";
      } else {
        $query = $query . $where;
      }
      $query = $query . " `role` = '".mysqli_real_escape_string($link,$_POST['searchuserrole'])."'";
    }
    if(array_key_exists('searchuseractive', $_POST)  && $_POST['searchuseractive'] !== "") {
      if(strpos($query,'where') !== false) {
        $query = $query . " and ";
      } else {
        $query = $query . $where;
      }
      $query = $query. " `activate` = '".mysqli_real_escape_string($link,$_POST['searchuseractive'])."'";
    }
  }
  $results = runQuery($link,$query);
  $rowcount = getRowCount($link, $query);
  $itemsperpage = 50;
  if(intVal($rowcount%$itemsperpage) > 0 ) {
    $pages = intVal($rowcount/$itemsperpage) + 1;
  } else {
    $pages = intVal($rowcount/$itemsperpage);
  }
  CloseCon($link);
}
 ?>

 <div id="userlist" class="col-lg-7 col-md-7 col-sm-7">
   <div class="usersearch">
     <br /><br />
     <form class="searchUserForm" method="post" action="home.php?action=userlist" role="search">
       <div class="form-group-sm">
         <div class="input-group">
           <input type="text" name="nameoremail" class="form-control form-element" placeholder="Search Name or Email">
           <select class='form-control form-element' name='searchuserrole' id='searchfrmrole'>
             <option value=''>Select All Roles</option>
             <option value='User' ".$uselected.">User</option>
             <option value='Admin' ".$aselected.">Admin</option>
           </select>
           <select class='form-control form-element' name='searchuseractive' id='searchuseractive'>
             <option value=''>Select All Users</option>
             <option value=1 ".$uactive.">Active</option>
             <option value=0 ".$uinactive.">Inactive</option>
           </select>
           <span class="input-group-btn">
             <button class="btn btn-success btn-sm form-element" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Go!</button>
           </span>
         </div>
       </div>
     </form>
   </div>
   <div class="content-box">
       <h3>List of Users</h3>
       <div class="text-muted">
         - <?php echo $rowcount?> users
       </div>
       <div class="table-responsive">
         <div class="deletemsg">

         </div>

             <table id="usertable" class="table table-bordred table-striped">

                  <thead>
                    <th>Id</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </thead>
                  <tbody>
                    <?php
                      if(!empty($results)) {
                        foreach($results as $user) { ?>
                     <tr id="<?php echo $user['id']?>">
                       <td class="edituserid"><?php echo $user['id']?></td>
                       <td class="editusername"><?php echo $user['username']?></td>
                       <td class="edituseremail"><?php echo $user['email']?></td>
                       <td class="edituserrole"><?php echo $user['role']?></td>
                       <td class="edituseractive" style="display:none"><?php echo $user['activate'] ?></td>
                       <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs edituserbtn" data-title="Edit" data-userid="<?php echo $user['id']?>" ><i class="fa fa-pencil" aria-hidden="true"></i></button></p></td>
                       <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs deleteuserbtn" data-title="Delete" data-userid="<?php echo $user['id']?>" data-toggle="modal" data-target="#delete" ><i class="fa fa-trash" aria-hidden="true"></i></button></p></td>
                     </tr>
                    <?php } } ?>

                  </tbody>

              </table><br />

            </div>

 </div>
</div>

   <div class="modal modal-open fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
     <div class="modal-dialog popup">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Delete entry</h2>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">X</span>
          </button>
        </div>
         <div class="modal-body">

      <div class="alert alert-danger"><i class="fa fa-warning"></i> Are you sure you want to delete this User?</div>
      <input id="hdnuserid" type="hidden" />
     </div>
       <div class="modal-footer ">
       <button id="delbutton" type="button" class="btn btn-success" ><i class="fa fa-ok-sign"></i> Yes</button>
       <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> No</button>
     </div>
       </div>
   <!-- /.modal-content -->
 </div>
 </div>
 <script src="js/jquery.min.js"></script>
 <script type="text/javascript">
     $("#delbutton").click(function(e){
       e.preventDefault();
       var userid = $('#hdnuserid').val();
       $.ajax({
         url: 'userlistsubmit.php',
         data: {userid: userid, action: 'deleteuser'},
         type: 'GET',
         dataType: 'HTML'
       }).done(function(res){
         $('#delete').modal('hide');
         $('#userlist').find('div.text-muted').hide();
         $('#userlist').find('tr#'+userid).hide();
         $('#userlist').find('.deletemsg').html(res);
       });
     });

/*    $('#delete').on('hidden', function () {
       setTimeout(function(){ location.reload(); }, 5000);
    });*/
 </script>
