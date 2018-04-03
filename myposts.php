<?php
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
  }

  $results = runQuery($link,$query);
  $rowcount = getRowCount($link, $query);
  $itemsperpage = 20;
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
 <div class="col-md-12">
   	<div class="jumbotron content col-lg-10 col-md-10 col-sm-10">
   		<form class="searchItemForm" method="post" action="home.php?action=myposts" role="search">
   			<div class="form-group-sm">
   				<div class="input-group">
   					<input type="text" name="location" class="form-control form-element" placeholder="Search Location">
   					<input type="text" name="itemsearch" class="form-control form-element" placeholder="Search Item">
   					<span class="input-group-btn">
   						<button class="btn btn-success btn-sm form-element" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Go!</button>
   					</span>
   				</div>
   			</div>
   		</form>
   </div>
  <div class="col-lg-10 col-md-10 col-sm-10">
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
 </div>
