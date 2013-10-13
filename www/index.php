<?php
	include "./inc/session.php";
?>

<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<title>Inventory Viewer</title>
		<link rel="stylesheet" href="css/base.css"/>
		<script type="text/javascript" src="js/core.js"></script>
	</head>
	
	<body onLoad="loadProfile();loadTF2bp();">
		<aside>
			<div id="profile"></div>
			<div class="ribbon" ><font color="white">
				<?php 
				if(isset($_SESSION['T2SteamAuth'])){
					$steamx = json_decode(file_get_contents("../steam/cache/{$_SESSION['T2SteamID64']}.json"));
				
					foreach (($steamx->response->players) as $player)
					{
						$steam = $player->steamid;
					}
					echo "<a class='button' href='?logout'>Logout</a><br>";
					echo $steam;
				}else{
					echo $login;
				}
				?>
				<hr>
				<a class="button" href="#" onClick="loadTF2bp();">Load TF2 Backpack</a>
				<a class="button" href="#" onClick="loadInventory_gifts();">Load Gifts Inventory</a>
				<a class="button" href="#" onClick="loadInventory_coupons();">Load Coupons Inventory</a>
				<a class="button" href="#" onClick="loadInventory_community();">Load Community Inventory</a>				
				<br>NOTE: Larger inventories takes longer to load!
			</font></div>
		</aside>

		<div id="page">
			<div id="backpack"></div>
			<footer>
				<b>Images are extracted from the game Team Fortress 2.</b> The copyright for it is held by Valve Corporation, who created the software.<br>
				<b>Powered</b> by <a href="https://developer.valvesoftware.com/wiki/Steam_Web_API">Steam Web API.</a><br>
				<b>Webpage design and programming:</b> <a href="http://steamcommunity.com/profiles/76561198043117800">Gabriel Mtz Carrillo</a><br>
				<b>Steam login, other inventories support added by:</b> <a href="http://steamcommunity.com/id/gamekingz">TheAnthonyNL</a>
			</footer>		
		</div>
	</body>
</html>