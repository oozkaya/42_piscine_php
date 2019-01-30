$(document).ready(function()
{
	init();

	$('#new').click(function()
	{
		var todo = prompt("Please enter the new todo:", "My new To-do here");
		if (todo != null && todo != "")
		{
			var now = new Date();
			var utcString = now.toUTCString();
			var list_item = document.createElement('div');
			var added_at = "<i><small>[added at " + utcString + "]</small></i>";
			list_item.innerHTML = todo + " " + added_at;
			list_item.setAttribute("onclick", "rmChild(this);");
			$('#ft_list').prepend(list_item);

			insert(list_item.outerHTML);
		}
	});


function insert(data) {
	$.ajax({
		type: 'POST',
		url: 'insert.php',
		data: {"new":encodeURIComponent(data)},
		success: function (response)
		{
			if (response.status == 'success')
				alert("Todo has been inserted into list.csv");
			else if (response.status == 'error')
				alert("ERROR: Todo has NOT been inserted into list.csv\n$_POST:\n" + response.post);
		}
	});
}

});

function init() {
	$.ajax({
		url: 'select.php',
		success: function (todolist) {
			$('#ft_list').html(decodeURIComponent(todolist));
		}
	});
}

function rmChild(which) {
	if (confirm('Do you really want to remove this todo task ?'))
	{
		$.ajax({
			type: 'POST',
			url: 'delete.php',
			data: {"delete":encodeURIComponent(which.outerHTML)},
			success: function (response)
			{
				if (response.status == 'success')
				{
					which.remove();
					alert("Todo has been deleted from list.csv");
				}
				else if (response.status == 'error')
					alert("ERROR: Todo has NOT been deleted from list.csv\n$_POST:\n" + response.post);
			}
		});
	}
}