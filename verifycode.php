<?php
session_start();
$OTPSent=$_SESSION['OTPSent'];
if(!empty($_POST["otp_value"])) {
  $OTPValue = $_POST["otp_value"];
}

if ($OTPSent==$OTPValue )
echo "Matched";
else
echo "Not Matched";
session_unset();
session_destroy();
?>
