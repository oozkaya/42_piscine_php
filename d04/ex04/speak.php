<?PHP

session_start();

$user = $_SESSION['loggued_on_user'];
$msg = $_POST['msg'];
$submit = $_POST['submit'];
$time = time();

if (!$_SESSION['loggued_on_user'])
{
	echo "ERROR\n";
	exit(-1);
}

if ($submit == "OK" && $msg)
{
	if (file_exists("../private/chat"))
	{
		$fd = fopen("../private/chat", "r");
		flock($fd, LOCK_SH);
		$all_msg = unserialize(file_get_contents("../private/chat"));
		flock($fd, LOCK_UN);
		fclose($fd);
	}
	$all_msg[] = array("login" => $user, "time" => $time, "msg" => $msg);
	$serialized = serialize($all_msg);
	file_put_contents("../private/chat", $serialized, LOCK_EX);
}

?>
<html>
<header>
<script langage="javascript">top.frames['chat'].location = 'chat.php';</script>
</header>
<body>
<form  action="speak.php" method="POST">
	<center>
	<input type="text" name="msg" value="" style="height: 95%; margin-bottom:-10;"/>
	<input type="submit" name="submit" value="OK" />
	<center>
</form>
</body></html>
