<?php
$return = [];
if(!empty($_POST)){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];


    $headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		$headers .= "From: ". $email . "\\r\
		" . "Reply-to: ". $email;

		//$to = 'admin@neighbourhoodfarmers.com';
    $to = 'support@neighbourhoodfarmers.com';
    $message = $message. '<p>
    Please contact me at +91'.$phone.'.
    </p><br><br>Thanks & Regards,<br />'.$name;

		$sent=mail($to,$subject,$message,$headers);
		if(!$sent) {
			$mail_sent="Some problem occured. Please try again later!";
      $return[] = array('status' => 'error', 'message' => $mail_sent);
		} else {
			$mail_sent="Message successfully send to Site Admin.";
      $return[] = array('status' => 'success', 'message' => $mail_sent);
		}
}
    echo (json_encode($return));
?>
