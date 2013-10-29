<?php
include('../../lib/steam.php');
if(isset($_GET['id']))
{
	$appid=isset($_GET['appid'])?$_GET['appid']:753;
	$context=isset($_GET['context'])?$_GET['context']:2;
	echo json_encode(open_inventory($_GET['id'],$appid,$context));
}else{
	$bp['sucess'] = false;
	echo json_encode($bp);
}
?>