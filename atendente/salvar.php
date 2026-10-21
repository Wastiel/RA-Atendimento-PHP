<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';


$id = $_POST['id'];

if(empty($id)){

    $sql = "

        INSERT INTO atendente (

            login,
            senha,
            nome,
            cpf,
            tipo_acesso,
            ativo

        )

        VALUES (

            :login,
            :senha,
            :nome,
            :cpf,
            :tipo_acesso,
            'S'

        )

    ";

} else {

    $sql = "

        UPDATE atendente

        SET

            login = :login,
            senha = :senha,
            nome = :nome,
            cpf = :cpf,
            tipo_acesso = :tipo_acesso

        WHERE id_atendente = :id

    ";
}

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':login', $_POST['login']);
$stmt->bindValue(':senha', $_POST['senha']);
$stmt->bindValue(':nome', $_POST['nome']);
$stmt->bindValue(':cpf', $_POST['cpf']);
$stmt->bindValue(':tipo_acesso', $_POST['tipo_acesso']);

if(!empty($id)){
    $stmt->bindValue(':id', $id);
}

$stmt->execute();

header('Location: listar.php');
exit;