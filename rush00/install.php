<?php
	$link = mysqli_connect("localhost", "root", "root42");
	if (!$link)
		die("Connection failed\n" . mysqli_error($link));
	$db = "CREATE DATABASE IF NOT EXISTS rush00";
	if (mysqli_query($link, $db) === FALSE)
		die("Error creating database\n" . mysqli_error($link));
	mysqli_select_db($link, "rush00") or die('Error selecting MySQL database: ' . mysqli_error($link));
	$sql = file_get_contents("rush00.sql");
	$sql_array = explode("\n", $sql);

	$templine = '';
	foreach ($sql_array as $line)
	{
		if (substr($line, 0, 2) == '--' || substr($line, 0, 2) == '/*' || $line == '')
			continue;
			$templine .= $line;
		if (substr(trim($line), -1, 1) == ';')
		{
			mysqli_query($link, $templine);
			$templine = "";
		}
	}
?>
