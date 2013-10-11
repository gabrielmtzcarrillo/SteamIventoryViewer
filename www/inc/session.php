<?php
function get_contents($URL){ 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_URL, $URL); 
    $data = curl_exec($ch); 
    curl_close($ch); 
    return $data;
}
if(!@include("../steam/apikey.php"));
if(!@include("../steam/OpenId.php"));
if(!@include("../../../steam/apikey.php"));
if(!@include("../../../steam/OpenId.php"));
if(!@include("../../../../steam/apikey.php"));
if(!@include("../../../../steam/OpenId.php"));

$OpenID = new LightOpenID("http://www.example.com");
 
    session_start();
	
	$server = $_SERVER['HTTP_HOST'];
	$params = explode('.', $server);

	if(sizeof($params === 3) AND $params[0] == 'www') {
		// www exists   
	}
	else{
		header("Location: http://www.example.com");
	}	
	
	if(isset($_GET['logout'])){
 
        unset($_SESSION['T2SteamAuth']);
        unset($_SESSION['T2SteamID64']);
        header("Location: http://www.example.com");

    }
 
    if(!$OpenID->mode){
 
        if(isset($_GET['login'])){
            $OpenID->identity = "http://steamcommunity.com/openid";
            header("Location: {$OpenID->authUrl()}");
        }
 
        if(!isset($_SESSION['T2SteamAuth'])){
            $login = "<div class='logintext' id=\"login\"><a href=\"?login\"><img src=\"http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_large_border.png\" alt=\"Steam Login Button\"/></a></div>";
        }
           
    }elseif($OpenID->mode == "cancel"){
        echo "User has canceled Authenticiation.";
    } else {
 
        if(!isset($_SESSION['T2SteamAuth'])){
 
            $_SESSION['T2SteamAuth'] = $OpenID->validate() ? $OpenID->identity : null;
            $_SESSION['T2SteamID64'] = str_replace("http://steamcommunity.com/openid/id/", "", $_SESSION['T2SteamAuth']);
 
            if($_SESSION['T2SteamAuth'] !== null){
 
                $Steam64 = str_replace("http://steamcommunity.com/openid/id/", "", $_SESSION['T2SteamAuth']);
                $profile = get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key={$api}&steamids={$Steam64}");
                $buffer = fopen("../steam/cache/{$Steam64}.json", "w+");
                fwrite($buffer, $profile);
                fclose($buffer);
            }
 
            header("Location: http://www.example.com");
 
        }
 
    }
?>