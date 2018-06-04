<?php
include('db_connection.php');
$query="";
if($link = OpenCon()) {
  if(isset($_POST)) {
    if(array_key_exists('categories', $_POST)) {
      if($_POST['categories'] !== "") {
        $query = "DELETE FROM `itemcategory` WHERE categoryid in (" . mysqli_real_escape_string($link, $_POST['categories']) . ")";
        $query1 = "SELECT * FROM `item` WHERE categoryid in (" . mysqli_real_escape_string($link, $_POST['categories']) . ")";
      }
    } else if(array_key_exists('newUom', $_POST)) {
      if($_POST['newUom'] !== "") {
        $query = "DELETE FROM `measurements` WHERE measurementid in (" . mysqli_real_escape_string($link, $_POST['categories']) . ")";
        $query1 = "SELECT * FROM `item` WHERE measurementid in (" . mysqli_real_escape_string($link, $_POST['categories']) . ")";
      }
    }
    if(getRowCount($link, $query1) == 0) {
      if(runQuery($link, $query)) {
        $html = "<p class='alert alert-success'>
          Value(s) removed successfully!
        </p>";
      } else {
        $html = "<p class='alert alert-danger'>
          Failed to remove. Please try again later!
        </p>";
      }
    } else {
        $html = "<p class='alert alert-danger'>
          Value cannot be removed as it is already used in items table!
        </p>";
    }
  } else {
    $html = "<p>
    Please enter the Value to be removed.
    </p>";
  }
  CloseCon($link);
}
echo $html;
?>
