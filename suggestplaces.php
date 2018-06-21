<?php
include('db_connection.php');
/* prevent direct access to this page */
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
  $user_error = 'Access denied - direct call is not allowed...';
  trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if($link = OpenCon()) {

  /* retrieve the search term that autocomplete sends */
  //print_r($_GET);

  if (isset($_REQUEST['term']) ) {
    $term = trim(strip_tags($_GET['term']));
  }

  /* replace multiple spaces with one */
  $term = preg_replace('/\s+/', ' ', $term);

  $a_json = array();

  $a_json_invalid = array(array("id" => "#", "value" => $term, "label" => "Only letters and digits are permitted..."));
  $json_invalid = json_encode($a_json_invalid);

  /* SECURITY HOLE *************************************************************** */
  /* allow space, any unicode letter and digit, underscore and dash                */
  if(preg_match("/[^\040\pL\pN_-]/u", $term)) {
    print $json_invalid;
    exit;
  }
  /* ***************************************************************************** */
    	$query ="SELECT districtname as placename FROM districts";

      if(!empty($term)) {
  	       $query = $query. " where districtname like '" . $term . "%' union";
           $query = $query. " select townname as placename from towns ";
           $query = $query. " where townname like '" . $term . "%' union";
           $query = $query. " select localityname as placename from localities ";
           $query = $query. " where localityname like '" . $term . "%'";
      }

      $query = $query . " limit 0, 10";

  	$results = runQuery($link,$query);
    $x=0;
  	foreach($results as $place) {
      $placename = $place['placename'];
  		$a_json[$x] =$placename;
      $x++;
  	}
    /* jQuery wants JSON data */
  echo(json_encode($a_json));
  flush();

  CloseCon($link);
}
?>
