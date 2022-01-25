<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$brandName = $_POST['editBrandName'];
	$brandIp = $_POST['editBrandIp'];
	$brandStatus = $_POST['editBrandStatus']; 
	$brandId = $_POST['brandId'];
	$sql = "SELECT * FROM vlan_list WHERE vlan_name = $brandName";
	$result = $connect->query($sql);
	
	if($result->num_rows > 0) { 
		$valid['success'] = false;
		$valid['messages'] = "Error vlan ID already exist";
	} else {
		$sql = "UPDATE vlan_list SET vlan_name = '$brandName', vlan_ip = '$brandIp', vlan_active = '$brandStatus' WHERE brand_id = '$brandId'";

		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = "Successfully Updated";	
			if ($brandStatus == 1) {
	                   passthru("expect createVlan.exp 10.10.0.245 netops P@55w0rd $brandName $brandIp 2>&1");
                        } else {
			   passthru("expect deleteVlan.exp 10.10.0.245 netops P@55w0rd $brandName $brandIp 2>&1");
                        }
		} else {
			$valid['success'] = false;
			$valid['messages'] = "Error while adding the members";
		}
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST
