<?php


function get_todo_array($file)
{
	if (!($contents = file_get_contents($file)))
		return FALSE;
	$lines = explode("\n", $contents);
	$i = 0;
	while ($lines[$i])
	{
		$line = explode(";", $lines[$i]);
		$id = $line[0];
		$todo = "";
		$j = 1;
		while ($line[$j])
		{
			$todo .= $line[$j];
			$j++;
		}
		if ($id !== "id")
			$array[] = array("id" => $id, "todo" => $todo);
		$i++;
	}
	return $array;
}

header('Content-type: application/json');
$file = "list.csv";
$del = 0;

if (isset($_POST["delete"]) && $_POST["delete"] !== "")
{
	$todolist = get_todo_array($file);
	$string = "id;todo\n";
	file_put_contents($file, $string);
	$id = 0;
	foreach ($todolist as $todo)
	{
		if ($todo["todo"] !== $_POST["delete"])
		{
			$string = implode(";", array($id, $todo["todo"])) . "\n";
			file_put_contents($file, $string, FILE_APPEND);
			$id++;
		}
		else
			$del++;
	}
}

if ($del > 0)
	echo json_encode(array('status' => "success"));
else
	echo json_encode(array('status' => "error", 'post' => json_encode($_POST)));

?>