<?php
$itemsperpage = 20;
$sellorbuy = "All";
$location=$itemsearch="";
$filterby="all";
if($link = OpenCon()) {
  $query ="SELECT * FROM item itm inner join images img on itm.itemid = img.itemid
                                  inner join itemcategory ctg on itm.categoryid = ctg.categoryid
where img.imageid = (select max(img1.imageid) from images img1 where img1.itemid = itm.itemid)
and (itm.status is null or itm.status = '' or itm.status <> 'Remove Ad') ";
  if(!empty($_SESSION)) {
    if(array_key_exists('id', $_SESSION)) {
      $query = $query." and postedby <> '".$_SESSION['id']."'";
    }
  }
  if(!empty($_POST)){
    if(empty($_SESSION) && array_key_exists('user', $_POST)) {
      $query = $query." and postedby <> '".$_POST['user']."'";
    }
    if(array_key_exists('location', $_POST)) {
      $location= $_POST['location'];
      $query = $query . " and ((itm.town like '%" . mysqli_real_escape_string($link,$_POST['location']) ."%')"
                        . " or (itm.nhood like '%" . mysqli_real_escape_string($link,$_POST['location']) ."%')"
                        . " or (itm.districtid in ( select districtid from districts where districtname like '%" . mysqli_real_escape_string($link,$_POST['location']) ."%'))"
                        . " or (itm.address2 like '%" . mysqli_real_escape_string($link,$_POST['location']) ."%'))";
    }
    if(array_key_exists('itemsearch', $_POST)) {
      $itemsearch = $_POST['itemsearch'];
      $query = $query . " and ((itm.itemname like '%" . mysqli_real_escape_string($link,$_POST['itemsearch']) ."%')"
                          . " or (ctg.categoryname like '%" . mysqli_real_escape_string($link,$_POST['itemsearch']) ."%')"
                          . " or (itm.itemcode = '" . mysqli_real_escape_string($link,$_POST['itemsearch']) ."'))";
    }
    if(array_key_exists('sellorbuy', $_POST)) {
      $sellorbuy = $_POST['sellorbuy'];
      if($_POST['sellorbuy'] != 'All') {
        $query = $query . " and itm.sellorbuy = '" . mysqli_real_escape_string($link,$_POST['sellorbuy']) ."'";
      }
    }
    if(array_key_exists('filterby', $_POST)) {
      $filterby = $_POST['filterby'];
      if($_POST['filterby'] == 'available') {
        $query = $query . " and date(now()) between effectivedate and expirydate";
      } else if($_POST['filterby'] == 'harvesting') {
        $query = $query . " and date(now()) <= effectivedate and date(now()) <= expirydate";
      } else if($_POST['filterby'] == 'expired') {
        $query = $query . " and date(now()) > expirydate";
      }
    }
  }

  $results = runQuery($link,$query);
  $rowcount = getRowCount($link, $query);

  if(!empty($_POST)){
    if(array_key_exists('itemsperpage', $_POST)) {
      if($_POST['itemsperpage'] != 'All') {
        $itemsperpage = $_POST['itemsperpage'];
      } else {
        $itemsperpage = $rowcount;
      }
    }

    if(array_key_exists('filterby', $_POST)) {
        $filterby = $_POST['filterby'];
    }
  }

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

?>
 <div class="col-lg-6 col-md-6 col-sm-6">
   <div class="row">
   	<div class="jumbotron content col-lg-12 col-md-12 col-sm-12">
   		<form id="itemPostForm" class="searchItemForm" method="post" action="home.php?action=editposts" role="search">
        <div class="form-group-sm">
          <div class="input-group">
            <input type="text" name="location" class="form-control col-md-6" placeholder="Search Neighbourhood">
            <input type="text" name="itemsearch" class="form-control col-md-6" placeholder="Search Item">
            <span class="input-group-btn">
              <button class="btn btn-success" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Go!</button>
            </span>
          </div>
          <br />
          <div class="input-group">
            <div class="col-md-6" style="padding-left:0px;">
              <div class="custom-control custom-radio custom-control-inline" style="float:left;">
                <input class="custom-control-input" type="radio" name="radioBuyOptions" id="forsale" value="For Sale" <?php if($sellorbuy=="For Sale") echo 'checked'; ?> >
                <label class="custom-control-label" for="forsale">Items for Sale</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline" style="float:left;">
                <input class="custom-control-input" type="radio" name="radioBuyOptions" id="tobuy" value="To Buy" <?php if($sellorbuy=="To Buy") echo 'checked'; ?> >
                <label class="custom-control-label" for="tobuy">Requests from Buyer</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline" style="float:left;">
                <input class="custom-control-input" type="radio" name="radioBuyOptions" id="all" value="All" <?php if($sellorbuy=="All") echo 'checked'; ?> >
                <label class="custom-control-label" for="all">All</label>
              </div>
              <input type="hidden" id="sellorbuy" name="sellorbuy" value="<?php echo $sellorbuy; ?>" />
            </div>
            <div class="col-md-3" style="padding-right:0px;">
              <input type="hidden" name="filterby" id="filterby" aria-hidden="true" value="<?php echo $filterby;?>" />
              <select id="selfilterby" class="form-control custom-select" style="width:85%;float:right;">
                <option value="all" <?php if($filterby=="all") echo 'selected'; ?> >All Items </option>
                <option value="available" <?php if($filterby=="available") echo 'selected'; ?> >Available Items </option>
                <option value="harvesting" <?php if($filterby=="harvesting") echo 'selected'; ?> >Harvesting Items </option>
                <option value="expired" <?php if($filterby=="expired") echo 'selected'; ?> >Expired Items </option>
              </select>
            </div>
          <div class="col-md-3" style="padding-right:0px;">
            <input type="hidden" name="itemsperpage" id="itemsperpage" aria-hidden="true" value="<?php echo $itemsperpage;?>" />
            <select id="selitemsperpage" class="form-control custom-select" style="width:85%;float:right;">
              <option value="20" <?php if($itemsperpage=="20") echo 'selected'; ?> >20 per page </option>
              <option value="40" <?php if($itemsperpage=="40") echo 'selected'; ?> >40 per page </option>
              <option value="60" <?php if($itemsperpage=="60") echo 'selected'; ?> >60 per page </option>
              <option value="80" <?php if($itemsperpage=="80") echo 'selected'; ?> >80 per page </option>
              <option value="100"<?php if($itemsperpage=="100") echo 'selected'; ?> >100 per page </option>
              <option value="<?php echo $rowcount; ?>" <?php if($itemsperpage==$rowcount) echo 'selected'; ?> >All</option>
            </select>
          </div>
        </div>
          </div>
   		</form>
   </div>
   </div>
   <div class="row">
     <div id="results" class="col-lg-12 col-md-12 col-sm-12">
         <?php
         if(!empty($results)) {
           $cur=1;
           $itemcount=1;
           foreach($results as $item) {
             $url="itemedit.php?".urlencode(base64_encode("itemid=".$item['itemid']));
               if($itemcount === 1) {
                   $pagestyle = $cur == 1 ? "" : "display:none"; ?>
                 <div id="page<?php echo $cur ?>" class="row itemlist" style="<?php echo $pagestyle ?>">
             <?php  }  ?>
                      <input type="hidden" name="user" value="<?php echo $item['postedby']?>" >
                     <div id="itmimg" class="col-md-4">
                       <div class="card"><div id="tag"><div class="<?php echo $item['sellorbuy']=='For Sale'? 'bg-success' : 'bg-danger'; ?>" id="price">
                         <span><?php echo $item['sellorbuy'] ?></span>
                         </div></div>
                         <a href=<?php echo $url ?> target="_blank" >
                           <img class="img-fluid itemimage" src="<?php echo $item["imagepath"] ?>" alt="<?php echo $item["imagename"] ?>"></a>
                         <div class="card-body">
                           <div class="itemdtl">
                             <input type="hidden" name="itemid" value=<?php echo $item['itemid'] ?> />
                             <input type="hidden" name="itemname" value=<?php echo $item['itemname'] ?> />
                             <h2 class="title-small"><a href=<?php echo $url ?> ><strong> <?php echo $item["itemname"] ?></strong></a></h2>
                             <h2 class="title-small"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; <?php echo $item["contactperson"] ?> @ <?php echo $item["contactno"] ?></h2>
                             <p class="card-text text-center"><i class="fa fa-map-marker"></i><small class="text-time"><em><?php echo $item["address2"] ?></em></small></p>
                           </div>
                         </div>
                       </div>
                     </div>
               <?php if(($itemcount == $itemsperpage) && ($rowcount != $itemsperpage)) {
                       $cur++;
                       $itemcount = 0;
                 ?>
               </div><br />
               <?php }
           $itemcount++;
         } ?>
         <input type="hidden" id="curpage" value="1" />
         <input type="hidden" id="numpages" value="<?php echo $pages; ?>" />
         <?php } else {
         ?>
         <div class="alert alert-danger" style="width:100%">
             <p>Search did not return any items!</p>
         </div>
   <?php } ?>
 </div>
 <?php
 if(!empty($results)) { ?>
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
<?php } ?>
</div>
</div>
<script type="text/javascript">
   function popup(url)
   {
     //set the width and height of the
     //pop up window in pixels
     var width =  1000;
     var height = 500;
     //Get the TOP coordinate by
     //getting the 50% of the screen height minus
     //the 50% of the pop up window height
     var top = parseInt((screen.availHeight/2) - (height/2));

     //Get the LEFT coordinate by
     //getting the 50% of the screen width minus
     //the 50% of the pop up window width
     var left = parseInt((screen.availWidth/2) - (width/2));

     //Open the window with the
     //file to show on the pop up window
     //title of the pop up
     //and other parameter where we will use the
     //values of the variables above
     window.open(url,
           "Item Detail",
           "menubar=no,resizable=no,width=1000,height=500,scrollbars=yes,left="
           + left + ",top=" + top + ",screenX=" + left + ",screenY=" + top);
    return false;
   }

</script>
<?php
if(!empty($results)) { ?>
</div>
<?php } ?>
