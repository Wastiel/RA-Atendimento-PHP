<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';


$id = $_GET['id'];

$stmt = $pdo->prepare("
    SELECT ativo
    FROM atendente
    WHERE id_atendente = :id
");

$stmt->bindValue(':id', $id);

$stmt->execute();

$atendente = $stmt->fetch();

$novoStatus = $atendente['ativo'] == 'S'
    ? 'N'
    : 'S';

$stmt = $pdo->prepare("
    UPDATE atendente
    SET ativo = :ativo
    WHERE id_atendente = :id
");

$stmt->bindValue(':ativo', $novoStatus);
$stmt->bindValue(':id', $id);

$stmt->execute();

header('Location: listar.php');
exit;