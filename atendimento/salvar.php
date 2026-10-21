<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';


$id = $_POST['id'];

if(empty($id)){

    $sql = "

        INSERT INTO atendimento (

            id_tipo_atendimento,
            id_atendente,
            id_cliente,

            dt_inicio,
            dt_fim,

            descricao,

            ativo

        )

        VALUES (

            :id_tipo_atendimento,
            :id_atendente,
            :id_cliente,

            :dt_inicio,
            :dt_fim,

            :descricao,

            'S'

        )

    ";

} else {

    $sql = "

        UPDATE atendimento

        SET

            id_tipo_atendimento = :id_tipo_atendimento,
            id_atendente = :id_atendente,
            id_cliente = :id_cliente,

            dt_inicio = :dt_inicio,
            dt_fim = :dt_fim,

            descricao = :descricao

        WHERE id_atendimento = :id

    ";
}

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':id_tipo_atendimento', $_POST['id_tipo_atendimento']);
$stmt->bindValue(':id_atendente', $_POST['id_atendente']);
$stmt->bindValue(':id_cliente', $_POST['id_cliente']);

$stmt->bindValue(':dt_inicio', $_POST['dt_inicio']);

$stmt->bindValue(
    ':dt_fim',
    empty($_POST['dt_fim'])
        ? null
        : $_POST['dt_fim']
);

$stmt->bindValue(':descricao', $_POST['descricao']);

if(!empty($id)){
    $stmt->bindValue(':id', $id);
}

$stmt->execute();

header('Location: listar.php');
exit;