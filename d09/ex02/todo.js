function new_todo(insert_into_id) {
    var todo = prompt("Please enter the new todo:", "My new To-do here");
    if (todo != null && todo != "") {
        var now = new Date();
        var utcString = now.toUTCString();
        var list_item = document.createElement('div');
        var added_at = "<i><small>[added at " + utcString + "]</small></i>";
        list_item.innerHTML = todo + " " + added_at;
        list_item.setAttribute("onclick", "rmChild(this);");
        document.getElementById(insert_into_id).insertBefore(list_item, document.getElementById(insert_into_id).firstChild);
        var html =  encodeURIComponent(document.getElementById(insert_into_id).innerHTML);
        createCookie("todo", html, 1);
    }
}
function rmChild(which)
{
    if (confirm('Do you really want to remove this todo task ?'))
        which.parentElement.removeChild(which);
    var html =  encodeURIComponent(document.getElementById("ft_list").innerHTML);
    createCookie("todo", html, 1);
}
function checkCookies(div_id) {
    var cook = readCookie("todo");
    console.log("cookie readed (encoded): " + cook);
    console.log("cookie readed (decoded): " + decodeURIComponent(cook));
    document.getElementById(div_id).innerHTML = decodeURIComponent(cook);
}
function createCookie(name, value, days) {
    if (days)
    {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else
        var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
    console.log("cookie created (encoded): " + name + "=" + value + expires + "; path=/");
}
function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        console.log(i + ": |" + ca[i] + "|");
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return "";
}
