<?php
 $hosturl = "neighbourhoodfarmerstest-com.stackstaging.com/nfnew";
function OpenCon()
 {
 $dbhost = "shareddb-f.hosting.stackcp.net";
 $dbuser = "farmerdb-32364802";
 $dbpass = "admin123";
 $db = "farmerdb-32364802";


 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);


 return $conn;
 }

function CloseCon($conn)
 {
 $conn -> close();
 }

 function runQuery($link,$query) {
   $result = mysqli_query($link,$query);
   while($row=mysqli_fetch_assoc($result)) {
     $resultset[] = $row;
   }
   if(!empty($resultset))
     return $resultset;
 }

?>
