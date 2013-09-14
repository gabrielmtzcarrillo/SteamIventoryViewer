<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<title>Tradebot</title>
		<link rel="stylesheet" href="css/base.css"/>
		<script type="text/javascript" src="js/core.js"></script>
	</head>
	
	<body onLoad="loadProfile();loadTF2bp();">
		<aside>
			<div id="profile"></div>
			<div class="ribbon">
				<a class="button" href="#" onClick="loadTF2bp();">Load TF2 Backpack</a>
				<a class="button" href="#" onClick="loadInventory();">Load Steam Inventory</a>
			</div>
		</aside>

		<div id="page">
			<div id="backpack"></div>
			<footer>
				<b>Images are extracted from the game Team Fortress 2.</b> The copyright for it is held by Valve Corporation, who created the software.<br>
				<b>Powered</b> by <a href="https://developer.valvesoftware.com/wiki/Steam_Web_API">Steam Web API.</a><br>
				<b>Webpage design and programming:</b> <a href="http://steamcommunity.com/profiles/76561198043117800">Gabriel Mtz Carrillo</a><br>
			</footer>		
		</div>
	</body>
</html>