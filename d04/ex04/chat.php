<?PHP

date_default_timezone_set("Europe/Paris");

if (file_exists("../private/chat"))
{
	$fd = fopen("../private/chat", "r");
	flock($fd, LOCK_SH);
	$all_msg = unserialize(file_get_contents("../private/chat"));
	flock($fd, LOCK_UN);
	fclose($fd);
}

foreach ($all_msg as $msg)
{
	echo date("[H:i] ", $msg['time']);
?>
<b><?PHP echo $msg['login']; ?></b>: <?PHP echo $msg['msg']; ?><br />
<?PHP
}

?>