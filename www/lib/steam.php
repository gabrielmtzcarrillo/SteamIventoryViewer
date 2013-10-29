<?php
define('APIKEY','your_api_key_here');

function open_json($url,$assoc = false){return @json_decode(file_get_contents($url),$assoc);}  
function save_json($data,$path){$tmp = json_encode($data);file_put_contents($path, $tmp, LOCK_EX);}

function open_backpack($steamid,$onlyTradeable = true){
	$metal = 0;
	
	$bp_item = array();
	$bp_data = open_json('http://api.steampowered.com/IEconItems_440/GetPlayerItems/v0001/?key='.APIKEY.'&SteamID='.$steamid.'&format=json',false);
	
	if (@!$bp_data->result->status){
		$bp_item['success']=false;
		return $bp_item;
	}
	
	if (@$bp_data->result->status==1){
		$schema=open_json(dirname(__FILE__).'/../data/schema.json',true);
		
		foreach($bp_data->result->items as &$item){
			$tradable=true;

			if (isset($item->flag_cannot_craft)){
				if ($item->flag_cannot_craft==true)
				$item->quality = 600;
			}
			
			if (isset($item->flag_cannot_trade)){
				if ($item->flag_cannot_trade)
				$item->quality = 0;
				$tradable = !$onlyTradeable;
			}
			
			switch ($item->defindex)
			{
				case 5000:
					$metal+=2;
					$tradable = !$onlyTradeable;
				break;
				case 5001:
					$metal+=6;
					$tradable = !$onlyTradeable;
				break;
				case 5002:
					$metal+=18;
					$tradable = !$onlyTradeable;
				break;
			}
			
			if ($tradable==true){
				if (isset($bp_item['stock'][$item->defindex][$item->quality])){
					$bp_item['stock'][$item->defindex][$item->quality]++;
				}else{
					$bp_item['stock'][$item->defindex][$item->quality]=1;
					$bp_item['schema'][$item->defindex]=$schema[$item->defindex];
				}
			}
				
		}
		
		$bp_item['schema'][5000]=$schema[5000];
		$bp_item['schema'][5001]=$schema[5001];
		$bp_item['schema'][5002]=$schema[5002];
		$bp_item['schema'][5021]=$schema[5021];
		$bp_item['metal']=round($metal/18,2);
		$bp_item['slots']=$bp_data->result->num_backpack_slots;
		$bp_item['used_slots']=count($bp_data->result->items);
		$bp_item['success']=true;
	
		
	}else{
		$bp_item['success']=false;
	}
	return $bp_item;
}

function open_inventory($id,$appid,$contextid)
{
	$inventory = open_json('http://steamcommunity.com/profiles/'.$id.'/inventory/json/'.$appid.'/'.$contextid.'/',true);
	
	$inv_item=array();
	$inv_desc=array();
	
	if (@$inventory['success']){
		foreach ( $inventory['rgInventory'] as $k => $v )
		{
			$inv_item[$k]['class']=$v['classid'];
			$inv_item[$k]['instance']=$v['instanceid'];
		}
		foreach ( $inventory['rgDescriptions'] as $k => $v )
		{
			$inv_desc[$k]['name']=$v['name'];
			$inv_desc[$k]['image']=$v['icon_url'];
			$inv_desc[$k]['type']=$v['type'];
		}
	}
	else
	{
		$inventory['success']=false;
		return $inventory;
	}

	$inventory = array();

	foreach($inv_item as $item)
	{
		if(!isset($inventory[$item['class']]['stock']))
		{
			$tmp = $item['class'].'_'.$item['instance'];
			$inventory[$item['class']]['stock']=1;
			$inventory[$item['class']]['name']=$inv_desc[$tmp]['name'];
			$inventory[$item['class']]['type']=$inv_desc[$tmp]['type'];
			$inventory[$item['class']]['image']=$inv_desc[$tmp]['image'];
		}
		else
		{
			$inventory[$item['class']]['stock']++;
		}
	}
	
	$inv_desc = array();
	$inv_item = array();
	
	return $inventory;
}

function open_profile($steamid){
$tmp = open_json('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.APIKEY.'&SteamIDs='.$steamid.'&format=json',true);

if (empty($tmp['response']['players']))
{
	$profile['name']='Name';
	$profile['steam'] = '';
	$profile['status']=0;
	$profile['url']='#';
	$profile['avatar']='';
	$profile['personastate']='Offline';
	$profile['success'] = false;
}
else
{
	$profile['name']=$tmp['response']['players']['0']['personaname'];
	$profile['steam']=$tmp['response']['players']['0']['steamid'];
	$profile['status']=$tmp['response']['players']['0']['personastate'];
	switch ($profile['status'])
	{
		case 1:
			$profile['personastate']='Online';
		break;

		case 2:
			$profile['personastate']='Busy';
		break;

		case 3:
			$profile['personastate']='Away';
		break;
			
		case 4:
			$profile['personastate']='Snooze';
		break;
		
		case 5:
			$profile['personastate']='Looking to trade';
		break;
		case 6:
			$profile['personastate']='Looking to play';
		break;
		
		default:
		$profile['personastate']='Offline';
	}
	
	$profile['url']=$tmp['response']['players']['0']['profileurl'];
	$profile['avatar']=$tmp['response']['players']['0']['avatarmedium'];
	$profile['success'] = true;
}
return $profile;
}

?>