<?php
define('HOST_NAME','localhost');

include(dirname(__FILE__).'/../lib/OpenId.php');

$OpenID = new LightOpenID(HOST_NAME);
 
    session_start();
	
	if(isset($_GET['logout'])){
 
        unset($_SESSION['T2SteamAuth']);
        unset($_SESSION['T2SteamID64']);
        header('Location: .');
    }
 
    if(!$OpenID->mode){
 
        if(isset($_GET['login'])){
            $OpenID->identity = 'http://steamcommunity.com/openid';
            header("Location: {$OpenID->authUrl()}");
        }
 
        if(!isset($_SESSION['T2SteamAuth'])){
            $login = '<div class="logintext" id="login"><a href="?login"><img src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_large_border.png" alt="Steam Login Button"/></a></div>';
        }
           
    }elseif($OpenID->mode == 'cancel'){
        echo 'User has canceled Authenticiation.';
    } else {
 
        if(!isset($_SESSION['T2SteamAuth'])){
 
            $_SESSION['T2SteamAuth'] = $OpenID->validate() ? $OpenID->identity : null;
			
            $pos = strripos($OpenID->identity,'id');
			$id = substr($OpenID->identity,$pos+3);
			
            if($_SESSION['T2SteamAuth'] !== null){
				$_SESSION['T2SteamID64'] = $id; //str_replace('https://steamcommunity.com/openid/id/','', $_SESSION['T2SteamAuth']);
            }
			
            header('Location: .');
        }
 
    }
?>