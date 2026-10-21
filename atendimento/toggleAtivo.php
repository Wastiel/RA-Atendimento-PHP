<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';


$id = $_GET['id'];

$stmt = $pdo->prepare("
    SELECT ativo
    FROM atendimento
    WHERE id_atendimento = :id
");

$stmt->bindValue(':id', $id);

$stmt->execute();

$atendimento = $stmt->fetch();

$novoStatus = $atendimento['ativo'] == 'S'
    ? 'N'
    : 'S';

$stmt = $pdo->prepare("
    UPDATE atendimento
    SET ativo = :ativo
    WHERE id_atendimento = :id
");

$stmt->bindValue(':ativo', $novoStatus);
$stmt->bindValue(':id', $id);

$stmt->execute();

header('Location: listar.php');
exit;