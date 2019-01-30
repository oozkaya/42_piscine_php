<html>
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="../../css/index.css">
        <title>Gestion des produits</title>
        </head>
        <body>
    <header>
        <nav class="nav" role="navigation">
            <ul class="topmenu">
                <li><a href="admin.php">Client</a></li>
                <li><a href="users_admin.php">Admin</a></li>
                <li><a href="categories.php">Catégories</a></li>
                <li><a href="orders.php">Commande</a></li>
                <li><a href="../authorization/logout.php">Se déconnecter</a></li>
            </ul>
		</nav>
    </header> 
    <h3 id="client">Produits:</h3>
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
        $id = $_POST['id_pokemon'];
		mysqli_query($link, "DELETE FROM `pokemon` WHERE id_pokemon = '$id'");
        refresh();
    }
}
if (isset($_POST['modify'])) {
    if ($_POST['modify'] == "Modifier") {
        $id = $_POST['id_pokemon'];
        $name = $_POST['1'];
        $price = $_POST['2'];
        $pic = $_POST['3'];
        mysqli_query($link, "UPDATE `pokemon` SET nom = '$name', prix = '$price', image = '$pic' WHERE id_pokemon = '$id'");
        refresh();
    }
}
if (isset($_POST['add'])) {
    if ($_POST['add'] == "Ajouter" && !empty($_POST['name'] && is_numeric($_POST['price']))) {
		$name = strtolower($_POST['name']);
        $price = (int)$_POST['price'];
        $pic = $_POST['pic'];
        $link = mysqli_connect("localhost", "root", "root42", "rush00");
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
		}
		$sql = mysqli_query($link, "SELECT * FROM `pokemon`");
		$all_poke = array();
		while ($row = mysqli_fetch_assoc($sql))
			$all_poke[] = $row;
		$dont = 0;
		foreach ($all_poke as $poke)
			if ($poke['nom'] == $name)
				$dont = 1;
		if ($dont == 0)
		{	
			mysqli_query($link, "INSERT INTO `pokemon` (nom, prix, `image`) VALUES ('$name', '$price', '$pic')");
			$sql = mysqli_query($link, "SELECT * FROM `pokemon`");
			$all_poke = array();
			while ($row = mysqli_fetch_assoc($sql))
				$all_poke[] = $row;
			foreach ($all_poke as $poke)
				if ($poke['nom'] == $name)
					$id_poke = $poke['id_pokemon'];
			$sql = mysqli_query($link, "SELECT * FROM `categorie`");
			$all_cat = array();
			while ($row = mysqli_fetch_assoc($sql))
				$all_cat[] = $row;
			foreach ($all_cat as $cat)
			{
				if (isset($_POST[$cat['nom']]))
				{
					$id_cat = $cat['id_cat'];
					mysqli_query($link, "INSERT INTO `cat_poke` (id_cat, id_pokemon) VALUES ('$id_cat', '$id_poke')");
				}
			}
		}
        refresh ();
    }
}
$resQuery = mysqli_query($link, "SELECT * FROM `pokemon`");
if (($row = mysqli_fetch_array($resQuery))  == NULL) {
    echo "<h2 style='color: #E6855F'>No items</h2>";
}
?>
    <form id="add" method="post" action="">
        <input type="text" name="name" value="" placeholder="name" />
        <input type="text" name="price" value="" placeholder="price" />
<?php
		$sql = mysqli_query($link, "SELECT * FROM `categorie`");
		$all_cat = array();
		while ($row = mysqli_fetch_assoc($sql))
			$all_cat[] = $row;
		foreach ($all_cat as $cat)
			echo "<input type='checkbox' name='".$cat['nom']."' value='".$cat['id_cat']."'>".$cat['nom'];
?>
        <input type="text" name="pic" value="" placeholder="lien image" />
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
    $id = $elem['id_pokemon'];
    echo "<input type='hidden' name='id_pokemon' value='{$id}'>";
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
</body>
</html>
