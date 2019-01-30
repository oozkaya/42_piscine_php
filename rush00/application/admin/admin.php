<html>
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="../../css/index.css">
        <title>Gestion clients</title>
    </head>
    <header>
        <nav class="nav" role="navigation">
            <ul class="topmenu">
                <li><a href="users_admin.php">Admin</a></li>
                <li><a href="orders.php">Commande</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="products.php">Produits</a></li>
                <li><a href="categories.php">Catégories</a></li>
                <li><a href="../authorization/logout.php">Se déconnecter</a></li>
            </ul>
    </header> 
    <h3 id="client">Client:</h3>
    <div class="container">
    <?php include 'users.php';?>
    </div>
    <div class="footer">
			<p>
				&copy; Oozkaya & Pespalie - 2019
			</p>
		</div>
</html>