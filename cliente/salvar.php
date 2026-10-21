<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';


$id = $_POST['id'];

if(empty($id)){

    $sql = "

        INSERT INTO cliente (

            nome,
            cpf,
            telefone,
            ativo

        )

        VALUES (

            :nome,
            :cpf,
            :telefone,
            'S'

        )

    ";

} else {

    $sql = "

        UPDATE cliente

        SET

            nome = :nome,
            cpf = :cpf,
            telefone = :telefone

        WHERE id_cliente = :id

    ";
}

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':nome', $_POST['nome']);
$stmt->bindValue(':cpf', $_POST['cpf']);
$stmt->bindValue(':telefone', $_POST['telefone']);

if(!empty($id)){
    $stmt->bindValue(':id', $id);
}

$stmt->execute();

header('Location: listar.php');
exit;