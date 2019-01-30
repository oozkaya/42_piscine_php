#!/usr/bin/php
<?PHP

if ($argc < 2)
	exit();

$res = trim(preg_replace("/\s\s+/", " ", $argv[1]));
echo $res."\n";

?>