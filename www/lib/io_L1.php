<?php 
function open_json($url,$assoc = false,$external = false)
{
	if ($external)
	{
		$headers = get_headers($url,true);
		if ($headers[0]!='HTTP/1.1 200 OK')
		return null;
	}
	return @json_decode(file_get_contents($url),$assoc);
} 

function save_json($data,$path)
{
	$tmp = json_encode($data);
	file_put_contents($path, $tmp, LOCK_EX);
}
?>