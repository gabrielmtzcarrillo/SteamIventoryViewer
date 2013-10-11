<?php
include("../../inc/session.php");
include('../../lib/steam_L1.php');
if(isset($_SESSION['T2SteamAuth'])){
	echo json_encode(open_profile($_SESSION['T2SteamID64']));
}
?>