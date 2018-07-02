<?php
include('db_connection.php');
$query=$type="";
if($link = OpenCon()) {
  $ids = "";
  if(isset($_POST)) {
    if(array_key_exists('delValue', $_POST) && array_key_exists('type', $_POST)) {
      if($_POST['type']!='ClearItem' && $_POST['type']!='ClearFav'){
        $cnt = count($_POST['delValue']);
        foreach($_POST['delValue'] as $val) {
          $ids = $ids . mysqli_real_escape_string($link, $val);
          if($cnt - 1 > 0) {
            $ids = $ids . ", ";
            $cnt = $cnt - 1;
          }
        }
      }

      if($_POST['type'] == "Category") {
        $query = "DELETE FROM `itemcategory` WHERE categoryid in (" . $ids . ")";
        $query1 = "SELECT * FROM `item` WHERE categoryid in (" . $ids . ")";
      } else if($_POST['type'] == "Uom") {
        $query = "DELETE FROM `measurements` WHERE measurementid in (" . $ids . ")";
        $query1 = "SELECT * FROM `item` WHERE measurementid in (" . $ids . ")";
      } else if($_POST['type'] == "State") {
        $query = "DELETE FROM `states` WHERE stateid in  (" . $ids . ")";
        $query1 = "SELECT * FROM `item` WHERE stateid in (" . $ids . ")";
      } else if($_POST['type'] == "ItemStatus") {
        $query = "DELETE FROM `itemstatus` WHERE statusid in  (" . $ids . ")";
        $query1 = "SELECT * FROM `item` WHERE status in (SELECT statusdesc FROM `itemstatus` where statusid in (" . $ids . "))";
      } else if($_POST['type'] == "District") {
        $query = "DELETE FROM `districts` WHERE districtid in  (" . $ids . ")";
        $query1 = "SELECT * FROM `item` WHERE districtid in (" . $ids . ")";
      } else if($_POST['type'] == "Town") {
        $query = "DELETE FROM `towns` WHERE townid in  (" . $ids . ")";
        $query1 = "SELECT * FROM `item` WHERE town in (SELECT townname FROM `towns` where townid in (" . $ids . "))";
      } else if($_POST['type'] == "Neighbourhood") {
        $query = "DELETE FROM `localities` WHERE localityid in  (" . $ids . ")";
        $query1 = "SELECT * FROM `item` WHERE nhood in (SELECT localityname FROM `localities` where localityid in (" . $ids . "))";
      } else if($_POST['type'] == "ClearItem") {
        $type=$_POST['type'];
        $query1 = "SELECT * FROM `item` WHERE expirydate <  STR_TO_DATE('"
        . mysqli_real_escape_string($link, $_POST['delValue']) ."', '%e/%c/%Y')";
        $query = "DELETE FROM `item` WHERE expirydate <  STR_TO_DATE('"
        . mysqli_real_escape_string($link, $_POST['delValue']) ."', '%e/%c/%Y')";
      } else if($_POST['type'] == "ClearFav") {
        $type=$_POST['type'];
        $query1 = "SELECT * FROM `wishlist` WHERE createdon <  STR_TO_DATE('"
        . mysqli_real_escape_string($link, $_POST['delValue']) ."', '%e/%c/%Y')";
        $query = "DELETE FROM `wishlist` WHERE createdon <  STR_TO_DATE('"
        . mysqli_real_escape_string($link, $_POST['delValue']) ."', '%e/%c/%Y')";
      }
    }
    if($type=='ClearItem' || $type=='ClearFav'){
      if(getRowCount($link, $query1) != 0) {
        if(mysqli_query($link, $query)) {
          $html = "<p class='alert alert-success'>
            Item(s) removed successfully!
          </p>";
        } else {
          $html = "<p class='alert alert-danger'>
            Failed to remove. Please try again later! " . mysqli_error($link) . "
          </p>";
        }
      } else {
          $html = "<p class='alert alert-danger'>
            There are no items with expiry date before the mentioned date!
          </p>";
      }
    } else {
          if(getRowCount($link, $query1) == 0) {
            if(mysqli_query($link, $query)) {
              $html = "<p class='alert alert-success'>
                Value(s) removed successfully!
              </p>";
            } else {
              $html = "<p class='alert alert-danger'>
                Failed to remove. Please try again later! " . mysqli_error($link) . "
              </p>";
            }
          } else {
              $html = "<p class='alert alert-danger'>
                Value(s) cannot be removed as it is already used in items table!
              </p>";
          }
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
