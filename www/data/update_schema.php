<pre>
<?php
include('../lib/steam.php');
$schema=open_json('http://api.steampowered.com/IEconItems_440/GetSchema/v0001/?key='.APIKEY.'&format=json');

$data=array();

if ($schema->result->status){
	foreach($schema->result->items as &$item){
		$data[$item->defindex]['name']=$item->name;
		$data[$item->defindex]['image']= str_replace('http://media.steampowered.com/apps/440/icons/','',$item->image_url);
		$data[$item->defindex]['type']='undefined';
		
		if (@$item->craft_class!=='')
			$data[$item->defindex]['type']=@$item->craft_class;
		
		if (@$item->craft_material_type!=='')
			$data[$item->defindex]['type']=@$item->craft_material_type;
	}
}

$data[0]['name']='Bat';
$data[1]['name']='Bottle';
$data[2]['name']='Fire Axe';
$data[3]['name']='Kukri';
$data[4]['name']='Knife';
$data[5]['name']='Fists';
$data[6]['name']='Shovel';
$data[7]['name']='Wrench';
$data[8]['name']='Bonesaw';
$data[9]['name']='Shotgun';
$data[10]['name']='Shotgun';
$data[11]['name']='Shotgun';
$data[12]['name']='Shotgun';
$data[13]['name']='Scattergun';
$data[14]['name']='Sniper Rifle';
$data[15]['name']='Minigun';
$data[16]['name']='SMG';
$data[17]['name']='Syringe Gun';
$data[18]['name']='Rocket Launcher';
$data[19]['name']='Grenade Launcher';
$data[20]['name']='Stickybomb Launcher';
$data[21]['name']='Flame Thrower';
$data[22]['name']='Pistol';
$data[23]['name']='Pistol';
$data[24]['name']='Revolver';
$data[25]['name']='PDA';
$data[29]['name']='Medi Gun';
$data[30]['name']='Invisibility Watch';
$data[190]['name']=$data[0]['name'];
$data[191]['name']=$data[1]['name'];
$data[192]['name']=$data[2]['name'];
$data[193]['name']=$data[3]['name'];
$data[194]['name']=$data[4]['name'];
$data[195]['name']=$data[5]['name'];
$data[196]['name']=$data[6]['name'];
$data[197]['name']=$data[7]['name'];
$data[198]['name']=$data[8]['name'];
$data[199]['name']=$data[12]['name'];
$data[200]['name']=$data[13]['name'];
$data[201]['name']=$data[14]['name'];
$data[202]['name']=$data[15]['name'];
$data[203]['name']=$data[16]['name'];
$data[204]['name']=$data[17]['name'];
$data[205]['name']=$data[18]['name'];
$data[206]['name']=$data[19]['name'];
$data[207]['name']=$data[20]['name'];
$data[208]['name']=$data[21]['name'];
$data[209]['name']=$data[23]['name'];
$data[210]['name']=$data[24]['name'];
$data[211]['name']=$data[29]['name'];
$data[212]['name']=$data[30]['name'];
$data[265]['name']='Sticky Jumper';

$data[5000]['name']='Scrap';
$data[5001]['name']='Reclaimed';
$data[5002]['name']='Refined';
$data[5021]['name']='Key';
 
echo "\n".count($data)." Item definitions\n";
save_json($data,'schema.json');
?>
</pre>
