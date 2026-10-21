<?php

require '../includes/validarLogin.php';
require '../includes/conexao.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("
    UPDATE atendimento
       SET dt_fim = NOW()
     WHERE id_atendimento = :id
");

$stmt->bindValue(':id', $id);

$stmt->execute();

header('Location: listar.php');