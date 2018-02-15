<?php
include('db_connection.php');
if($link = OpenCon()) {
  if(!empty($_POST["country_id"])) {
  	$query ="SELECT * FROM states WHERE countryid = '" . $_POST["country_id"] . "'";
  	$results = runQuery($link,$query);
  ?>
  	<option value="">Select State</option>
  <?php
  	foreach($results as $state) {
  ?>
  	<option value="<?php echo $state["stateid"]; ?>"><?php echo $state["statename"]; ?></option>
  <?php
  	}
  }
  CloseCon($link);
}
?>
