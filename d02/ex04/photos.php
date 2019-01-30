#!/usr/bin/php
<?PHP

function curl($url)
{
	$ch = curl_init("$url");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$content = curl_exec($ch);
	curl_close($ch);
	return $content;
}

function get_images_links($path, $html)
{
	$path = rtrim($path, '/').'/';
	preg_match_all('/<img.*?src="(.+?)"/si', $html, $matches);
	foreach ($matches[1] as $match)
		$links[] = preg_replace("/^\//", $path, $match);
	return ($links);
}

if ($argc > 1)
{
	$url = $argv[1];
	$html = curl($url);
	$links = get_images_links($url, $html);
	if (count($links) > 0)
	{
		$folder = rtrim(preg_replace('#^https?://#', '', $url), '/').'/';
		if (file_exists($folder) === TRUE || mkdir($folder, 0755) === TRUE)
		{
			foreach ($links as $img)
			{
				$data = curl($img);
				$name = substr($img, strrpos($img, '/') + 1);
				file_put_contents($folder.$name, $data);
			}
		}
	}
}

?>
