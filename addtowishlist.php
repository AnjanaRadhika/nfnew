<!-- Add to Wishlist on clicking on add to favorites in the image item -->
<?php
include('db_connection.php');
session_start();
$userid=$username="";
$itemid = isset($_GET['itemid'])?$_GET['itemid']:false;
if(!empty($_SESSION)) {
  if(array_key_exists('id', $_SESSION)) {
    $userid = $_SESSION['id'];
  }
  if(array_key_exists('name', $_SESSION)) {
    $username = $_SESSION['name'];
  }
}

if($itemid){
  if($link = OpenCon()) {
    $query="SELECT * FROM `item` where `itemid`  = ".mysqli_real_escape_string($link, $itemid)." LIMIT 1";
    $results = runQuery($link,$query);
    if(!empty($results)) {
      foreach($results as $item) {
        $query = "INSERT INTO `wishlist` (`wishdesc`,
                                      `wishdetails`, `itemcategory` , `createdby`, `createdbyname`, `favitemid`, `location`)"
                  . " VALUES ('".mysqli_real_escape_string($link, $item['itemname'])."','"
                  . mysqli_real_escape_string($link, $item['itemdesc'])."',"
                  . mysqli_real_escape_string($link, $item['categoryid']).",'"
                  . mysqli_real_escape_string($link, $userid)."','"
                  . mysqli_real_escape_string($link, $username)."',"
                  . mysqli_real_escape_string($link, $item['itemid']).",'"
                  . mysqli_real_escape_string($link, $item['town'])."')";
        if(mysqli_query($link, $query)) {
          $html = "
            <p class='alert alert-success'>
            Added to Favorites!
            </p>
          ";
        } else {
          $html = "
            <p class='alert alert-danger'>
            Failed to add to Favorites. Please try again later.
            </p>
          ";
        }
      }
    }
    CloseCon($link);
  }
}
echo $html;
 ?>
