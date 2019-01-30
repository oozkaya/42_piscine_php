<?php
function refresh($url = NULL) {
    if (empty($url)) {
        $url = $_SERVER['REQUEST_URI'];
    }
    header("Location: ".$url);
    exit();
}

$link = mysqli_connect("localhost", "root", "root42", "rush00");
if (!$link)
    die("Connection failed\n" . mysqli_error($link));

$resQuery = mysqli_query($link, "SELECT * FROM `client`");

if (($row = mysqli_fetch_array($resQuery))  == NULL) {
    echo "<h2 id='nouser' style='color: #E6855F'>No users</h2>";
}

foreach ($resQuery as $elem) {
    echo "<form id='client' action='' method='post'>";
    $i = 0;
    foreach ($elem as $value) {
        echo "<input size='18' type='text' name='$i' value='$value'>";
        $i++;
    }
    echo "<input type='submit' name='delete' value='Supprimer'>";
    echo "<input type='submit' name='change' value='Admin'>";
    echo "</form>";
}

if (isset($_POST['delete'])){
    if ($_POST['delete'] == "Supprimer") {
        $id = $_POST[0];
        $resLogQuery = mysqli_query($link, "SELECT * FROM `client` WHERE id_client = '$id'");
        if ($resLogQuery) {
            mysqli_query($link, "DELETE FROM `client` WHERE id_client = '$id'");
            refresh();
        }
    } 
}
if (isset($_POST['change'])){
    if ($_POST['change'] == "Admin") {
        $id = $_POST[0];
        $login = $_POST[1];
        $passwd = $_POST[4]; 
        $resLogQuery = mysqli_query($link, "SELECT * FROM `client` WHERE id_client = '$id'");
        if ($resLogQuery) {
            mysqli_query($link, "INSERT INTO `admin` (login, passwd) VALUES ('$login', '$passwd')");
            refresh();
        }
    }
    }
?>