<html>
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="../../css/index.css">
        <title>Commandes</title>
    </head>
    <body>
    <header>
        <nav class="nav" role="navigation">
            <ul class="topmenu">
                <li><a href="admin.php">Client</a></li>
                <li><a href="users_admin.php">Admin</a></li>
                <li><a href="categories.php">Catégories</a></li>
                <li><a href="products.php">Produits</a></li>
                <li><a href="../authorization/logout.php">Se déconnecter</a></li>
            </ul>
    </header> 
    <h3 id="client">Commande:</h3>
    <div class="container">
<?php
function refresh($url = NULL) {
    if (empty($url)) {
        $url = $_SERVER['REQUEST_URI'];
    }
    header("Location: ".$url);
    exit();
}
$link = mysqli_connect("localhost", "root", "root42", "rush00");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$resQuery = mysqli_query($link, "SELECT * FROM `commande`");
if (($row = mysqli_fetch_array($resQuery)) == NULL) {
    echo "<h2 id='noorders' style='color: #E6855F'>No orders</h2>";
}
foreach ($resQuery as $elem) {
    echo "<form id='order' action='' method='post'>";
    $i = 0;
    foreach ($elem as $value) {
        echo "<input size='20%' type='text' name='$i' value='$value'>";
        $i++;
    }
    echo "<input type='submit' name='delete' value='Supprimer'>";
    echo "<input type='submit' name='valider' value='Valider'>";
    echo "</form>";
}
if (isset($_POST['delete'])) {
    if ($_POST['delete'] == "Supprimer") {
        $id = $_POST[0];
        $resLogQuery = mysqli_query($link, "SELECT * FROM `commande` WHERE id_commande = '$id'");
        if ($resLogQuery) {
            $resQuery = mysqli_query($link, "DELETE FROM `commande` WHERE id_commande = '$id'");
            refresh();
        }
    }
}
?>
</div>
<div class="footer">
			<p>
				&copy; Oozkaya & Pespalie - 2019
			</p>
		</div>
</body>
</html>