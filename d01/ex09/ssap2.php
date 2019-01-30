#!/usr/bin/php
<?PHP

function ft_split($str)
{
	$split = array_filter(explode(' ', $str));
	return $split;
}

function ft_convert($param)
{
	if (ctype_alpha($param))
		return 1000;
	else if (is_numeric($param))
		return 2000;
	else
		return 3000;
}

function ft_compare($a, $b)
{
	$a = strtolower($a);
	$b = strtolower($b);
	$i = 0;
	while ($a[$i] && $b[$i])
	{
		$tempa = ord($a[$i]) + ft_convert($a[$i]);
		$tempb = ord($b[$i]) + ft_convert($b[$i]);
		if ($tempa < $tempb)
			return -1;
		else if ($tempa > $tempb)
			return 1;
		$i++;
	}
	if (strlen($a) < strlen($b))
		return -1;
	else
		return 1;
	return 0;
}

if ($argc == 1)
	exit();
unset($argv[0]);
foreach ($argv as $value)
{
	$split = ft_split($value);
	foreach ($split as $elem)
		$array[] = $elem;
}
usort($array, "ft_compare");
foreach ($array as $val)
	echo $val."\n";

?>