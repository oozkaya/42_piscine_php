#!/usr/bin/php
<?PHP

$split = array_filter(explode(' ', $argv[1]));
if (count($split) > 1)
{
	$split[] = $split[0];
	unset($split[0]);
}
$rostring = implode(' ', $split);
echo $rostring."\n";

?>