<?php

session_start();

require '../includes/conexao.php';

$login = $_POST['login'] ?? '';
$senha = $_POST['senha'] ?? '';

$stmt = $pdo->prepare("
    SELECT *
    FROM atendente
    WHERE login = :login
    AND senha = :senha
    AND ativo = 'S'
");

$stmt->bindValue(':login', $login);
$stmt->bindValue(':senha', $senha);

$stmt->execute();

$usuario = $stmt->fetch();

if ($usuario) {

    $_SESSION['usuario'] = [

        'id' => $usuario['id_atendente'],
        'nome' => $usuario['nome'],
        'tipo_acesso' => $usuario['tipo_acesso']

    ];

    header('Location: ../index/dashboard.php');
    exit;
}

header('Location: index.php?erro=1');
exit;