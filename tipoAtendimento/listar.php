<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';

$sql = "
    SELECT
        id_tipo_atendimento,
        tipo_atendimento,
        ativo
    FROM tipo_atendimento
    ORDER BY tipo_atendimento
";

$tipos = $pdo->query($sql)->fetchAll();

require '../includes/header.php';
require '../includes/menu.php';

?>

<div class="border-start border-4 border-warning ps-3 mb-4">

    <h2 class="page-title">
        Tipos de Atendimento
    </h2>

    <p class="page-description">
        Cadastro e manutenção dos tipos de atendimento.
    </p>

</div>


<div class="card shadow-sm">

    <div class="card-body">

        <table class="table table-striped table-hover align-middle mb-0">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Tipo Atendimento</th>
                    <th class="text-center">Status</th>
                    <th width="220">Ações</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($tipos as $tipo): ?>

                    <tr>

                        <td><?= $tipo['id_tipo_atendimento'] ?></td>

                        <td><?= $tipo['tipo_atendimento'] ?></td>

                        <td class="text-center">

                            <?php if ($tipo['ativo'] == 'S'): ?>

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

                            <a href="form.php?id=<?= $tipo['id_tipo_atendimento'] ?>" class="btn btn-eeepe-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                                Editar
                            </a>


                            <a href="toggleAtivo.php?id=<?= $tipo['id_tipo_atendimento'] ?>"
                                class="btn btn-secondary btn-sm btn-status">

                                <?php if ($tipo['ativo'] == 'S'): ?>

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

            </tbody>

        </table>
    </div>
</div>
<div class="d-flex justify-content-end mt-3">

    <a href="form.php" class="btn btn-eeepe">
        <i class="bi bi-plus-circle"></i>
        Novo Tipo de Atendimento
    </a>

</div>

<?php require '../includes/footer.php'; ?>