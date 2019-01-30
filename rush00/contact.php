<html>
<?php
$link = mysqli_connect("localhost", "root", "root42", "rush00");
if (!$link)
    die("Connection failed\n" . mysqli_error($link));
$sql = mysqli_query($link, "SELECT * FROM `categorie`");
$all_categorie = array();
while ($row = mysqli_fetch_assoc($sql))
    $all_categorie[] = $row;
?>
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="css/index.css">
    <title>Contact</title>
</head>
<body>
<header>
    <nav class="nav" role="navigation">
        <ul class="topmenu">
            <li><a href="index.php">Accueil</a></li>
            <li class="has-children"><a href="#">Catégories</a>
                <ul class="sous-menu">
<?php
	foreach ($all_categorie as $cat) 
	{
		echo "<li><a href='application/items/pokemon.php?cat=".$cat['nom']."'>";
		echo "Pokemon ".ucfirst($cat['nom'])."</a></li>\n";
	}
?>
                </ul>
            </li>
            <li><a href="application/authorization/panier.php">Panier</a></li>
<?php
    session_start();
	if((isset($_SESSION['loggued_on_user']) && $_SESSION['loggued_on_user'] == "") || !isset($_SESSION['loggued_on_user']))
		echo '<li><a href = "application/authorization/login.html">Se connecter</a></li>';
	else
		echo '<li><a href = "application/authorization/logout.php">Se déconnecter</a></li>';
?>
        </ul>
</header>
<div class="contact">
    <h1>Contact</h1>
    <p>
        PokeShop<br />
        Céladopole City, 21458<br />
        Kanto<br />
        Telephone: <br />
        xx.xx.xx.xx.xx<br /><br />
        <img id="shop" src="celadopole.png">
    </p>
</div>
<div class="footer">
			<p>
				&copy; Oozkaya & Pespalie - 2019
			</p>
		</div>
</body>
</html>