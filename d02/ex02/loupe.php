#!/usr/bin/php
<?PHP

function ft_angle_brackets($tmp)
{
	$str = ">".strtoupper($tmp[1])."<";
	return ($str);
}

function ft_title($tmp)
{
	$str = "title=\"".strtoupper($tmp[1])."\"";
	return ($str);
}

function ft_replace($replace)
{
	$str = preg_replace_callback("/>(.*?)</s", "ft_angle_brackets", $replace[0]);
	$str = preg_replace_callback("/title=\"(.*?)\"/s", "ft_title", $str);
	return ($str);
}

$file = file_get_contents($argv[1]);

$res = preg_replace_callback("/<a href=(.*)<\/a>/s", "ft_replace", $file);
echo $res;

?>