<?php
    include('db_connection.php');
    $statusupdate = "";
    if(!empty($_POST)) {
      if(array_key_exists('itemid', $_POST)){
        $itemid = $_POST['itemid'];
      }
      if(array_key_exists('itemstatus', $_POST)){
        $itemstatus = $_POST['itemstatus'];
      }
      if($link = OpenCon()) {
        $query = "Update item set status = '".$itemstatus."' where itemid = '".$itemid."'";
        $statusmsg = ($itemstatus==='Remove Ad')?'Advertisement removed from listing successfully':'Item is sold';
        if(mysqli_query($link, $query)) {
          $statusupdate='<div class="alert alert-success">
							<p>'.$statusmsg.'</p>
							</div>';
        } else {
          $statusupdate='<div class="alert alert-danger">
							<p>Some problem occured. Please try again later!</p>
							</div>';
        }
        CloseCon($link);
      }
    }
    parse_str(urldecode(base64_decode($_SERVER['QUERY_STRING'])),$string);
    if(array_key_exists('itemid', $string)){
        $itemid = $string['itemid'];
    }
    if(array_key_exists('itemname', $string)){
        $itemname = $string['itemname'];
    }
    if($link = OpenCon()) {
      $query ="SELECT * FROM item itm where itm.itemid =" .$itemid;
      $results = runQuery($link,$query);
      $query ="SELECT * FROM images img where img.itemid =" .$itemid;
      $results1 = runQuery($link,$query);
      $query ="SELECT * FROM itemstatus";
      $results2 = runQuery($link,$query);
      CloseCon($link);
    }

  function getUnit($mid) {
    if($link = OpenCon()) {
      $query ="SELECT * FROM measurements";
      $results2 = runQuery($link,$query);
      CloseCon($link);
    }
    foreach($results2 as $measurement){
      if($measurement['measurementid'] === $mid){
        return $measurement['measurementname'];
      }
    }
  }
?>
<!DOCTYPE html>

<html lang="en">

  <head>
    <title>Neighbourhood Farmers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<link href="https://fonts.googleapis.com/css?family=Fira+Sans+Condensed|Russo+One" rel="stylesheet">
	<link rel="shortcut icon" href="images/logo.ico">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>

  <body data-spy="scroll" data-target="#navbar" data-offset="150">
		<!--Header -->
		<br /><br /><br />
<section class="container">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
  			<div class="content-box">
  				<div class="wrapper row">
  					<div class="col-md-5">
              <div id="imagesSlideOnly" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                  <?php
                  if(!empty($results1)) {
                    $i = 1;
                    foreach($results1 as $image) {
                      $item_class = ($i == 1) ? 'carousel-item active' : 'carousel-item';
                  ?>
                  <div class="<?php echo $item_class ?>">
                    <img class="d-block img-fluid carouselimage" src="<?php echo $image["imagepath"] ?>" alt="<?php echo $image["imagename"] ?>">
                  </div>
                  <?php
                      $i++;
                    }
                  } ?>
                </div>
                <a class="carousel-control-prev" href="#imagesSlideOnly" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#imagesSlideOnly" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
  					</div>
  					<div class="details col-md-5">
              <div>
                <?php echo $statusupdate; ?>
              </div>
            <?php
              if(!empty($results)) {
                foreach($results as $item) {
                ?>
  						<h3><?php echo $item['itemname']?></h3>
  						<p><?php echo $item['itemdesc']?></p>

              <h4>quantity available: <span><?php echo $item['quantity']?>&nbsp;<?php echo getUnit($item['measurementid'])?></span></h4>
              <h6>contact person : <span><?php echo $item['contactperson']?> </span></h6>
              <h6>contact number : <span><?php echo $item['contactno']?> </span></h6>
              <h6>address : <span><?php echo $item['address1']?> <br />
              <?php echo $item['address2']?> <br />
              <?php echo $item['city']?>  &nbsp;
              <?php echo $item['zipcode']?>
              <?php echo $item['location']?>
              </span><br />
              </h6>
              <?php
          		if(!empty($_SESSION)) {
          			if(array_key_exists('name', $_SESSION)) {
                    if(($item['status']===NULL) or (is_null($item['status']))) {
              ?>
                <div>
                    <form id="itemdetailform" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?action=detail">
                      <input name="itemid" type="hidden" value="<?php echo $item['itemid']?>"  />
                      <input name="itemstatus" id="itemstatus" type="hidden" value=""  />
                      <input type="hidden" name="amount" id="amount">
                      <select id="status-list" class="form-control form-element custom-select" onChange="$('#itemstatus').val($('#status-list').val());">
                        <option value="">Select Status</option>
                        <?php
                        foreach($results2 as $status) {
                        ?>
                        <option value="<?php echo $status["statusdesc"]; ?>"><?php echo $status["statusdesc"]; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <div class="invalid-feedback">
                        Please choose a status.
                      </div>
                      <br /><br />
                      <select id="pricerange-list" class="form-control  custom-select" onChange="$('#amount').val($('#pricerange-list').val());">
                          <option value="">Select Price Range</option>
                          <option value="">0 - 100</option>
                          <option value="">100 - 250</option>
                          <option value="">250 - 500</option>
                          <option value="">> 500</option>
                      </select>
                      <br /><br />
                      <div class="input-group">
                        <input type="text" class="form-control" name="expirydate" id="expirydate"/>
                        <div class="input-group-addon dateicon"><i class="fa fa-calendar"></i>&nbsp;</div>
                      </div><br /><br />
                      <button class="btn btn-success button-submit form-element" type="submit">Update</button>
                    </form>

              </div>
            <?php } } } ?>
              <!--
  						<p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong></p>
  						<h5 class="sizes">sizes:
  							<span class="size" data-toggle="tooltip" title="small">s</span>
  							<span class="size" data-toggle="tooltip" title="medium">m</span>
  							<span class="size" data-toggle="tooltip" title="large">l</span>
  							<span class="size" data-toggle="tooltip" title="xtra large">xl</span>
  						</h5>
  						<h5 class="colors">colors:
  							<span class="color orange not-available" data-toggle="tooltip" title="Not In store"></span>
  							<span class="color green"></span>
  							<span class="color blue"></span>
  						</h5>
  						<div class="action">
  							<button class="add-to-cart btn btn-default" type="button">add to cart</button>
  							<button class="like btn btn-default" type="button"><span class="fa fa-heart"></span></button>
  						</div> -->
            <?php } } ?>
  					</div>
  				</div>
  			</div>
  		</div>
    </div>
</section>
<br /><br /><br />

<script src="js/jquery.min.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</body>

</html>
