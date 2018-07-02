<?php
include('db_connection.php');
if($link = OpenCon()) {
  if(!empty($_POST["district_id"])) {
  	$query ="SELECT * FROM localities WHERE districtid = '" . $_POST["district_id"]."'";
  	$results = runQuery($link,$query);
  ?>
  	<option value="">Select Neighbourhood</option>
  <?php
  	foreach($results as $locality) {
  ?>
  	<option value="<?php echo $locality["localityid"]; ?>"><?php echo $locality["localityname"]; ?></option>
  <?php
  	}
  }
  CloseCon($link);
}
?>
