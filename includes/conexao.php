<?php

$host = "mariadb";
$banco = "RAtendimento";
$usuario = "root";
$senha = "mypass";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8",
        $usuario,
        $senha
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {

    echo "Erro na conexão: " . $e->getMessage();

}