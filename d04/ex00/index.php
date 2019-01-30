<?PHP

session_start();

$login = $_GET['login'];
$passwd = $_GET['passwd'];
$submit = $_GET['submit'];

if ($submit == "OK")
{
	$_SESSION['login'] = $login;
	$_SESSION['passwd'] = $passwd;
}

?>
<html><body>
<form  action="index.php" method="GET">
	Identifiant: <input type="text" name="login" value="<?PHP echo $_SESSION['login']?>" />
	<br />
	Mot de passe: <input type="password" name="passwd" value="<?PHP echo $_SESSION['passwd'] ?>" />
	<input type="submit" name="submit" value="OK" />
</form>
</body></html>
