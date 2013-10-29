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
	
	<body onLoad="<?php if(isset($_SESSION['T2SteamID64'])) echo "loadProfile('{$_SESSION['T2SteamID64']}')";?>">
		<aside>
			<div id="profile"></div>
			<div class="ribbon" ><font color="white">
				<?php 
				if(isset($_SESSION['T2SteamAuth'])){
					echo '<a class="button" href="?logout">Logout</a><hr>';
					echo '<a class="button" href="#" onClick="loadTF2bp(\''.$_SESSION['T2SteamID64'].'\');">Load TF2 Backpack</a>';
					echo '<a class="button" href="#" onClick="loadInventory(\''.$_SESSION['T2SteamID64'].'\',753,2);">Load Gifts Inventory</a>';
					echo '<a class="button" href="#" onClick="loadInventory(\''.$_SESSION['T2SteamID64'].'\',753,3);">Load Coupons Inventory</a>';
					echo '<a class="button" href="#" onClick="loadInventory(\''.$_SESSION['T2SteamID64'].'\',753,6);">Load Community Inventory</a>';
					echo '<a class="button" href="#" onClick="loadInventory(\''.$_SESSION['T2SteamID64'].'\',570,2);">Load Dota2 Inventory</a>';
					echo '<a class="button" href="#" onClick="loadInventory(\''.$_SESSION['T2SteamID64'].'\',730,2);">Load CS:GO Inventory</a>';
				}else{
					echo $login;
				}
				?>
				<br>NOTE: Larger inventories takes longer to load!
			</font></div>
		</aside>

		<div id="page">
			<div id="backpack" class="centre"></div>
			<footer>
				<b>Images are extracted from the game Team Fortress 2.</b> The copyright for it is held by Valve Corporation, who created the software.<br>
				<b>Powered</b> by <a href="https://developer.valvesoftware.com/wiki/Steam_Web_API">Steam Web API.</a><br>
				<b>Webpage design and programming:</b> <a href="http://steamcommunity.com/profiles/76561198043117800">Gabriel Mtz Carrillo</a><br>
				<b>Steam login, other inventories support added by:</b> <a href="http://steamcommunity.com/id/gamekingz">TheAnthonyNL</a>
			</footer>		
		</div>
	</body>
</html>