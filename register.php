<?php
$name = $_REQUEST["name"];
$login = $_REQUEST["login"];
$password = password_hash($_REQUEST["password"], PASSWORD_ARGON2ID);


try {
    $conn = new PDO(
        "mysql:host=localhost;dbname=student",
        "korecek",
        "asdfghjkl");
    $conn->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO users (name,login,password) VALUES (:name,:login,:password)";
    $stm = $conn->prepare($sql);
    $stm->bindParam(":name",$name);
    $stm->bindParam(":login",$login);
    $stm->bindParam(":password",$password);
    $stm->execute();

    echo "uzivatel pridany";
    header('Location: /log.php');
}   catch (PDOException $exception) {
    $conn = null;
    die($exception->getMessage());
}