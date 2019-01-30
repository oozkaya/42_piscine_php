#!/usr/bin/php
<?PHP

date_default_timezone_set("Europe/Paris");

$month_array = array("janvier" => 1,
			"fevrier" => 2,
			"mars" => 3,
			"avril" => 4,
			"mai" => 5,
			"juin" => 6,
			"juillet" => 7,
			"aout" => 8,
			"septembre" => 9,
			"octobre" => 10,
			"novembre" => 11,
			"decembre" => 12);

$day_name = "(lundi|m(ardi|ercredi)|jeudi|vendredi|samedi|dimanche)";
$day = "([1-9]|0[1-9]|[12]\d|3[01])";
$month = "(j(anvier|uin|uillet)|fevrier|m(ars|ai)|a(vril|out)|septembre|octobre|novembre|decembre)";
$year = "(\d{4})";
$time = "(([0-2][0-3])|([0-1][0-9])):([0-5][0-9]):([0-5][0-9])";
$regex = "/^".$day_name." ".$day." ".$month." ".$year." ".$time."$/";

if ($argc != 2)
	exit();

$str = strtr(strtolower($argv[1]), "éû", "eu"); 
$date = trim(preg_replace("/\s\s+/", " ", $str));

if (!preg_match($regex, $date))
{
	echo "Wrong Format\n";
	exit();
}

$date = preg_replace("/^$day_name /", "", $date);
foreach ($month_array as $key => $value)
	if (strstr($date, $key))
		break;
$date = preg_replace("/$month/", $value, $date);
$date = preg_replace("/ /", "-", $date, 2);

echo strtotime($date)."\n";

?>