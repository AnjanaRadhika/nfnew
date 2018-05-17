<?php
include('db_connection.php');
if($link = OpenCon()) {
  if(!empty($_POST["state_id"])) {
  	$query ="SELECT * FROM districts WHERE stateid = " . $_POST["state_id"];
  	$results = runQuery($link,$query);
  ?>
  	<option value="">Select District</option>
  <?php
  	foreach($results as $district) {
  ?>
  	<option value="<?php echo $district["districtid"]; ?>"><?php echo $district["districtname"]; ?></option>
  <?php
  	}
  }
  CloseCon($link);
}
?>
