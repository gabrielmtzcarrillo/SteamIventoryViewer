<?php
include('../../lib/steam.php');
if(isset($_GET['id']))
{
	$appid=isset($_GET['appid'])?$_GET['appid']:753;
	$context=isset($_GET['context'])?$_GET['context']:2;
	
	$raw_inventory = open_inventory($_GET['id'],$appid,$context);
	
	file_put_contents($_GET['id'].'_APP'.$_GET['appid'].'_CONTEXT'.$_GET['context'].'.txt',print_r($raw_inventory,true));
	
	echo json_encode(print_r($raw_inventory));
	
}else{
	$bp['sucess'] = false;
	echo json_encode($bp);
}
?>