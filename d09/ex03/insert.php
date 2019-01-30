<?php

function get_lastid($file)
{
	if (!($contents = file_get_contents($file)))
		return FALSE;
	$lines = explode("\n", $contents);
	$i = 0;
	while ($lines[$i])
	{
		$line = explode(";", $lines[$i]);
		$id = $line[0];
		$i++;
	}
	return $id;
}

header('Content-type: application/json');
$file = "list.csv";

if (isset($_POST["new"]) && $_POST["new"] !== "")
{
	$newid = get_lastid($file) + 1;
	$todo = $_POST["new"];
	$string = implode(";", array($newid, $todo)) . "\n";
	file_put_contents($file, $string, FILE_APPEND);
	echo json_encode(array('status' => "success"));
}
else
	echo json_encode(array('status' => "error", 'post' => json_encode($_POST)));

?>