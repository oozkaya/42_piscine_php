<?php
	session_start();

	$_SESSION['loggued_on_user'] = "";
	$_SESSION['cart'] = array();

	header("Location: ../../index.php");
	exit();
?>