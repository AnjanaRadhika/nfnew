<?php
$itemsperpage = 20;
if($link = OpenCon()) {
  $query ="SELECT * FROM item itm inner join images img on itm.itemid = img.itemid
                                  inner join itemcategory ctg on itm.categoryid = ctg.categoryid
where img.imageid = (select max(img1.imageid) from images img1 where img1.itemid = itm.itemid)
and itm.status is null ";
  if(!empty($_SESSION)) {
    if(array_key_exists('id', $_SESSION)) {
      $query = $query." and postedby = '".$_SESSION['id']."'";
    }
  }
  if(!empty($_POST)){
    if(array_key_exists('location', $_POST)) {
      $query = $query . " and ((itm.city like '%" . $_POST['location'] ."%')"
                        . " or (itm.location like '%" . $_POST['location'] ."%'))";
    }
    if(array_key_exists('itemsearch', $_POST)) {
      $query = $query . " and ((itm.itemname like '%" . $_POST['itemsearch'] ."%')"
                          . " or (ctg.categoryname like '%" . $_POST['itemsearch'] ."%'))";
    }
    if(array_key_exists('sellorbuy', $_POST)) {
      if($_POST['sellorbuy'] != 'Both') {
        $query = $query . " and itm.sellorbuy = '" . mysqli_real_escape_string($link,$_POST['sellorbuy']) ."'";
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
 <div class="col-lg-12 col-md-12 col-sm-12">
   <div class="row">
   	<div class="jumbotron content col-lg-9 col-md-9 col-sm-9">
   		<form class="searchItemForm" method="post" action="home.php?action=myposts" role="search">
   			<div class="form-group-sm">
   				<div class="input-group">
   					<input type="text" name="location" class="form-control" placeholder="Search Location">
   					<input type="text" name="itemsearch" class="form-control" placeholder="Search Item">
          </div><br />
          <div class="input-group">
            <input type="hidden" id="sellorbuy" name="sellorbuy" value="Both" />
  					<select id="sellorbuy-list" class="form-control  custom-select col-md-2" onChange="$('#sellorbuy').val($('#sellorbuy-list').val());">
  						<option value="Both"> Select All</option>
  						<option value="For Sale"> For Sale</option>
  						<option value="To Buy"> To Buy</option>
  					</select>
            <input type="hidden" name="itemsperpage" id="itemsperpage" value="20" />
            <select class="form-control  custom-select col-md-3" onChange="$('#itemsperpage').val($(this).val());">
              <option value="20">20 per page </option>
              <option value="40">40 per page </option>
              <option value="60">60 per page </option>
              <option value="80">80 per page </option>
              <option value="100">100 per page </option>
              <option value="<?php echo $rowcount; ?>">All</option>
            </select>
   					<span class="input-group-btn">
   						<button class="btn btn-success" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Go!</button>
   					</span>
          </div>
   				</div>
   		</form>
   </div>
   <div class="releted-content col-md-3">
       <div class="veradv row"><br />
         <p> <br /> ADVERTISE YOUR BUSINESS HERE <br />
           nbfarmercontact1@gmail.com
         </p>

       </div>
     </div>
   </div>
   <div class="row">
    <div class="col-lg-9 col-md-9 col-sm-9">
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
        <?php
        if(!empty($results)) {
          $cur=1;
          $itemcount=1;
          foreach($results as $item) {
            $url="home.php?action=detail".urlencode(base64_encode("&itemid=".$item['itemid']."&itemname=".$item['itemname']));
              if($itemcount === 1) {
                  $pagestyle = $cur == 1 ? "" : "display:none"; ?>
                <div id="page<?php echo $cur ?>" class="row itemlist" style="<?php echo $pagestyle ?>">
            <?php  }  ?>
                    <div class="col-md-3">
                      <div class="card"> <img class="img-fluid itemimage" src="<?php echo $item["imagepath"] ?>" alt="<?php echo $item["imagename"] ?>">
                        <div class="card-body">
                          <div>
                            <input type="hidden" name="itemid" value=<?php echo $item['itemid'] ?> />
                            <input type="hidden" name="itemname" value=<?php $item['itemname'] ?> />
                            <h2 class="title-small"><a href=<?php echo $url ?> ><strong> <?php echo $item["itemname"] ?></strong></a></h2>
                            <h2 class="title-small"><?php echo $item["itemdesc"] ?></h2>
                            <h2 class="title-small"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; <?php echo $item["contactperson"] ?> @ <?php echo $item["contactno"] ?></h2>
                          </div>
                          <p class="card-text"><i class="fa fa-map-marker"></i><small class="text-time"><em><?php echo $item["city"] ?></em></small></p>
                        </div>
                      </div>
                    </div>
              <?php if(($itemcount === $itemsperpage)) {
                      $cur++;
                      $itemcount = 0;
                ?>
                </div>
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
     <?php include('contentadvlist.php'); ?>
 </div>
</div>
