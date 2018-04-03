<?php
include('db_connection.php');
$query="";
if($link = OpenCon()) {
  if(isset($_POST)) {
    if(array_key_exists('newcategory', $_POST)) {
      if($_POST['newcategory'] !== "") {
        $query = "INSERT INTO `itemcategory`(`categoryname`, `categorydesc`)
              VALUES('". mysqli_real_escape_string($link, $_POST['newcategory']) ."','"
              . mysqli_real_escape_string($link, $_POST['newcategory']) ."')";
      }
    } else if(array_key_exists('newUom', $_POST)) {
        if($_POST['newUom'] !== "") {
          $query = "INSERT INTO `measurements`(`measurementname`, `measurementdesc`)
                VALUES('". mysqli_real_escape_string($link, $_POST['newUom']) ."','"
                . mysqli_real_escape_string($link, $_POST['newUom']) ."')";
        }
    }
    if(mysqli_query($link, $query)) {
      $html = "<p class='alert alert-success'>
        Value added successfully!
      </p>";
    } else {
      $html = "<p class='alert alert-danger'>
        Failed to add. Please try again later!
      </p>";
    }
  } else {
    $html = "<p>
    Please enter the Value to be entered newly.
    </p>";
  }
  CloseCon($link);
}
echo $html;
?>
