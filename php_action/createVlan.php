<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$brandName = $_POST['brandName'];
	$brandIp = $_POST['brandIp'];
	$brandStatus = $_POST['brandStatus'];
        if (filter_var($brandIp, FILTER_VALIDATE_IP)) { 
	$sql = "SELECT * FROM vlan_list WHERE vlan_name = $brandName";
	$result = $connect->query($sql);
	
	if($result->num_rows > 0) { 
		$valid['success'] = false;
		$valid['messages'] = "Error vlan ID already exist";
	} else {
		$sql = "INSERT INTO vlan_list (vlan_name, vlan_ip, vlan_active, vlan_status) VALUES ('$brandName', '$brandIp', '$brandStatus', 1)";
		if($connect->query($sql) === TRUE) {
			$valid['success'] = true;
			$valid['messages'] = "Successfully Added";	
			// ansible-doc -M library/ comware_vlan
			// Uername used to login to the switch
			// Password used to login to the switch
			// IP Address or hostname of the Comware v7 device that has NETCONF enabled
			    if ($brandStatus == 1) {
                    passthru("expect createVlan.exp 10.10.0.245 netops P@55w0rd $brandName $brandIp 2>&1");
                } else {
			        passthru("expect deleteVlan.exp 10.10.0.245 netops P@55w0rd $brandName $brandIp 2>&1"); 
                }
		} else {
			$valid['success'] = false;
			$valid['messages'] = "Error while adding the id vlan";
		}
	}

	$connect->close();
        

	echo json_encode($valid);
        } else {
          $valid['success'] = false;
          $valid['messages'] = "Error ip";
          echo json_encode($valid);
       }
} // /if $_POST
