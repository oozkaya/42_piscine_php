#!/usr/bin/php
<?PHP

function ft_average($tab)
{
	$sum = 0;
	$count = 0;
	foreach ($tab as $tab1)
	{
		foreach ($tab1 as $tab2)
		{
			foreach ($tab2 as $key => $value) {
				if ($key == "note" && $value != "" && $tab2["noteur"] != "moulinette")
				{
					$sum += $value;
					$count++;
				}
			}
		}
	}
	return $sum / $count;
}

function ft_user_average($tab)
{
	foreach ($tab as $tab1)
	{
		$sum = 0;
		$count = 0;
		foreach ($tab1 as $tab2)
		{
			foreach ($tab2 as $key => $val)
			{
				if ($key == "note" && $val != "" && $tab2["noteur"] != "moulinette")
				{
					$sum += $val;
					$count++;
				}
			}
		}
		echo $tab2["user"].":".$sum / $count."\n";
	}
}

function ft_moulinette_gap($tab)
{
	foreach ($tab as $tab1)
	{
		$sum = 0;
		$count = 0;
		foreach ($tab1 as $tab2)
		{
			foreach ($tab2 as $key => $val)
			{
				if ($key == "note" && $val != "")
				{
					if ($tab2["noteur"] != "moulinette")
					{
						$sum += $val;
						$count++;
					}
					else
						$moulinote = $val;
				}
			}
		}
		$res = $sum / $count - $moulinote;
		echo $tab2["user"].":".$res."\n";
	}
}

if ($argc != 2)
	exit();

while (($line = fgets(STDIN)))
{
	list($user, $note, $noteur, $feedback) = explode(';', $line);
	$tmp = array();
	$tmp["user"] = $user;
	$tmp["note"] = $note;
	$tmp["noteur"] = $noteur;
	$tmp["feedback"] = $feedback;
	$tab[$user][] = $tmp;
	ksort($tab);
}
unset($tab["User"]);

if ($argv[1] == "moyenne")
	echo ft_average($tab)."\n";
else if ($argv[1] == "moyenne_user")
	ft_user_average($tab)."\n";
else if ($argv[1] == "ecart_moulinette")
	ft_moulinette_gap($tab)."\n";

?>