<?php
include('db_connection.php');
if($link = OpenCon()) {
  if(!empty($_POST["district_id"])) {
  	$query ="SELECT * FROM towns WHERE districtid = '" . $_POST["district_id"]."'";
  	$results = runQuery($link,$query);
  ?>
  	<option value="">Select Town</option>
  <?php
  	foreach($results as $town) {
  ?>
  	<option value="<?php echo $town["townid"]; ?>"><?php echo $town["townname"]; ?></option>
  <?php
  	}
  }
  CloseCon($link);
}
?>
