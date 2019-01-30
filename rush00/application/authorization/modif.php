<?php
	$link = mysqli_connect("localhost", "root", "root42", "rush00");
	if (!$link)
        die("Connection failed\n" . mysqli_error($link));

    $email = $_POST['email'];
    $oldpw = hash("whirlpool", $_POST['oldpw']);
    $newpw = hash("whirlpool", $_POST['newpw']);

    if ($email === "" || $oldpw  === "" || $newpw === "")
    {
        echo ("ERROR\n");
        exit (-1);
    }
    if ($_POST['submit'] == "Modifier")
    {
        if (!strstr($email, "@"))
        {
            $logAdmin = mysqli_query($link, "SELECT * FROM `admin` WHERE login = '$email'");
            $row = mysqli_fetch_array($logAdmin);
            if ($row){
                if ($row['passwd'] == $oldpw)
                {
                    mysqli_query($link, "UPDATE `admin` SET passwd = '$newpw' WHERE login = '$email'");
                    echo "The password has been changed\n";
                    header("Location: ../../index.php");
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
            if ($row['passwd'] == $oldpw)
            {
                mysqli_query($link, "UPDATE `client` SET passwd = '$newpw' WHERE email = '$email'");
                echo "The password has been changed\n";
                header("Location: ../../index.php");
            }
            else
                echo "Wrong Password\n";
            }
        else
            echo "Wrong Login\n";
    }
?>
