<?php 	

$localhost = "localhost";
$username = "yourUsername";
$password = "yourPassword";
$dbname = "vlan";
$store_url = "http://127.0.0.1/website/";
// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);
// check connection
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}

?>
