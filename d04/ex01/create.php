<?php

function ft_error()
{
	echo "ERROR\n";
	exit(-1);
}

if (!file_exists("../private/"))
	mkdir("../private/");

$login = $_POST['login'];
$passwd = $_POST['passwd'];
$submit = $_POST['submit'];

if ($passwd  == "" || $login == "")
	ft_error();

if ($submit == "OK")
{
	$passwd = hash(whirlpool, $passwd);
	if (file_exists("../private/passwd"))
	{
		$all_users = unserialize(file_get_contents("../private/passwd"));
		foreach ($all_users as $user)
			if ($user['login'] == $login)
				ft_error();
	}
	$all_users[] = array("login" => $login, "passwd" => $passwd);
	$serialized = serialize($all_users);
	file_put_contents("../private/passwd", $serialized);
	echo "OK\n";
}
else
	ft_error();

?>