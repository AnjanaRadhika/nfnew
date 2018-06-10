<?php
    include('db_connection.php');
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
      $query ="SELECT * FROM measurements where measurementid = ".$mid;
      $results2 = runQuery($link,$query);
      CloseCon($link);
    }
    foreach($results2 as $measurement){
        return $measurement['measurementname'];
    }
  }

  function getDistrict($did) {
    if($link = OpenCon()) {
      $query ="SELECT * FROM districts where districtid = ".$did;
      $results2 = runQuery($link,$query);
      CloseCon($link);
    }
    foreach($results2 as $district){
        return $district['districtname'];
    }
  }

  function getState($sid) {
    if($link = OpenCon()) {
      $query ="SELECT * FROM states where stateid = ".$sid;
      $results2 = runQuery($link,$query);
      CloseCon($link);
    }
    foreach($results2 as $state){
        return $state['statename'];
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
            <?php
              if(!empty($results)) {
                foreach($results as $item) {
                ?>
  						<h3><?php echo $item['itemname'];?></h3>
  						<p> <?php echo "Item Code #". $item['itemcode'] ?><br />
              <?php echo $item['itemdesc'];?></p>

              <h5>quantity available: <span><?php echo $item['quantity'];?>&nbsp;<?php echo getUnit($item['measurementid'])." ".$item['sellorbuy']?></span></h5>
              <h6>contact person : <span><?php echo $item['contactperson'];?> </span></h6>
              <h6>contact number : <span><?php echo $item['contactno'];?> </span></h6>
              <h6>price range (&8377) : <span><?php echo $item['pricerange'];?> </span></h6>
              <h6>available from : <span><?php echo $item['effectivedate'];?> </span><br />
                till : <span><?php echo $item['expirydate'];?> </span></h6>
              <h6>address : <span><?php echo $item['houseno']." ".$item['housename'];?>
              <?php echo $item['bldgno']." ".$item['bldgname'];?>
              <?php echo $item['address1'];?> <br />
              <?php echo $item['address2'];?> <br />
              <?php echo $item['town']." ".$item['nhood'];?>  <br />
              <?php echo getDistrict($item['districtid'])." ".getState($item['stateid']);?>  <br />
              <?php echo $item['zipcode'];?>
              </span><br />
              </h6>
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
