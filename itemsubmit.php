<?php
	include('db_connection.php');
	session_start();
	if(array_key_exists('last_activity', $_SESSION) && array_key_exists('expire_time', $_SESSION)) {
		if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) { //have we expired?
		    //redirect to logout.php
				//redirect to logout.php
        session_unset();
        session_destroy();
        header("location:home.php");
        exit();
		} else{ //if we haven't expired:
		    $_SESSION['last_activity'] = time(); //this was the moment of last activity.
		}
	}
	$return = [];

	function getLocation($zip){
	    $arrContextOptions=array(
	      "ssl"=>array(
	      "verify_peer"=>false,
	      "verify_peer_name"=>false
	      )
	    );
	    $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBLm_zpgRTPvuvX2Up-Nva6nTlwAbOmXG4&address=".urlencode($zip)."&sensor=false";
	    $result_string = file_get_contents($url, false, stream_context_create($arrContextOptions));
	    $result = json_decode($result_string, true);
	    $address = $result['results'][0]['formatted_address'];
	    $address = preg_replace('/\d+/', '', $address );
	    $location[0] = $address;
	    $location[1] = $result['results'][0]['geometry']['location'];
	    //return $result['results'][0]['formatted_address'] //Thiruvananthapuram, Kerala 695012, India;
	    return $location;
	}

  if($link = OpenCon()) {
			if(!empty($_SESSION)) {
				if(array_key_exists('id', $_SESSION)) {
					$user=$_SESSION['id'];
				} else {
					$user='Guest';
				}
			} else {
				$user='Guest';
			}

      $itemname = $_POST['item_name'];
      $category = $_POST['category'];
			$categorytext = $_POST['categorytext'];
      $itemdesc = $_POST['itemdesc'];
      $quantity = $_POST['quantity'];
			$sellorbuy = $_POST['sellorbuy'];
			$amount = $_POST['amount'];
      $measurements = $_POST['measurements'];
      $country = '101';
      $state = $_POST['state'];
      $phone = $_POST['phone'];
			$phonevalid = $_POST['phonevalid'];
      $contact_person = $_POST['contact_person'];
      $address1 = $_POST['address1'];
			$address2 = $_POST['address2'];
      $zipcode = $_POST['zipcode'];
			$expirydate = $_POST['expirydate'];
			$effectivedate = $_POST['effectivedate'];
			$contactemail = $_POST['contact_email'];
			$district = $_POST['district'];
			$town = $_POST['town'];
			$nhood = $_POST['nhood'];
			/*$location = getLocation($zipcode);
			$latitude = $location[1]['lat'];
			$longitude = $location[1]['lng'];*/
			$latitude="";
			$longitude="";
			$ret = runQuery($link,"SELECT Auto_increment FROM information_schema.tables WHERE table_schema = DATABASE() and table_name = 'item'");
			foreach($ret as $row) { $item_id=$row['Auto_increment']; }
			$itemcode = strtoupper(substr($categorytext,0,3)).date("Ymd").date("His").$item_id;

      if ($itemname == "") {
          $return[] = array('status' => 'error', 'field' => 'item_name');
      } else {
          $return[] = array('status' => 'success', 'field' => 'item_name');
      }

      if ($category == "") {
          $return[] = array('status' => 'error', 'field' => 'category');
      } else {
          $return[] = array('status' => 'success', 'field' => 'category');
      }

      if ($quantity == "") {
          $return[] = array('status' => 'error', 'field' => 'quantity');
      } else {
          $return[] = array('status' => 'success', 'field' => 'quantity');
      }

      if ($measurements == "") {
          $return[] = array('status' => 'error', 'field' => 'measurements');
      } else {
          $return[] = array('status' => 'success', 'field' => 'measurements');
      }

      if ($country == "") {
          $return[] = array('status' => 'error', 'field' => 'country');
      } else {
          $return[] = array('status' => 'success', 'field' => 'country');
      }

      if ($state == "") {
          $return[] = array('status' => 'error', 'field' => 'state');
      } else {
          $return[] = array('status' => 'success', 'field' => 'state');
      }

      if ($contact_person == "") {
          $return[] = array('status' => 'error', 'field' => 'contact_person');
      } else {
          $return[] = array('status' => 'success', 'field' => 'contact_person');
      }

      if ($district == "") {
          $return[] = array('status' => 'error', 'field' => 'district');
      } else {
          $return[] = array('status' => 'success', 'field' => 'district');
      }

			if ($town == "") {
          $return[] = array('status' => 'error', 'field' => 'town');
      } else {
          $return[] = array('status' => 'success', 'field' => 'town');
      }

      if ($zipcode == "") {
          $return[] = array('status' => 'error', 'field' => 'zipcode');
      } else {
          $return[] = array('status' => 'success', 'field' => 'zipcode');
      }

      if ($phone == "") {
          $return[] = array('status' => 'error', 'field' => 'phone');
      } else {
          $return[] = array('status' => 'success', 'field' => 'phone');
      }

			if ($expirydate == "") {
          $return[] = array('status' => 'error', 'field' => 'expirydate');
      } else {
          $return[] = array('status' => 'success', 'field' => 'expirydate');
      }

			if ($phonevalid == 0) {
          $return[] = array('status' => 'error', 'field' => 'phone');
      } else {
          $return[] = array('status' => 'success', 'field' => 'phone');
      }

			if ($contactemail == "") {
          $return[] = array('status' => 'error', 'field' => 'contact_email');
      } else {
          $return[] = array('status' => 'success', 'field' => 'contact_email');
      }
      // A list of permitted file extensions
      $allowed = array('png', 'jpg', 'jpeg', 'jfif', 'gif','zip');

      $query = "INSERT INTO `item`(`categoryid`,`itemname`, `itemdesc`, `quantity`, `sellorbuy`, "
        . "`pricerange`, `measurementid`, `contactperson`, `contactno`, `address1`, "
				. "`districtid`, `town`, `nhood`, `streetname`, `zipcode`,"
        . "`stateid`, `countryid`, `postedby`, `updatedby`, `expirydate`, `effectivedate`, `longitude`, `latitude`, `itemcode`)"
        . "VALUES(" . mysqli_real_escape_string($link, intval($category)).",'"
				. mysqli_real_escape_string($link, $itemname)."','"
        . mysqli_real_escape_string($link, $itemdesc)."',"
        . mysqli_real_escape_string($link, floatval($quantity)).",'"
				. mysqli_real_escape_string($link, $sellorbuy)."','"
				. mysqli_real_escape_string($link, $amount)."',"
        . mysqli_real_escape_string($link, intval($measurements)).",'"
        . mysqli_real_escape_string($link, $contact_person)."','"
        . mysqli_real_escape_string($link, $phone)."','"
        . mysqli_real_escape_string($link, $address1)."',"
        . mysqli_real_escape_string($link, intval($district)).",'"
        . mysqli_real_escape_string($link, $town)."','"
				. mysqli_real_escape_string($link, $nhood)."','"
				. mysqli_real_escape_string($link, $address2)."','"
        . mysqli_real_escape_string($link, $zipcode)."',"
        . mysqli_real_escape_string($link, intval($state)).","
        . mysqli_real_escape_string($link, intval($country))
				.",'".$user."','".$user."',STR_TO_DATE('"
				. mysqli_real_escape_string($link, $expirydate)."', '%e/%c/%Y'), STR_TO_DATE('"
				. mysqli_real_escape_string($link, $effectivedate)."', '%e/%c/%Y'),'"
				. mysqli_real_escape_string($link, $longitude)."','"
				. mysqli_real_escape_string($link, $latitude)."','"
				. mysqli_real_escape_string($link, $itemcode)."')";

      if(mysqli_query($link, $query) or die(mysqli_error($link))) {
				$lastid = mysqli_insert_id($link);

				if(!empty($_FILES['files'])){
							$files = $_FILES['files'];

							$fcount = count($_FILES['files']['name']);

							for($i=0;$i<$fcount;$i++) {
								if($_FILES['files']['error'][$i] == 0){
					      	$extension = pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION);

					      	if(!in_array(strtolower($extension), $allowed)){
					          $return[] = array('status' => 'error', 'field' => 'imagesextn');
					      	}

					      	if(move_uploaded_file($_FILES['files']['tmp_name'][$i], 'uploads/'.$_FILES['files']['name'][$i])){
										$query = "INSERT INTO `images`(`imagename`, `imagepath`, `itemid`)" .
												"VALUES('".$_FILES['files']['name'][$i]."','uploads/".$_FILES['files']['name'][$i]."',".$lastid.")";
										// echo "<script>console.log('$query');</script>";
										if(mysqli_query($link, $query) or die(mysqli_error($link))) {
					      			$return[] = array('status' => 'success', 'field' => 'dbimages');
					      		} else {
					          	$return[] = array('status' => 'error', 'field' => 'dbimages');
										}
										$return[] = array('status' => 'success', 'field' => 'images');
					        } else {
										$return[] = array('status' => 'error', 'field' => 'images');
									}
								}
							}
	      } else {
					$query = "INSERT INTO `images`(`imagename`, `imagepath`, `itemid`)" .
							"VALUES('No Image','uploads/No_Image_Available.png',".$lastid.")";
					if(mysqli_query($link, $query) or die(mysqli_error($link))) {
						$return[] = array('status' => 'success', 'field' => 'dbimages');
					} else {
						$return[] = array('status' => 'error', 'field' => 'dbimages');
					}
				}
				$return[] = array('status' => 'itemid', 'field' => $item_id);
				$return[] = array('status' => 'itemcode', 'field' => $itemcode);
      } else {
        $return[] = array('status' => 'error', 'field' => 'itemForm');
      }
      CloseCon($link);
  }

  echo (json_encode($return));

 ?>
