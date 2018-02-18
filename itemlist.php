<?php
if($link = OpenCon()) {
  $query ="SELECT * FROM item itm inner join images img on itm.itemid = img.itemid
where img.imageid = (select max(img1.imageid) from images img1 where img1.itemid = itm.itemid)";
  if(!empty($_POST)){
    if(array_key_exists('location', $_POST)) {
      $query = $query . " and itm.city like '%" . $_POST['location'] ."%'";
    }
    if(array_key_exists('itemsearch', $_POST)) {
      $query = $query . " and itm.itemname like '%" . $_POST['itemsearch'] ."%'";
    }
  }
  $results = runQuery($link,$query);
  CloseCon($link);
}

?>
 <div class="col-md-12">
   	<div class="jumbotron content col-lg-10 col-md-10 col-sm-10">
   		<form method="post" action="home.php?action=search" role="search">
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
    <div class="row">
      <?php
      if(!empty($results)) {
        foreach($results as $item) {
      ?>
        <div class="col-md-3">
          <div class="card"> <img class="img-fluid itemimage" src="<?php echo $item["imagepath"] ?>" alt="<?php echo $item["imagename"] ?>">
            <div class="card-body">
              <div class="news-title">
                <h2 class="title-small"><a href="#"><strong><?php echo $item["itemname"] ?></strong></a></h2>
                <h2 class="title-small"><?php echo $item["itemdesc"] ?></h2>
                <h2 class="title-small"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; <?php echo $item["contactperson"] ?> @ <?php echo $item["contactno"] ?></h2>
              </div>
              <p class="card-text"><i class="fa fa-map-marker"></i><small class="text-time"><em><?php echo $item["city"] ?></em></small></p>
            </div>
          </div>
        </div>
      <?php
        }
      } else {
      ?>
      <div class="alert alert-danger" style="width:100%">
          <p>Search did not return any items!</p>
      </div>
    <?php } ?>
  </div>

 </div>
