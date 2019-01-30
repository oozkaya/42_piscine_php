#!/usr/bin/php
<?PHP

function ft_split($str)
{
	$split = array_filter(explode(' ', $str));
	sort($split);
	return $split;
}

unset($argv[0]);
foreach ($argv as $value)
{
	$split = ft_split($value);
	foreach ($split as $elem)
		$array[] = $elem;
}
sort($array);
foreach ($array as $val)
	echo $val."\n";

?>