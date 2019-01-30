#!/usr/bin/php
<?PHP

$i = 0;
foreach ($argv as $value)
{
	if ($i++ == 0)
		continue;
	echo $value."\n";
}

?>