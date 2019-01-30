<?php
	$link = mysqli_connect("localhost", "root", "root42", "rush00");
	if (!$link)
		die("Connection failed\n" . mysqli_error($link));

	session_start();

	if (isset($_POST['submit']))
	{
		$pokemon = $_POST['submit'];
		if (!isset($_SESSION['cart'][$pokemon]))
			$_SESSION['cart'][$pokemon] = 1;
		else
			$_SESSION['cart'][$pokemon] += 1;
	}
	if (isset($_GET['cat']))
		$name_cat = $_GET['cat'];
	
	$sql = mysqli_query($link, "SELECT * FROM `categorie`");
	$all_categorie = array();

	while ($row = mysqli_fetch_assoc($sql))
		$all_categorie[] = $row;

	$sql2 = mysqli_query($link, "SELECT p.id_pokemon, p.nom, p.prix, p.image
	FROM `pokemon` p
	INNER JOIN `cat_poke` cp on p.id_pokemon = cp.id_pokemon
	INNER JOIN `categorie` c on c.id_cat = cp.id_cat
	where c.nom in ('$name_cat') ORDER BY p.prix ASC");
	$all_pokemon = array();
	while ($row = mysqli_fetch_assoc($sql2))
		$all_pokemon[] = $row;
?>
<html>
<head>
    <meta charset="UTF-8"/>
	<link rel="stylesheet" href="../../css/items/pokemon.css">
    <title><?php echo "Pokemon ".ucfirst($name_cat); ?></title>
</head>
<body>
    <header>
        <nav class="nav" role="navigation">
            <ul class="topmenu">
                <li><a href="../../index.php">Accueil</a></li>
                <li class="has-children"><a href="#">Catégories</a>
                    <ul class="sous-menu">
					<?php
foreach ($all_categorie as $cat) 
	{
		echo "<li><a href='pokemon.php?cat=".$cat['nom']."'>";
		echo "Pokemon ".ucfirst($cat['nom'])."</a></li>\n";
	}
?>
                    </ul>
                </li>
                <li><a href="../authorization/panier.php">Panier</a></li>
                <li><a href = "../../contact.php">Contact</a></li>
<?php
	if((isset($_SESSION['loggued_on_user']) && $_SESSION['loggued_on_user'] == "") || !isset($_SESSION['loggued_on_user']))
	echo '<li><a href = "../authorization/login.html">Se connecter</a></li>';
else
	echo '<li><a href = "../authorization/logout.php">Se déconnecter</a></li>';
?>
            </ul>
        </nav>
    </header>
<?php
		echo "<form id='produit' action='pokemon.php?cat=".$name_cat."' method='post'>\n";
	foreach ($all_pokemon as $poke)
	{
		echo "<div class ='detail'><img id='lokh' src='".$poke['image']."'/><br />";
		echo "Nom: ".ucfirst($poke['nom'])." <br />";
		echo "Prix: ".$poke['prix']."u<br />";
		echo "<button name='submit' type='submit' value='".$poke['nom']."'>Ajouter</button><br /></div>";
	}
?>
<div class="footer">
	<p>
		&copy; Oozkaya & Pespalie - 2019
	</p>
</div>
	</body>
</html>