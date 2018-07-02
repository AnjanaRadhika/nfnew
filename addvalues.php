<!-- Site Maintanence Adding new Category and Measurement -->
<?php
include('db_connection.php');
$query=$type="";
if($link = OpenCon()) {
  if(isset($_POST)) {
    if(array_key_exists('newValue', $_POST) && array_key_exists('type', $_POST)) {
          if($_POST['type'] == "Category") {
            $query = "INSERT INTO `itemcategory`(`categoryname`, `categorydesc`)
                  VALUES('". mysqli_real_escape_string($link, $_POST['newValue']) ."','"
                  . mysqli_real_escape_string($link, $_POST['newValue']) ."')";
          } else if($_POST['type'] == "Uom") {
            $query = "INSERT INTO `measurements`(`measurementname`, `measurementdesc`)
                    VALUES('". mysqli_real_escape_string($link, $_POST['newValue']) ."','"
                    . mysqli_real_escape_string($link, $_POST['newValue']) ."')";
          } else if($_POST['type'] == "State") {
            $query = "INSERT INTO `states`(`statecd`, `statename`, `countryid`)
                  VALUES('IN-" . mysqli_real_escape_string($link, strtoupper(substr($_POST['newValue'], 0, 3))) ."','"
                  . mysqli_real_escape_string($link, $_POST['newValue']) ."', 101)";
          } else if($_POST['type'] == "ItemStatus") {
            $query = "INSERT INTO `itemstatus`(`statusdesc`)
                  VALUES('" . mysqli_real_escape_string($link, $_POST['newValue']) ."')";
          } else if($_POST['type'] == "Policy") {
            $type=$_POST['type'];
            $query = "INSERT INTO `policy`(`updatedate`, `version`) VALUES(STR_TO_DATE('"
    				. mysqli_real_escape_string($link, $_POST['newValue']) ."', '%e/%c/%Y'), '"
              . mysqli_real_escape_string($link, $_POST['newValue1']) ."')";
          } else if($_POST['type'] == 'District') {
              if(array_key_exists('optValue', $_POST) && !empty($_POST['optValue'])) {
                  $query = "INSERT INTO `districts`(`districtname`, `stateid`)
                  VALUES('". mysqli_real_escape_string($link, $_POST['newValue']) ."',"
                  . mysqli_real_escape_string($link, $_POST['optValue']) .")";
              }
          } else if($_POST['type'] == 'Town') {
              if(array_key_exists('optValue1', $_POST) && !empty($_POST['optValue1']) &&
                    array_key_exists('optValue2', $_POST) && !empty($_POST['optValue2'])) {
                  $query = "INSERT INTO `towns`(`townname`, `districtid`, `stateid`)
                  VALUES('". mysqli_real_escape_string($link, $_POST['newValue']) ."',"
                  . mysqli_real_escape_string($link, $_POST['optValue2']) .","
                  . mysqli_real_escape_string($link, $_POST['optValue1']) . ")";
              }
          } else if($_POST['type'] == 'Neighbourhood') {
              if(array_key_exists('optValue1', $_POST) && !empty($_POST['optValue1']) &&
                    array_key_exists('optValue2', $_POST) && !empty($_POST['optValue2'])) {
                  $query = "INSERT INTO `localities`(`localityname`, `pincode`, `districtid`, `stateid`)
                  VALUES('". mysqli_real_escape_string($link, $_POST['newValue']) ."',"
                  . mysqli_real_escape_string($link, $_POST['newValue1']) .","
                  . mysqli_real_escape_string($link, $_POST['optValue2']) .","
                  . mysqli_real_escape_string($link, $_POST['optValue1']) . ")";
              }
          }
    }

    if($type=='Policy') {
        if(mysqli_query($link, $query)) {
          $html = "<p class='alert alert-success'>
            Policy update completed!
          </p>";
        } else {
          $html = "<p class='alert alert-danger'>
            Failed to update policy. Please try again later!
          </p>";
        }
    } else {
        if(mysqli_query($link, $query)) {
          $html = "<p class='alert alert-success'>
            Value added successfully!
          </p>";
        } else {
          $html = "<p class='alert alert-danger'>
            Failed to add. Please try again later!
          </p>";
        }
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
