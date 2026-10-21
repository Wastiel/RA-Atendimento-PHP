<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';



$id = $_GET['id'];

$sql = "
    SELECT ativo
    FROM tipo_atendimento
    WHERE id_tipo_atendimento = :id
";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':id', $id);

$stmt->execute();

$tipo = $stmt->fetch();

$novoStatus = $tipo['ativo'] == 'S'
    ? 'N'
    : 'S';

$sql = "
    UPDATE tipo_atendimento
    SET ativo = :ativo
    WHERE id_tipo_atendimento = :id
";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':ativo', $novoStatus);
$stmt->bindValue(':id', $id);

$stmt->execute();

header('Location: listar.php');
exit;