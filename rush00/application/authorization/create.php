<?php
	$link = mysqli_connect("localhost", "root", "root42", "rush00");
	if (!$link)
		die("Connection failed\n" . mysqli_error($link));

	function ft_error()
	{
		echo "ERROR\n";
		exit(-1);
	}

	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$email = $_POST['email'];
	$passwd = $_POST['passwd'];
	$submit = $_POST['submit'];

	if ($nom === "" || $prenom === "" || $email === "" || $passwd  === "")
		ft_error();
	if ($submit == "OK")
	{
		$passwd = hash("whirlpool", $passwd);
		$logQuery = mysqli_query($link, "SELECT * FROM `client`");
		while ($row = mysqli_fetch_array($logQuery))
		{
			if($row['email'] == $email){
			echo "This email is already used\n";
			exit(-1);
			}
		}
		if (mysqli_query($link, "INSERT INTO `client` (nom, prenom, email, passwd) VALUES ('$nom', '$prenom', '$email', '$passwd')"))
			header("location: ../../index.php");
		else
			print("ERROR\n");
	}
	else
		ft_error();
?>