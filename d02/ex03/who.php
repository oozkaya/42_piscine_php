#!/usr/bin/php
<?PHP

$file = fopen("/var/run/utmpx", "r");
$users_tab = array();
while ($line = fread($file, 628))
{
	$line = unpack("a256user/a4ttyid/a32ttyname/ipid/slogintype/sunknown1/itimestamp/imicrosec/a256hostname/a64unknown2", $line);
	if (strcmp($line['logintype'], "7") == 0)
		array_push($users_tab, $line);
}
date_default_timezone_set("Europe/Paris");
foreach($users_tab as $user)
	printf("%s  %s  %s\n", $user['user'], $user['ttyname'], date("M j H:i", $user['timestamp']));
fclose($file);

?>