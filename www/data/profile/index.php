<?php
include("../../lib/steam.php");
if(isset($_GET['id']))
	echo json_encode(open_profile($_GET['id']));
else{
	$profile['sucess'] = false;
	echo json_encode($profile);
}
?>