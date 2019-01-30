<?php
	$link = mysqli_connect("localhost", "root", "root42", "rush00");
	if (!$link)
        die("Connection failed\n" . mysqli_error($link));

	session_start();

    $email = $_POST['email'];
    $passwd = hash("whirlpool", $_POST['passwd']);
    $submit = isset($_POST['submit']);
	$delete = isset($_POST['delete']);


    if ($email == "" || $passwd  == "")
    {
        echo ("ERROR\n");
        exit (-1);
    }
    if ($submit == "OK")
    {
        if (!strstr($email, "@"))
        {
            $logAdmin = mysqli_query($link, "SELECT * FROM `admin` WHERE login = '$email'");
            $row = mysqli_fetch_array($logAdmin);
            if ($row){
                if ($row['passwd'] == $passwd)
                {
                    $_SESSION['loggued_on_user'] = $email;
                    header("location: ../admin/admin.php");
                }
                else
                    echo "Wrong Password\n";
                }
            else
                echo "Wrong Login\n";
        }
        $logQuery = mysqli_query($link, "SELECT * FROM `client` WHERE email = '$email'");
        $row = mysqli_fetch_array($logQuery);
        if ($row){
            if ($row['passwd'] == $passwd)
            {
				$_SESSION['loggued_on_user'] = $email;
				header("location: ../../index.php");
            }
            else
                echo "Wrong Password\n";
            }
        else
            echo "Wrong Login\n";
    }
    if ($delete == "Supprimer le compte")
    {
        if (!strstr($email, "@"))
        {
            $logAdmin = mysqli_query($link, "SELECT * FROM `admin` WHERE login = '$email'");
            $row = mysqli_fetch_array($logAdmin);
            if ($row)
            {
                if ($row['passwd'] == $passwd)
                {
                    mysqli_query($link, "DELETE FROM `admin` WHERE login = '$email'");
                    $_SESSION['loggued_on_user'] = "";
                    header("location: ../../index.php");
                }
                else
                    echo "Wrong password\n";
            }
            else
                echo "Wrong login\n";
        }
        $logQuery = mysqli_query($link, "SELECT * FROM `client` WHERE email = '$email'");
        $row = mysqli_fetch_array($logQuery);
        if ($row){
            if ($row['passwd'] == $passwd)
            {
                mysqli_query($link, "DELETE FROM `client` WHERE email = '$email'");
                $_SESSION['loggued_on_user'] = "";
                header("location: ../../index.php");
            }
            else
                echo "Wrong Password\n";
            }
        else
            echo "Wrong Login\n";
    }
?>

