function loadUrl(url,funct)
{
	var xmlhttp;

	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			result = xmlhttp.responseText;
			eval(funct+'()');
		}
		
		if (xmlhttp.readyState==4 && xmlhttp.status!=200)
		{
			result = false;
			eval(funct+'()');
		}
	}
	
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
}

function loadProfile(){
	document.getElementById('profile').innerHTML='<span class="card"><img src="img/loader.gif" alt="loading..."/><br><b>Loading profile</b></span>';
	loadUrl('data/profile/','profile_ready');
}

function profile_ready()
{
	profile=document.getElementById('profile');
	if(!result)
	{
		profile.innerHTML = "Couldn't load profile X_x";
		return false;
	}
	bot = JSON.parse(result);
	profile.innerHTML = '<img class="left avatar" src="'+bot.avatar+'" alt=""/><b>'+bot.name+'</b><br>'+bot.personastate;
}

function loadTF2bp(){
document.getElementById('backpack').innerHTML='<span class="card"><img src="img/loader.gif" alt="loading..."/><br><b>Loading Backpack</b></span>';
loadUrl('data/inventory/tf2/','bp_ready');}

function bp_ready(){
card=document.getElementById('backpack');
if(!result)
{
	card.innerHTML = "<b>Couldn't load TF2 backpack</b><br>¿Steam community down?";
	return false;
}
tf2bp = JSON.parse(result);
var classIcons;
var qualityString;
var tmpStrbuilder = ['<div class="card"><img class="imgInv" src="http://media.steampowered.com/apps/440/icons/',tf2bp.schema[5002].image,'" alt=""/><span class="name"><b>',tf2bp.metal,'</b> Refined</span></div>'];

	for(var defindex in tf2bp.stock) {
		for(var quality in tf2bp.stock[defindex])
		{
			qualityString='';
			
			switch(quality)
			{
				case '1':
				qualityString = 'g';
				break;
				
				case '3':
				qualityString = 'v';
				break;
				
				case '6':
				qualityString = 'n';
				break;
				
				case '11':
				qualityString = 's';
				break;
				
				case '600':
				qualityString = 'd';
				break;
				
				default:
				qualityString = quality;
			}
			
			tmpStrbuilder.push('<div class="card ',qualityString,'"><a href="http://wiki.teamfortress.com/scripts/itemredirect.php?id=',defindex,'"><img class="imgInv" src="http://media.steampowered.com/apps/440/icons/',tf2bp.schema[defindex].image,'" alt="" title="',tf2bp.schema[defindex].name,'" /></a><b>',tf2bp.stock[defindex][quality],' x ',tf2bp.schema[defindex].name,'</b></div>');
		}
	}
	card.innerHTML=tmpStrbuilder.join('');
}

function loadInventory(){
	document.getElementById('backpack').innerHTML='<span class="card"><img src="img/loader.gif" alt="loading..."/><br><b>Loading inventory</b></span>';
	loadUrl('data/inventory/','loadInventory_ready');
}

function loadInventory_ready(){
backpack=document.getElementById('backpack');
if(!result)
{
	backpack.innerHTML = "<b>Couldn't load TF2 backpack</b><br>¿Steam community down?";
	return false;
}
bp = JSON.parse(result);
tmpStrBuilder = [''];

for (var id in bp)
{
	tmpStrBuilder.push('<div class="card"><img src="http://cdn.steamcommunity.com/economy/image/',bp[id].image,'/96x96" alt=""/><span class="code">',bp[id].stock,' x ',bp[id].name,'</span></div>');
}

backpack.innerHTML = tmpStrBuilder.join('');
}

