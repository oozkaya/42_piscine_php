<?php
	$link = mysqli_connect("localhost", "root", "root42", "rush00");
	if (!$link)
		die("Connection failed\n" . mysqli_error($link));

	session_start();
	$sql = mysqli_query($link, "SELECT * FROM `pokemon`");
	$all_pokemon = array();

	while ($row = mysqli_fetch_assoc($sql))
		$all_pokemon[] = $row;

	$sql = mysqli_query($link, "SELECT * FROM `categorie`");
	$all_categorie = array();

	while ($row = mysqli_fetch_assoc($sql))
		$all_categorie[] = $row;
?>
<html>
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="../../css/index.css">
        <title>Mini_Shop</title>
    </head>
    <body>
        <header>
            <nav class="nav" role="navigation">
                <ul class="topmenu">
                    <li><a href="../../index.php?page=home">Accueil</a></li>
                    <li class="has-children"><a href="#">Catégories</a>
                        <ul class="sous-menu">
<?php
	foreach ($all_categorie as $cat) 
	{
		echo "<li><a href='../items/pokemon.php?cat=".$cat['nom']."'>";
		echo "Pokemon ".ucfirst($cat['nom'])."</a></li>\n";
	}
?>
                        </ul>
                    </li>
                    <li><a href="panier.php">Panier</a></li>
					<li><a href = "../../contact.php">Contact</a></li>
<?php
	if((isset($_SESSION['loggued_on_user']) && $_SESSION['loggued_on_user'] == "") || !isset($_SESSION['loggued_on_user']))
	echo '<li><a href = "login.html">Se connecter</a></li>';
else
	echo '<li><a href = "logout.php">Se déconnecter</a></li>';
?>
                </ul>
            </nav>
		</header>
		<div class=tab_panier>
		<table>
			<thead>
				<th>Produit</th>
				<th>Quantité</th>
				<th>Prix a l'unite</th>
				<th>Prix total</th>
				<th>Supprimer</th>
			</thead>
		</div>
<?php
	$total = 0;
	if (isset($_SESSION['cart']))
	{
		foreach ($_SESSION['cart'] as $prod => $qty)
		{
			foreach ($all_pokemon as $pokemon)
			{
				if ($prod == $pokemon['nom'] && $qty != 0)
				{
					echo "<tr>\n";
					echo "<td>".$pokemon['nom']."</td>\n";
					echo "<td>".$qty."</td>\n";
					echo "<td>".$pokemon['prix']."</td>\n";
					echo "<td>".$qty * $pokemon['prix']."</td>\n";
					echo "<td><form action='panier.php' method='post'><button name='del_poke' type='submit' value='".$pokemon['nom']."'>X</button>";
					echo "</tr>\n";
					$total += $qty * $pokemon['prix'];
				}
			}
		}
	}
?>
			<tr>
				<td></td>
				<td></td>
				<td>TOTAL = </td>
				<td><?php echo $total; ?></td>
			</tr>
		</table>
		<form action="panier.php" method="post">
			<input name="submit" type="submit" value="Commander" /> <br />
			<input name="submit" type="submit" value="Vider le panier" />
		</form>
		<div class="footer">
			<p>
				&copy; Oozkaya & Pespalie - 2019
			</p>
		</div>
	</body>
</html>
<?php
	if (isset($_POST['del_poke']))
	{
		$poke_delete = $_POST['del_poke'];
		$_SESSION['cart'][$poke_delete] = 0;
		header("Location: panier.php");
		exit();
	}
	if (isset($_POST['submit']))
	{
		if ($_POST['submit'] == "Vider le panier")
		{
			$_SESSION['cart'] = array();
			header("Location: panier.php");
			exit();
		}
		if ($_POST['submit'] == "Commander" && $total != 0 && $_SESSION['loggued_on_user'])
		{
			$sql = mysqli_query($link, "SELECT * FROM `client`");
			$all_clients = array();

			while ($row = mysqli_fetch_assoc($sql))
				$all_clients[] = $row;
			foreach ($all_clients as $client)
			{
				if ($_SESSION['loggued_on_user'] == $client['email'])
				{
					$id_client = $client['id_client'];
					break ;
				}
			}
			mysqli_query($link, "INSERT INTO `commande` (id_client, prix) VALUES ('$id_client', '$total')");
			$_SESSION['cart'] = array();
		}
		else if ($_POST['submit'] == "Commander" && $total != 0 && empty($_SESSION['loggued_on_user']))
		{
			header("Location: create.html");
			exit();
		}
	}
?>