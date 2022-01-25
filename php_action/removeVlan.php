<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$brandId = $_POST['brandId'];
$brandName = $_POST['brandName'];

if($brandId) { 

 $sql = "UPDATE vlan_list SET vlan_status = 2 WHERE brand_id = {$brandId}";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Successfully Removed";
	passthru("expect deleteVlan.exp 10.10.0.245 netops P@55w0rd $brandName 0.0.0.0 2>&1");
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the brand";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST
