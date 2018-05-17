<?php
include('db_connection.php');
if($link = OpenCon()) {
  if(!empty($_POST["districtname"])) {
  	$query ="SELECT distinct taluk FROM pincodes WHERE districtname = '" . $_POST["districtname"]."'";
  	$results = runQuery($link,$query);
  ?>
  	<option value="">Select District</option>
  <?php
  	foreach($results as $town) {
  ?>
  	<option value="<?php echo $town["taluk"]; ?>"><?php echo $town["taluk"]; ?></option>
  <?php
  	}
  }
  CloseCon($link);
}
?>
