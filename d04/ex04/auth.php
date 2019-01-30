<?PHP

function auth($login, $passwd)
{
	$passwd = hash(whirlpool, $passwd);
	$all_users = unserialize(file_get_contents("../private/passwd"));
	foreach ($all_users as $user)
		if ($user['login'] == $login && $user['passwd'] == $passwd)
			return TRUE;
	return FALSE;
}

?>