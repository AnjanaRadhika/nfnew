<?php
include('db_connection.php');
if($link = OpenCon()) {
  if(!empty($_POST["locality_id"])) {
  	$query ="SELECT * FROM localities WHERE localityid = '" . $_POST["locality_id"]."'";
  	$results = runQuery($link,$query);
  ?>
  	<option value="">Select Zipcode</option>
  <?php
  	foreach($results as $zip) {
  ?>
  	<option value="<?php echo $zip["pincode"]; ?>"><?php echo $zip["pincode"]; ?></option>
  <?php
  	}
  }
  CloseCon($link);
}
?>
