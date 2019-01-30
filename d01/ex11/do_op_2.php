#!/usr/bin/php
<?PHP

function ft_error($str)
{
	echo "$str\n";
	exit();
}

if ($argc != 2)
	ft_error("Incorrect Parameters");
$input = sscanf($argv[1], "%d %c %d %s");
$nb = $input[0];
$op = $input[1];
$nb2 = $input[2];
if ($input[3] || $input[3] == "0")
	ft_error("Syntax Error");
if (!is_numeric($nb) || !is_numeric($nb2))
	ft_error("Syntax Error");
else if (!$nb2 && ($op == "/" || $op == "%"))
	ft_error("Syntax Error");

switch ($op)
{
	case ("+") :
		echo $nb + $nb2;
		break;
	case ("-") :
		echo $nb - $nb2;
		break;
	case ("*") :
		echo $nb * $nb2;
		break;
	case ("/") :
		echo $nb / $nb2;
		break;
	case ("%") :
		echo $nb % $nb2;
		break;
	default:
	ft_error("Syntax Error");
}
echo "\n";

?>