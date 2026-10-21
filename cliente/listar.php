<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';


$sql = "
    SELECT
        id_cliente,
        nome,
        cpf,
        telefone,
        ativo
    FROM cliente
    ORDER BY nome
";

$clientes = $pdo->query($sql)->fetchAll();

require '../includes/header.php';
require '../includes/menu.php';

?>

<div class="border-start border-4 border-warning ps-3 mb-4">

    <h2 class="page-title">
        Cliente
    </h2>

    <p class="page-description">
        Cadastro e manutenção de clientes.
    </p>

</div>

<div class="card shadow-sm">

    <div class="card-body">

    <table class="table table-striped table-hover align-middle mb-0">

    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>CPF</th>
        <th>Telefone</th>
        <th class="text-center">Status</th>
        <th width="220">Ações</th>
    </tr>

    <?php foreach($clientes as $cliente): ?>

        <tr>

            <td><?= $cliente['id_cliente'] ?></td>
            <td><?= $cliente['nome'] ?></td>
            <td><?= $cliente['cpf'] ?></td>
            <td><?= $cliente['telefone'] ?></td>
            <td class="text-center">
                    <?php if($cliente['ativo'] == 'S'): ?>

                        <span class="badge badge-ativo">
                            <i class="bi bi-check-circle-fill"> </i>
                            Ativo
                        </span>

                    <?php else: ?>

                        <span class="badge badge-inativo">
                            <i class="bi bi-x-circle-fill"> </i>
                            Inativo
                        </span>

                    <?php endif; ?>

                </td>

            <td>
                   <a
                        href="form.php?id=<?= $cliente['id_cliente'] ?>"
                        class="btn btn-eeepe-warning btn-sm"
                    >
                        <i class="bi bi-pencil-square"></i>
                        Editar
                    </a>

                    <a
                        href="toggleAtivo.php?id=<?= $cliente['id_cliente'] ?>"
                        class="btn btn-secondary btn-sm btn-status"
                    >

                        <?php if($cliente['ativo'] == 'S'): ?>

                            <i class="bi bi-pause-circle"></i>
                            Desativar

                        <?php else: ?>

                            <i class="bi bi-play-circle"></i>
                            Ativar

                        <?php endif; ?>

                    </a>

            </td>

        </tr>

    <?php endforeach; ?>

    </table>

    </div>

</div>
    
<div class="d-flex justify-content-end mt-3">

    <a
        href="form.php"
        class="btn btn-eeepe"
    >
        <i class="bi bi-plus-circle"></i>
        Novo Cliente
    </a>

</div>    


<?php require '../includes/footer.php'; ?>