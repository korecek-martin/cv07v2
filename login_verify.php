<?php

session_start();
if (isset($_REQUEST["login"], $_REQUEST["password"]))
{

    try {
        $conn = new PDO(
            "mysql:host=localhost;dbname=student",
            "korecek",
            "asdfghjkl");
        $conn->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);

        $stm = $conn->prepare("SELECT * FROM users WHERE login = :login");
        $stm->bindParam(":login",$_REQUEST["login"]);
        $stm->execute();

        $stm->setFetchMode(PDO::FETCH_OBJ);
        while($row = $stm->fetch()) {
            if (password_verify($_REQUEST["password"], $row->password)) {
                echo 'Password is valid!';
                $_SESSION["name"] = $row->name;
                header('Location: /profile.php');
            } else {
                echo 'Invalid password.';
                header('Location: /log.php');
            }
        }


    }   catch (PDOException $exception) {
        $conn = null;
        die($exception->getMessage());
    }
}
else {
    header('Location: /log.php');
}








