<?php
    include('db_connection.php');
    $statusupdate = "";
    if(!empty($_POST)) {
      if(array_key_exists('itemid', $_POST)){
        $itemid = $_POST['itemid'];
      }
      if(array_key_exists('itemdesc', $_POST)){
        $itemdesc = $_POST['itemdesc'];
      }
      if(array_key_exists('quantity', $_POST)){
        $quantity = $_POST['quantity'];
      }
      if(array_key_exists('measurements', $_POST)){
        $measurements = $_POST['measurements'];
      }
      if(array_key_exists('sellorbuy', $_POST)){
        $sellorbuy = $_POST['sellorbuy'];
      }
      if(array_key_exists('contact_person', $_POST)){
        $contact_person = $_POST['contact_person'];
      }
      if(array_key_exists('phone', $_POST)){
        $phone = $_POST['phone'];
      }
      if(array_key_exists('amount', $_POST)){
        $amount = $_POST['amount'];
      }
      if(array_key_exists('effectivedate', $_POST)){
        $effectivedate = $_POST['effectivedate'];
      }
      if(array_key_exists('expirydate', $_POST)){
        $expirydate = $_POST['expirydate'];
      }
      if(array_key_exists('hno', $_POST)){
        $hno = $_POST['hno'];
      }
      if(array_key_exists('hname', $_POST)){
        $hname = $_POST['hname'];
      }
      if(array_key_exists('bno', $_POST)){
        $bno = $_POST['bno'];
      }
      if(array_key_exists('bname', $_POST)){
        $bname = $_POST['bname'];
      }
      if(array_key_exists('street', $_POST)){
        $street = $_POST['street'];
      }
      if(array_key_exists('address1', $_POST)){
        $address1 = $_POST['address1'];
      }
      if(array_key_exists('town', $_POST)){
        $town = $_POST['town'];
      }
      if(array_key_exists('nhood', $_POST)){
        $nhood = $_POST['nhood'];
      }
      if(array_key_exists('zipcode', $_POST)){
        $zipcode = $_POST['zipcode'];
      }
      if(array_key_exists('itemstatus', $_POST)){
        $itemstatus = $_POST['itemstatus'];
      }

      if($link = OpenCon()) {
        $query = "Update item set "
        .  "itemdesc = '".$itemdesc. "', "
        .  "quantity = '".$quantity. "', "
        .  "measurementid = ".$measurements. ", "
        .  "sellorbuy = '".$sellorbuy. "', "
        .  "contactperson = '".$contact_person. "', "
        .  "contactno = '".$phone. "', "
        .  "pricerange = '".$amount. "', "
        .  "effectivedate = '".$effectivedate. "', "
        .  "expirydate = '".$expirydate. "', "
        .  "houseno = '".$hno. "', "
        .  "housename = '".$hname. "', "
        .  "bldgno = '".$bno. "', "
        .  "bldgname = '".$bname. "', "
        .  "address2 = '".$street. "', "
        .  "address1 = '".$address1. "', "
        .  "town = '".$town. "', "
        .  "nhood = '".$nhood. "', "
        .  "zipcode = '".$zipcode. "', "
        . "status = '".$itemstatus."' where itemid = '".$itemid."'";

        $statusmsg = ($itemstatus==='Remove Ad')?'Advertisement removed from listing successfully':(($itemstatus==='Sold')?'Item is sold':"Data updated successfully!");
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
    if($link = OpenCon()) {
      $query ="SELECT * FROM item itm where itm.itemid =" .$itemid;
      $results = runQuery($link,$query);
      $query ="SELECT * FROM images img where img.itemid =" .$itemid;
      $results1 = runQuery($link,$query);
      $query ="SELECT * FROM itemstatus";
      $results2 = runQuery($link,$query);
      $query ="SELECT * FROM measurements";
      $results3 = runQuery($link,$query);
      $query ="SELECT * FROM itemstatus";
      $results4 = runQuery($link,$query);
      CloseCon($link);
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
  <link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="css/bootstrap-datepicker3.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>

  <body data-spy="scroll" data-target="#navbar" data-offset="150">
    <!--Header -->
		<nav class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<a class="navbar-left">
						<img style="max-width:7%;" src="images/logo.ico">
					</a>
					<a id="head" class="navbar-brand" rel="home" href="#">
						NeighbourhoodFarmers.com
					</a>
				</div>
			</div>
		</nav>
		<br /><br /><br />
<section class="container">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div>
        <?php echo $statusupdate; ?>
    </div>
    <div class="card">
  			<div class="content-box">
  				<div class="wrapper row">
  					<div class="col-md-5" id="itemedit"  style="text-align:center">
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
          </div><br />
          <div class="wrapper row">
  					<div id="itemeditdetails" class="details col-md-8">
              <div>
                <?php echo $statusupdate; ?>
              </div>
            <?php
              if(!empty($results)) {
                foreach($results as $item) {
                ?>
                <div>
                    <form id="itemeditform" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
                        <input name="itemid" type="hidden" value="<?php echo $item['itemid']?>"  />
            						<h3><?php echo $item['itemname'];?></h3>
            						<p> <?php echo "Item Code #". $item['itemcode'] ?><br />
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label for="itemdesc">Item Description</label>
                                <textarea class="form-control" name="itemdesc" id="itemdesc" placeholder="Item Description"><?php echo $item['itemdesc']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-8">
                                <label for="quantity">Quantity *</label>
                                <div class="input-group">
                                <input type="Number" class="form-control  col-md-4" name="quantity" id="quantity" value="<?php echo $item['quantity']?>" required>
                                <!--<div class="invalid-feedback col-md-4">
                                  Please enter the quantity
                                </div>-->
                                <input type="hidden" id="measurements" name="measurements" value="<?php echo $item["measurementid"];?>" />
                                <select form="itemeditform" id="measurements-list" class="form-control  custom-select col-md-4" onChange="$('#measurements').val($('#measurements-list').val());" required>
                                    <option value="">Select Unit</option>
                                    <?php
                                    foreach($results3 as $measurements) {
                                      $strselected = $measurements["measurementid"] == $item["measurementid"]?"selected":"";
                                    ?>
                                    <option value="<?php echo $measurements["measurementid"]; ?>" <?php echo $strselected;?> >
                                      <?php echo $measurements["measurementname"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <input type="hidden" id="sellorbuy" name="sellorbuy" value="<?php echo $item["sellorbuy"];?>" />
                      					<select  form="itemeditform" id="sellorbuy-list" class="form-control  custom-select col-md-3" onChange="$('#sellorbuy').val($('#sellorbuy-list').val());">
                                  <?php
                                    $strselected1 = $item["sellorbuy"] == "For Sale"?"selected":"";
                                    $strselected2 = $item["sellorbuy"] == "To Buy"?"selected":"";
                                  ?>
                      						<option value="For Sale" <?php echo $strselected1;?> > For Sale</option>
                      						<option value="To Buy" <?php echo $strselected2;?> > To Buy</option>
                      					</select>
                                </div>
                              </div>
                              <div class="form-group col-md-4">
                                    <label for="itemstatus">Item Status </label>
                                    <div class="input-group">
                                        <input name="itemstatus" id="itemstatus" type="hidden" value=""  />
                                        <select id="status-list" class="form-control form-element custom-select" onChange="$('#itemstatus').val($('#status-list').val());">
                                          <option value="">Select Status</option>
                                          <?php
                                          foreach($results4 as $status) {
                                          ?>
                                          <option value="<?php echo $status["statusdesc"]; ?>"><?php echo $status["statusdesc"]; ?></option>
                                          <?php
                                          }
                                          ?>
                                        </select>
                                    </div>
                              </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-8">
                            <label for="contact_person">Contact Person *</label>
                            <input type="text" class="form-control " name="contact_person" id="contact_person" placeholder="Contact Person" value="<?php echo $item['contactperson'];?>" required>

                          </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                               <label>Phone *</label>
                               <input type="hidden" id="phone" name="phone" value="<?php echo $item['contactno'];?>" />
                               <div class="input-group" onKeyUp="$('#phone').val($('#tel1').val() + $('#tel2').val() + $('#tel3').val())">
                                       <input type="tel" id="tel1" class="form-control" value="<?php echo substr($item['contactno'],0,3);?>" size="3" maxlength="3" required="required" >-
                                       <input type="tel" id="tel2" class="form-control" value="<?php echo substr($item['contactno'],3,3);?>" size="3" maxlength="3" required="required" >-
                                       <input type="tel" id="tel3" class="form-control" value="<?php echo substr($item['contactno'],6,4);?>" size="4" maxlength="4" required="required" >
                                       <div class="invalid-feedback">
                                         The phone number needs to be verified.
                                       </div>
                                       <div class="valid-feedback">
                                         Number Verified!
                                       </div>
                                       &nbsp;
                                       <span class="input-group-btn">
                                         <button id="showdiv" class="btn btn-success" data-toggle="modal" data-target="#verifydiv"><i class="fa fa-phone" aria-hidden="true"></i> Verify Phone</button>
                                       </span>
                               </div>
                            </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="amount">Price Range (&#8377):</label>
                          <input type="hidden" name="amount" id="amount" value="<?php echo $item['pricerange']; ?>">
                          <div class="input-group">
                            <select id="pricerange-list" class="form-control  custom-select" onChange="$('#amount').val($('#pricerange-list').val());">
                                <?php
                                  $strselected1 = $item["pricerange"] == "0 - 100"?"selected":"";
                                  $strselected2 = $item["pricerange"] == "100 - 250"?"selected":"";
                                  $strselected3 = $item["pricerange"] == "250 - 500"?"selected":"";
                                  $strselected4 = $item["pricerange"] == "> 500"?"selected":"";
                                ?>
                                <option value="">Select Price Range </option>
                                <option value="0 - 100" <?php echo $strselected1;?> >0 - 100</option>
                                <option value="100 - 250" <?php echo $strselected2;?> >100 - 250</option>
                                <option value="250 - 500" <?php echo $strselected3;?> >250 - 500</option>
                                <option value="> 500" <?php echo $strselected4;?> >> 500</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="effectivedate">Effective Date</label>
                          <div class="input-group">
                            <input type="text" class="form-control" name="effectivedate" id="effectivedate" value="<?php echo date_format(date_create($item['effectivedate']), 'Y-m-d');?>" />
                            <div class="input-group-addon dateicon"><span id="cal1"><i class="fa fa-calendar"></i></span>&nbsp;</div>
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="expirydate">Expiry Date *</label>
                          <div class="input-group">
                            <input type="text" class="form-control" name="expirydate" id="expirydate" value="<?php echo date_format(date_create($item['expirydate']), 'Y-m-d');?>" required />
                            <div class="input-group-addon dateicon"><span id="cal"><i class="fa fa-calendar"></i></span>&nbsp;</div>
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="hno">Flat No/Door No/House No </label>
                          <input type="text" class="form-control " name="hno" id="hno" placeholder="Flat No/Door No/House No" value="<?php echo $item['houseno'];?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="hname">Flat/Villa/House Name </label>
                          <input type="text" class="form-control " name="hname" id="hname" placeholder="Flat/Villa/House Name" value="<?php echo $item['housename'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="bname">Building Number </label>
                          <input type="text" class="form-control " name="bno" id="bno" placeholder="Building Numbere" value="<?php echo $item['bldgno'];?>">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="bname">Building Name </label>
                          <input type="text" class="form-control " name="bname" id="bname" placeholder="Building Name" value="<?php echo $item['bldgname'];?>">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="street">Street </label>
                          <input type="text" class="form-control " name="street" id="street" placeholder="Street" value="<?php echo $item['address2'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <input type="text" class="form-control " name="address1" placeholder="Address" value="<?php echo $item['address1'];?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="town">Town / Village * </label>
                          <input type="text" class="form-control ui-autocomplete-input" name="town" id="town" placeholder="Town / Village" autocomplete="off" value="<?php echo $item['town'];?>" required>
                          <div class="invalid-feedback col-md-6">
                            Please enter the Town / Village.
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="nhood">Neighbourhood </label>
                          <input type="text" class="form-control ui-autocomplete-input" name="nhood" id="nhood" placeholder="Neighbourhood" autocomplete="off" value="<?php echo $item['nhood'];?>">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="zipcode">Zipcode *</label>
                          <input type="Number" class="form-control ui-autocomplete-input" name="zipcode" id="zipcode" placeholder="Zipcode" autocomplete="off" value="<?php echo $item['zipcode'];?>" required>
                          <div class="invalid-feedback col-md-6">
                            Please enter the zipcode.
                          </div>
                        </div>
                      </div>
                      <h6><?php echo getDistrict($item['districtid'])." ".getState($item['stateid']);?></h6>  <br /><br />
                      <button class="btn btn-success button-submit form-element" type="submit">Update</button>
                    </form>
              </div>
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
      <!-- Verify Phone Number -->
      <div id="verifydiv" class="modal modal-open fade" tabindex="-1" role="dialog" aria-labelledby="msgdiv" aria-hidden="true">
        <div class="modal-dialog popup" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title">
                Verify Mobile
              </h2>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">X</span>
              </button>
            </div>
            <div class="modal-body">
              <form name="verifymodal" id="verifymodal" class="centered" action="getverificationcode.php">
                <div class="form-group col-md-12">
                  <div id="msgsuccess">

                  </div>
                  <input type="hidden" id="hdnmobno" name="mob_number" value="" />
                  <label for="code">Enter the 6 digit OTP send to <span id="verifyphone"></span> </label>
                  <input type="tel" class="form-control" name="code" id="code" maxlength="6" placeholder="Enter OTP Code" required>
                  <div class="invalid-feedback col-md-12">
                    Verification failed!
                  </div>
                </div>
                <div align="center">
                  <input id="btnvalidate" type="button" class="btn cancel" value="Validate"/><br /><br />
                  <strong><a id="resendotp" href="#">Resend One-Time Password</a></strong><br />
                  Entered a wrong number?
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- End Modal -->
    </div>
</section>
<br /><br /><br />
  <!-- Footer -->
  <?php include('footer.php'); ?>
  <!-- Terms & Policy -->
	<?php include('termsofuse.php'); ?>

  <script src="js/jquery.min.js"></script>
	<script src="js/tether.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.knob.js"></script>

	<!-- jQuery File Upload Dependencies -->
	<script src="js/jquery.ui.widget.js"></script>
	<script src="js/jquery.iframe-transport.js"></script>
	<script src="js/jquery.fileupload.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
  <script type="text/javascript">
          $('#datetimepicker1').datepicker();
  </script>
</body>

</html>
