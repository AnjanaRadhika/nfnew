<?php
$phone = "";
if(!empty($_POST["mob_number"])) {
  $phone = $_POST["mob_number"];
}
$ch = curl_init('https://textbelt.com/otp/generate');
$data = array(
  'phone' => $phone,
  'userid' => 'myuser@site.com',
  'key' => 'example_otp_key',
);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);
?>
