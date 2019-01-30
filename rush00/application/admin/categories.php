<html>
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="../../css/index.css">
        <title>Gestion des catégories</title>
        </head>
    <header>
        <nav class="nav" role="navigation">
            <ul class="topmenu">
                <li><a href="admin.php">Client</a></li>
                <li><a href="users_admin.php">Admin</a></li>
                <li><a href="orders.php">Commande</a></li>
                <li><a href="../authorization/logout.php">Se déconnecter</a></li>
            </ul>
    </header> 
    <h3 id="client">Catégories:</h3>
    <div class="container">
<?php
    $link = mysqli_connect("localhost", "root", "root42", "rush00");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

function refresh($url = NULL) {
    if (empty($url)) {
        $url = $_SERVER['REQUEST_URI'];
    }
    header("Location: ".$url);
    exit();;
}
if (isset($_POST['delete'])) {
    if ($_POST['delete'] == "Supprimer") {
        $id = $_POST['id_cat'];
        $query = mysqli_query($link, "DELETE FROM `categorie` WHERE id_cat = '$id'");
        refresh();
    }
}
if (isset($_POST['modify'])) {
    if ($_POST['modify'] == "Modifier") {
        $id = $_POST['id_cat'];
        $name = $_POST['1'];
        mysqli_query($link, "UPDATE `categorie` SET `nom` = '$name' WHERE `categorie`.`id_cat` = '$id'");
        refresh();
    }
}
if (isset($_POST['add'])) {
    if ($_POST['add'] == "Ajouter") {
        $name = $_POST['name'];
        $categorie = (int)$_POST['categorie'];
        $link = mysqli_connect("localhost", "root", "root42", "rush00");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        mysqli_query($link, "INSERT INTO `categorie` (nom) VALUES ('$name')");
        refresh ();
    }
}
$resQuery = mysqli_query($link, "SELECT * FROM `categorie`");
if (($row = mysqli_fetch_array($resQuery))  == NULL) {
    echo "<h2 style='color: #E6855F'>No items</h2>";
}
?>
    <form id="add" method="post" action="">
        <input type="text" name="name" value="" placeholder="name" />
        <input type="submit" name="add" value="Ajouter" />
</form>
<?php
foreach ($resQuery as $elem) {
    echo "<form id='products' action='' method='post'>";
    $i = 0;
    foreach ($elem as $value) {
        echo "<input type='text' name='$i' value='$value'>";
        $i++;
    }
    $id = $elem['id_cat'];
    echo "<input type='hidden' name='id_cat' value='{$id}'>";
    echo "<input type='submit' name='delete' value='Supprimer'>";
    echo "<input type='submit' name='modify' value='Modifier'>";
    echo "</form>";
}
?>
<div class="footer">
			<p>
				&copy; Oozkaya & Pespalie - 2019
			</p>
		</div>
