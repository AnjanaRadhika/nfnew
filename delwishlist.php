<?php
include('db_connection.php');
session_start();
$userid=$username="";
$wishid = isset($_GET['wishid'])?$_GET['wishid']:false;
if(!empty($_SESSION)) {
  if(array_key_exists('id', $_SESSION)) {
    $userid = $_SESSION['id'];
  }
  if(array_key_exists('name', $_SESSION)) {
    $username = $_SESSION['name'];
  }
}

if($wishid){
  if($link = OpenCon()) {
    $query="DELETE FROM `wishlist` where `id`  = ".mysqli_real_escape_string($link, $wishid)."
            and createdby = ". mysqli_real_escape_string($link, $userid) ." LIMIT 1";

        if(mysqli_query($link, $query)) {
          $html = "
            <p class='alert alert-success'>
            Removed from wishlist!
            </p>
          ";
        } else {
          $html = "
            <p class='alert alert-danger'>
            Failed to remove from wishlist. Please try again later.
            </p>
          ";
        }
        CloseCon($link);
      }
    }
echo $html;
 ?>
