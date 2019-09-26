var steamId = null;

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

function loadProfile(steamid){
	document.getElementById('profile').innerHTML='<img class="avatar loader" src="img/loader.gif" alt="loading..."/><b>Loading profile</b>';
	loadUrl('data/profile/?id='+steamid,'profile_ready');
}

function profile_ready()
{
	profile=document.getElementById('profile');
	bot = JSON.parse(result);
	
	if(!bot['success'])
	{
		profile.innerHTML = "Couldn't load profile";
		return false;
	}
	
	profile.innerHTML = '<img class="avatar" src="'+bot.avatar+'" alt=""/><b>'+bot.name+'</b><br>'+bot.personastate+'<br>'+bot.steam;
}

function loadTF2bp(steamid){
document.getElementById('backpack').innerHTML='<span class="card"><img src="img/loader.gif" alt="loading..."/><br><b>Loading Backpack</b></span>';
loadUrl('data/inventory/tf2/?id='+steamid,'bp_ready');}

function bp_ready(){
	card=document.getElementById('backpack');

	tf2bp = JSON.parse(result);

	if(!tf2bp.success)
	{
		card.innerHTML = "<b>Couldn't load TF2 backpack</b><br>¿Steam community down?";
		return false;
	}
		
	var classIcons;
	var qualityString;
	
	var tmpStr;
	
	var hats = [''];
	var weapons = [''];
	var misc = [''];
	var currency = [''];
	
	if(tf2bp.keys > 0)
		currency.push('<div class="card"><img src="http://media.steampowered.com/apps/440/icons/',tf2bp.schema[5021].image,'" alt=""/><span class="name"><b>',tf2bp.keys,'</b> x Key</span></div>');
	
	if(tf2bp.metal > 0)
		currency.push('<div class="card"><img src="http://media.steampowered.com/apps/440/icons/',tf2bp.schema[5002].image,'" alt=""/><span class="name"><b>',tf2bp.metal,'</b> Refined</span></div>');
	
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
				
				case '13':
				qualityString = 'h';
				break;
				
				case '600':
				qualityString = 'd';
				break;
				
				default:
				qualityString = quality;
			}
			
			tmpStr = '<a class="card '+qualityString+'" href="http://wiki.teamfortress.com/scripts/itemredirect.php?id='+defindex+'"><img src="http://media.steampowered.com/apps/440/icons/'+tf2bp.schema[defindex].image+'" alt="" title="'+tf2bp.schema[defindex].name+'" /><br><b>'+tf2bp.stock[defindex][quality]+' x '+tf2bp.schema[defindex].name+' ('+tf2bp.schema[defindex].type+','+quality+')</b></a>';
			
			switch(tf2bp.schema[defindex].type)
			{
				case 'hat':
				case 'tf_wearable':
					hats.push(tmpStr);
				break;
				
				case 'weapon':
					weapons.push(tmpStr);
				break;
				
				case 'supply_crate':
					currency.push(tmpStr);
				break;
				
				default:
					misc.push(tmpStr);
				break;
			}
		}
	}
	
	card.innerHTML ="<h1>Currency and Crates</h1>"+currency.join('');
	card.innerHTML+="<h1>Hats</h1>"+hats.join('');
	card.innerHTML+="<h1>Weapons</h1>"+weapons.join('');
	card.innerHTML+="<h1>Misc</h1>"+misc.join('');
}

function loadInventory(steamid,appid,context){
	
	if(appid!=undefined)
		appid = '&appid='+appid;
	else
		appid = '&appid=753';
	
	if(context!=undefined)
		context = '&context='+context;
	else
		context = '&context=6';
	
	document.getElementById('backpack').innerHTML='<span class="card"><img src="img/loader.gif" alt="" title="loading..."/><br><b>Loading...</b></span>';
	loadUrl('data/inventory/?id='+steamid+appid+context,'loadInventory_ready');
}

function loadInventory_ready(){
backpack=document.getElementById('backpack');
bp = JSON.parse(result);

tmpStrBuilder = ['If nothing appears, you inventory is set private or you have no items!<br>'];

for (var id in bp)
{
	if(bp[id].type.indexOf('Emoticon')!=-1)
	style='class="emoticon"';
	else
	style='';
	
	tmpStrBuilder.push('<div class="card"><img ',style,' src="http://cdn.steamcommunity.com/economy/image/',bp[id].image,'/96x96" alt=""/><br><span class="name code">',bp[id].stock,' x ',bp[id].name,'</span></div>');
}

backpack.innerHTML = tmpStrBuilder.join('');
}