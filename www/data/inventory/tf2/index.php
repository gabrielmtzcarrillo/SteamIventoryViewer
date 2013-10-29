<?php
include('../../../lib/steam.php');
if(isset($_GET['id']))
{
	echo json_encode(open_backpack($_GET['id']));
}else{
	$bp['sucess'] = false;
	echo json_encode($bp);
}
?>