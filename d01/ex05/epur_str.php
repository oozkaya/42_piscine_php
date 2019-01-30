#!/usr/bin/php
<?PHP

if ($argc == 2)
{
	$value = $argv[1];
	$value = preg_replace('/\s\s+/', ' ', $value);
	$value = trim($value);
	echo $value;
}
echo "\n";

?>