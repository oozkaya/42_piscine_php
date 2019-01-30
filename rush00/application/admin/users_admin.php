<html>
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="../../css/index.css">
        <title>Gestion administrateurs</title>
    </head>
    <header>
        <nav class="nav" role="navigation">
            <ul class="topmenu">
                <li><a href="admin.php">Client</a></li>
                <li><a href="orders.php">Commande</a></li>
                <li><a href="categories.php">Catégories</a></li>
                <li><a href="products.php">Produits</a></li>
                <li><a href="../authorization/logout.php">Se déconnecter</a></li>
            </ul>
    </header> 
    <h3 id="client">Admin:</h3>
    <div class="container">
<?php
function refresh($url = NULL) {
    if (empty($url)) {
        $url = $_SERVER['REQUEST_URI'];
    }
    header("Location: ".$url);
    exit();
}
session_start();
$link = mysqli_connect("localhost", "root", "root42", "rush00");
if (!$link)
    die("Connection failed\n" . mysqli_error($link));

$resQuery = mysqli_query($link, "SELECT * FROM `admin`");
?>
<html>
    <form id="add_admin" method="post" action="">
        <input type="text" name="login" value="" placeholder="login" />
        <input type="text" name="passwd" value="" placeholder="mot de passe" />
        <input type="submit" name="add" value="Ajouter" />
</form>
</html>
<?php
if (($row = mysqli_fetch_array($resQuery))  == NULL) {
    echo "<h2 id='noadmin' style='color: #E6855F'>No admin</h2>";
}
foreach ($resQuery as $elem) {
    echo "<form id='admin' action='' method='post'>";
    $i = 0;
    $j = 0;
    foreach ($elem as $value) {
        echo "<input size='20' type='text' name='$i' value='$value'>";
        if ($value == $_SESSION['loggued_on_user'])
            $j = 1;
        $i++;
    }
    if ($j != 1)
        echo "<input type='submit' name='delete' value='Supprimer'>";
    echo "</form>";
}

if (isset($_POST['delete'])){
    if ($_POST['delete'] == "Supprimer") {
        $id = $_POST[0];
        $resLogQuery = mysqli_query($link, "SELECT * FROM `admin` WHERE id_admin = '$id'");
        if ($resLogQuery) {
            mysqli_query($link, "DELETE FROM `admin` WHERE id_admin = '$id'");
            refresh();
        }
    }
}
if (isset($_POST['add'])){
    if ($_POST['add'] == "Ajouter") {
        $login = $_POST['login'];
        $passwd = hash("whirlpool", $_POST['passwd']);
        $link = mysqli_connect("localhost", "root", "root42", "rush00");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        mysqli_query($link, "INSERT INTO `admin` (login, passwd) VALUES ('$login', '$passwd')");
        refresh();
    }
}
?>
    </div>
    <div class="footer">
			<p>
				&copy; Oozkaya & Pespalie - 2019
			</p>
		</div>
</html>