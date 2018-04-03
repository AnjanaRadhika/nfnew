<?php
include('db_connection.php');
session_start();
$userid=$username="";
if(!empty($_SESSION)) {
  if(array_key_exists('id', $_SESSION)) {
    $userid = $_SESSION['id'];
  }
  if(array_key_exists('name', $_SESSION)) {
    $username = $_SESSION['name'];
  }
}
if(!empty($_POST)){
    $title = $_POST['wishtitle'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    if($link = OpenCon()) {

          $query = "INSERT INTO `wishlist` (`wishdesc`,
                                        `wishdetails`, `itemcategory` , `createdby`, `createdbyname`)"
                    . " VALUES ('".mysqli_real_escape_string($link, $title)."','"
                    . mysqli_real_escape_string($link, $description)."',"
                    . mysqli_real_escape_string($link, $category).",'"
                    . mysqli_real_escape_string($link, $userid)."','"
                    . mysqli_real_escape_string($link, $username)."')";
          if(mysqli_query($link, $query)) {
            $html = "
              <p class='alert alert-success'>
              Added to wishlist!
              </p>
            ";
          } else {
            $html = "
              <p class='alert alert-danger'>
              Failed to add to wishlist. Please try again later.
              </p>
            ";
          }
          CloseCon($link);
    }
}

echo $html;
 ?>
