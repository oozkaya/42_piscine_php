<?php

header('Content-type: text/html');

$file = "list.csv";

if ($contents = file_get_contents($file))
{
	$lines = explode("\n", $contents);
	$i = count($lines) - 1;
	while ($i >= 0)
	{
		$line = explode(";", $lines[$i]);
		$id = $line[0];
		$j = 1;
		while ($line[$j])
		{
			if ($id !== "id")
				$todo .= $line[$j];
			$j++;
		}
		$i--;
	}
	echo $todo;
}

?>