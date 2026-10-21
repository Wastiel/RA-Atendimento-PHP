<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';


$id = $_GET['id'];

$stmt = $pdo->prepare("
    SELECT ativo
    FROM cliente
    WHERE id_cliente = :id
");

$stmt->bindValue(':id', $id);

$stmt->execute();

$cliente = $stmt->fetch();

$novoStatus = $cliente['ativo'] == 'S'
    ? 'N'
    : 'S';

$stmt = $pdo->prepare("
    UPDATE cliente
    SET ativo = :ativo
    WHERE id_cliente = :id
");

$stmt->bindValue(':ativo', $novoStatus);
$stmt->bindValue(':id', $id);

$stmt->execute();

header('Location: listar.php');
exit;