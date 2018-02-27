<?php
	include('db_connection.php');
	session_start();

	$return = [];

	function getLocation($zip){
	    $arrContextOptions=array(
	      "ssl"=>array(
	      "verify_peer"=>false,
	      "verify_peer_name"=>false
	      )
	    );
	    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zip)."&sensor=false";
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
      $itemdesc = $_POST['itemdesc'];
      $quantity = $_POST['quantity'];
			$amount = $_POST['amount'];
      $measurements = $_POST['measurements'];
      $country = $_POST['country'];
      $state = $_POST['state'];
      $phone = $_POST['phone'];
      $contact_person = $_POST['contact_person'];
      $address1 = $_POST['address1'];
      $address2 = $_POST['address2'];
      $city = $_POST['city'];
      $zipcode = $_POST['zipcode'];
			$location = getLocation($zipcode);
			$latitude = $location[1]['lat'];
			$longitude = $location[1]['lng'];

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

      if ($city == "") {
          $return[] = array('status' => 'error', 'field' => 'city');
      } else {
          $return[] = array('status' => 'success', 'field' => 'city');
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

      // A list of permitted file extensions
      $allowed = array('png', 'jpg', 'jpeg', 'jfif', 'gif','zip');

      $query = "INSERT INTO `item`(`categoryid`,`itemname`, `itemdesc`, `quantity`,"."
        `pricerange`, `measurementid`, `contactperson`, `contactno`, `address1`, `address2`, `city`, `zipcode`,"."
        `stateid`, `countryid`, `location`, `postedby`, `updatedby`)"."
        VALUES(" . mysqli_real_escape_string($link, intval($category)).",'"
				. mysqli_real_escape_string($link, $itemname)."','"
        . mysqli_real_escape_string($link, $itemdesc)."',"
        . mysqli_real_escape_string($link, floatval($quantity)).",'"
				. mysqli_real_escape_string($link, $amount)."',"
        . mysqli_real_escape_string($link, intval($measurements)).",'"
        . mysqli_real_escape_string($link, $contact_person)."','"
        . mysqli_real_escape_string($link, $phone)."','"
        . mysqli_real_escape_string($link, $address1)."','"
        . mysqli_real_escape_string($link, $address2)."','"
        . mysqli_real_escape_string($link, $city)."','"
        . mysqli_real_escape_string($link, $zipcode)."',"
        . mysqli_real_escape_string($link, intval($state)).","
        . mysqli_real_escape_string($link, intval($country))
				.",'".$location[0]."','".$user."','".$user."')";


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
        $return[] = array('status' => 'success', 'field' => 'itemForm');
      } else {
        $return[] = array('status' => 'error', 'field' => 'itemForm');
      }
      CloseCon($link);
  }

  echo (json_encode($return));

 ?>
