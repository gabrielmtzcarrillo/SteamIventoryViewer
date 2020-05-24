<?php
include('../../lib/steam.php');
if(isset($_GET['id']))
{
	$appid=isset($_GET['appid'])?$_GET['appid']:753;
	$context=isset($_GET['context'])?$_GET['context']:2;
	
	$raw_inventory = open_inventory($_GET['id'],$appid,$context);
	
	echo json_encode($raw_inventory);
	
}else{
	$bp['sucess'] = false;
	echo json_encode($bp);
}
?>