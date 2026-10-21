<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';



$id = $_POST['id'];
$tipoAtendimento = $_POST['tipo_atendimento'];

if(empty($id)){

    $sql = "

        INSERT INTO tipo_atendimento (

            tipo_atendimento,
            ativo

        )

        VALUES (

            :tipo_atendimento,
            'S'

        )

    ";

} else {

    $sql = "

        UPDATE tipo_atendimento

        SET

            tipo_atendimento = :tipo_atendimento

        WHERE id_tipo_atendimento = :id

    ";
}

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':tipo_atendimento', $tipoAtendimento);

if(!empty($id)){
    $stmt->bindValue(':id', $id);
}

$stmt->execute();

header('Location: listar.php');
exit;