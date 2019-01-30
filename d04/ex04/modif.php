<?php

function ft_error()
{
	echo "ERROR\n";
	exit(-1);
}

$login = $_POST['login'];
$oldpw = $_POST['oldpw'];
$newpw = $_POST['newpw'];
$submit = $_POST['submit'];

if ($login  == "" || $oldpw == "" || $newpw == "")
	ft_error();
	
if ($submit == "OK")
{
	$newpw = hash(whirlpool, $newpw);
	$oldpw = hash(whirlpool, $oldpw);
	$all_users = unserialize(file_get_contents("../private/passwd"));
	foreach ($all_users as &$user)
	{
		if ($user['login'] == $login && $user['passwd'] == $oldpw)
		{
			$user['passwd'] = $newpw;
			$serialized = serialize($all_users);
			file_put_contents("../private/passwd", $serialized);
			echo "OK\n";
			header("Location: index.html");
			exit();
		}
	}
	ft_error();
}
else
	ft_error();

?>