<?PHP

function ft_is_sort($tab)
{
	$copy = $tab;
	sort($copy);
	if (array_diff_assoc($copy, $tab))
		return FALSE;
	return TRUE;
}

?>