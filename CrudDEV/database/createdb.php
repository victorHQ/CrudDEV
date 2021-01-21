<?php

require_once 'vardb.php';

try {
    $conn = new PDO("mysql:host=$host", $username, $passwd);

    //Setando PDO para modo de erro
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $dbname = "`" . str_replace("`", "``", $dbname) . "`";
    $conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
    $conn->query("use $dbname");

    $conn->query("CREATE TABLE IF NOT EXISTS DESENVOLVEDOR(DevID int NOT NULL AUTO_INCREMENT, Nome varchar(30) NOT NULL, Sobrenome varchar(70) NOT NULL,
                      Email varchar(100) UNIQUE NOT NULL, Telefone numeric(11) NOT NULL, Especialidade char(9) NOT NULL,
                      Senioridade char(6) NOT NULL, Tecnologia varchar(50) NOT NULL, Experiencia text(500),
                      PRIMARY KEY(DevID))");

} catch (PDOException $ex) {
    echo $conn . "<br>" . $ex->getMessage();
}

$conn = null;
