#!/usr/bin/php
<?php
	function parse_data($path, $mainkey)
	{
		if (preg_match("/^(nom|prenom|mail|IP|pseudo)$/", $mainkey) === 0)
			return FALSE;
		if (($handle = fopen($path, "r")) === FALSE)
			return FALSE;
		while (($buffer = fgets($handle, 4096)) !== false)
		{
			$buffer = trim($buffer);
			list($nom, $prenom, $mail, $IP, $pseudo) = explode(';', $buffer);
			$array['prenom'][$$mainkey] = $prenom;
			$array['nom'][$$mainkey] = $nom;
			$array['mail'][$$mainkey] = $mail;
			$array['IP'][$$mainkey] = $IP;
			$array['pseudo'][$$mainkey] = $pseudo;
		}
		if (!feof($handle))
			echo "Error: fgets() failed\n";
		fclose($handle);
		return $array;
	}

	if ($argc == 3)
	{
		$datapath = $argv[1];
		$mainkey = $argv[2];
		if (($array = parse_data($datapath, $mainkey)) !== FALSE)
		{
			if (($stdin = fopen('php://stdin', 'r')) === FALSE)
				exit (1);
			$ft = "(echo|print|printf|print_r|var_dump)";
			$keys = "(prenom|nom|mail|IP|pseudo)";
			while ($stdin && !feof($stdin))
			{
				echo "Entrez votre commande : ";
				$line = trim(fgets($stdin));
				if (feof($stdin))
				{
					echo "\n";
					exit(1);
				}
				if (preg_match_all('/\s*'.$ft.'(.*?)(;|(?=&&))/s', $line, $matches) !== 0)
				{
					foreach ($matches[0] as $cmd)
					{
						$cmd = rtrim($cmd, ';').';';
						if (preg_match_all('/\$'.$keys.'\[[\'"](.+?)[\'"]\]/', $cmd, $match))
						{
							$i = 0;

							while ($i < count($match[1]))
							{
								${$match[1][$i]} = $array[$match[1][$i]];

								if (array_key_exists($match[2][$i], ${$match[1][$i]}))
								{
									if (count($match[1]) === ($i + 1))
										eval($cmd);
								}
								else
								{
									echo "PHP Parse error :  syntax error, unexpected T_STRING in [....]\n";
									exit (-1);
								}
								$i++;
							}
						}
					}
				}
				else
					echo "PHP Parse error :  syntax error, unexpected T_STRING in [....]\n";
			}
			fclose ($stdin);
		}
	}
?>