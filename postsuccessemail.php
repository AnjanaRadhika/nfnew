<?php
$hosturl = "neighbourhoodfarmerstest-com.stackstaging.com/nfnew";
$toemail = $name = $ref = $itemid = "";
if(array_key_exists('toemail', $_GET) && array_key_exists('name', $_GET) && array_key_exists('ref', $_GET) && array_key_exists('itemid', $_GET)) {
  $toemail = $_GET['toemail'];
  $name = $_GET['name'];
  $ref = $_GET['ref'];
  $itemid = $_GET['itemid'];
  // Set content-type header for sending HTML email
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

  $headers .= "From: anjana.rajeevv@gmail.com" . "\\r\
  " . "Reply-to: rajeevvasudevan@outlook.com";

  $message = "<div class='container' style='background:whitesmoke'><br>Hello <strong>{$name}</strong>,<br><br> Item has been posted in NeighbourhoodFarmer's,
      the reference no is {$ref}. Please click on the below link or copy and paste the address onto your web browser's address window.
      if you want to edit the Item post.<br><br>".
      "<a href='http://".$hosturl."/itemedit.php?".urlencode(base64_encode("itemid=".$itemid))
    ."'>http://".$hosturl."/itemedit.php?".urlencode(base64_encode("itemid=".$itemid))
    ."</a><br><br>Thanks & Regards,<br>support@NeighbourhoodFarmers.com </div>";

  $subject = "Item <{$ref}> is posted successfully";

  $to = $toemail; // you should run that through a cleaning function or clean it some how

  $sent=mail($to,$subject,$message,$headers);
}
echo('email sent'.$toemail);
 ?>
