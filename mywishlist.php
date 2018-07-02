<?php
if($link = OpenCon()) {
  $query = "SELECT * from `wishlist` lst inner join `itemcategory` ctg on
                lst.itemcategory = ctg.categoryid";
  if(!empty($_SESSION)) {
    if(array_key_exists('id', $_SESSION)) {
      $query = $query." where lst.createdby = '".$_SESSION['id']."'";
    }
  }
  $query = $query." order by createdon desc";
  $results = runQuery($link,$query);
  $results = runQuery($link,$query);
  $rowcount = getRowCount($link, $query);
  $itemsperpage = 5;
  if(intVal($rowcount%$itemsperpage) > 0 ) {
    $pages = intVal($rowcount/$itemsperpage) + 1;
  } else {
    $pages = intVal($rowcount/$itemsperpage);
  }
  if($pages > 1) {
    $disabled = "";
  } else {
    $disabled = "disabled";
  }
  CloseCon($link);
}

function getInterval($createddate) {
  $datetime1 = new DateTime();
  $datetime2 = new DateTime($createddate);
  $difference = $datetime1 -> diff($datetime2);

  if($difference->s >= 0 && $difference->i >= 0 && $difference->h >= 0 && $difference->d >= 0 && $difference->m >= 0 && $difference->y > 0) {
    if($difference->y === 1)
      $return= $difference->y . " year ";
    else
      $return= $difference->y . " years ";
  } else if($difference->s >= 0 && $difference->i >= 0 && $difference->h >= 0 && $difference->d >= 0 && $difference->m > 0) {
    if($difference->m === 1)
      $return= $difference->m . " month ";
    else {
      $return= $difference->m . " months ";
    }
  } else if($difference->s >= 0 && $difference->i >= 0 && $difference->h >= 0 && $difference->d > 0) {
    if($difference->d ===1)
      $return= $difference->d . " day ";
    else {
      $return=$difference->d . " days ";
    }
  } else if($difference->s >= 0 && $difference->i >= 0 && $difference->h > 0) {
    if($difference->h===1)
      $return= $difference->h . " hour ";
    else
      $return= $difference->h . " hours ";
  } else if($difference->s >= 0 && $difference->i > 0) {
    if($difference->i === 1)
      $return= $difference->i . " minute ";
    else
      $return= $difference->i . " minutes ";
  } else if($difference->s > 0) {
    if($difference->s === 1)
      $return= $difference->s . " second ";
    else
      $return= $difference->s . " seconds ";
  }
  echo $return;
}
 ?>

 <div id="wishlist" class="col-lg-6 col-md-6 col-sm-6">
   <div class="content-box">
       <h3>My Favorites</h3><br />
       <a class="btn btn-success" href="home.php?action=newwish"><i class="fa fa-magic" aria-hidden="true"></i> Add New Favorite to the List</a>
       <hr />
       <form id="homeSearch" action="home.php?action=search" method="post">
         <input type="hidden" id="itemsearch" name="itemsearch" value="" />
         <input type="hidden" id="location" name="location" value="" />
       </form>
       <?php
         if(!empty($results)) {
           $cur=1;
           $itemcount=1;
           foreach($results as $wish) {
             if($itemcount === 1) {
                 $pagestyle = $cur == 1 ? "" : "display:none"; ?>
               <div id="page<?php echo $cur ?>" class="wishitem text-left" style="<?php echo $pagestyle ?>" >
               <?php  }  ?>
               <h2><a href="javascript:goToSearch('<?php echo $wish['wishdesc'];?>', '<?php echo $wish['location'];?>');"><?php echo $wish['wishdesc'];?></a></h2>
               <p>
                 <?php
                 if(strpos($wish['wishdetails'],'available')) {
                   $var = str_replace('available', '', $wish['wishdetails']);
                 } else {
                   $var = $wish['wishdetails'];
                 }
                  echo $var;
                 ?><br /><strong>Category : </strong><?php
                 if($wish['itemcategory'])
                    echo $wish['categorydesc'];
                 ?><br /><strong>Location : </strong><?php
                 if($wish['location'])
                    echo $wish['location'];
                 ?>
               </p>
               <p class="text-muted">
                 Created <?php
                 if(!empty($_SESSION)) {
                   if(array_key_exists('name', $_SESSION) && $_SESSION['name'] !==$wish['createdbyname']) {
                     echo " by ". $wish['createdbyname'] . ", ";
                   } else {
                     echo " by me ";
                   }
                 } else {
                    echo " by ". $wish['createdbyname'] . ", ";
                 }
                  ?> <?php getInterval($wish['createdon']); ?>ago.
               </p>
               <div> <button class="btn delwishbtn badge badge-pill badge-danger" data-title="Delete" data-target="#delete" data-toggle="modal" data-wish=<?php echo $wish['id'];  ?> >
                 <i id="icoheart" class="fa fa-trash"></i> Remove</button> </div>
               <hr style="color:green"  />
               <?php if(($itemcount === $itemsperpage)) {
                       $cur++;
                       $itemcount = 0;
                 ?>
             </div>
           <?php  }
           $itemcount++;
            } ?>
            <input type="hidden" id="curpage" value="1" />
            <input type="hidden" id="numpages" value="<?php echo $pages; ?>" />
          <?php } else { ?>
          <div class="alert alert-danger">
            No Records Found!
          </div>
        <?php  }  ?>
   </div>
   <div class="text-center">
     <ul class="pagination pager d-inline-flex" id="myPager">
       <li><a href="#" id="prev" class="page disabled">«</a></li>
       <?php for($cur=1;$cur<$pages + 1; $cur++) {
                 $pageclass = $cur == 1 ? "page active" : "page";
             ?>
           <li><a id="pagelink<?php echo $cur ?>" href="#page<?php echo $cur ?>" class="<?php echo $pageclass ?>"><?php echo $cur ?></a></li>
       <?php } ?>
       <li><a id="next" href="#" class="page <?php echo $disabled ?>" >»</a></li>
     </ul>
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

    <div class="alert alert-danger"><i class="fa fa-warning"></i> Are you sure you want to remove from the list?</div>
    <input id="hdnwishid" type="hidden" value="" />
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
$('.delwishbtn').click(function(e){
  e.preventDefault();
  $('#hdnwishid').val($(this).data('wish'));
});
//Remove Wishlist
$('#delbutton').click(function(e){
      e.preventDefault();
      var wishid =$('#hdnwishid').val();
      $.ajax({
        url: 'delwishlist.php?wishid='+wishid,
        type: 'GET',
        dataType: 'HTML'
      }).done(function(res){
        $('#delete').modal('hide');
        $('#msgdiv').find('#msg').html(res);
        $('#msgdiv').modal('show');
      });
});

function goToSearch(wishdesc, location) {
  $('#itemsearch').val(wishdesc);
  $('#location').val(location);
  $('#homeSearch').submit();
}
</script>
