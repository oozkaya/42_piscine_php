<?PHP

if ($_GET["action"] && $_GET["name"])
{
	if ($_GET["action"] == "set")
		setcookie($_GET["name"], $_GET["value"], time() + (86400 * 30));
	else if ($_GET["action"] == "get" && $_COOKIE[$_GET['name']])
		echo $_COOKIE[$_GET["name"]]."\n";
	else if ($_GET["action"] == "del")
		setcookie($_GET["name"], "", time() - 3600);
}

?>