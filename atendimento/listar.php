<?php

require '../includes/validarLogin.php';
require '../includes/conexao.php';

$sql = "

SELECT

    a.id_atendimento,

    ta.tipo_atendimento,

    atd.nome AS atendente,

    c.nome AS cliente,

    a.dt_inicio,
    a.dt_fim,

    a.descricao,

    a.ativo

FROM atendimento a

INNER JOIN tipo_atendimento ta
    ON ta.id_tipo_atendimento = a.id_tipo_atendimento

INNER JOIN atendente atd
    ON atd.id_atendente = a.id_atendente

INNER JOIN cliente c
    ON c.id_cliente = a.id_cliente

ORDER BY a.dt_inicio DESC

";

$atendimentos = $pdo->query($sql)->fetchAll();

require '../includes/header.php';
require '../includes/menu.php';

?>

<div class="border-start border-4 border-warning ps-3 mb-4">

    <h2 class="page-title">
        Atendimentos
    </h2>

    <p class="page-description">
        Cadastro e acompanhamento dos atendimentos.
    </p>

</div>

<div class="card shadow-sm">

    <div class="card-body">

        <table class="table table-striped table-hover align-middle mb-0">

            <thead>

                <tr>

                    <th width="80">ID</th>
                    <th>Tipo</th>
                    <th>Cliente</th>
                    <th width="170">Início</th>
                    <th width="160" class="text-center">Situação</th>
                    <th width="399">Ações</th>
                    <th width="25">Detalhes</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach ($atendimentos as $atendimento): ?>

                    <tr>

                        <td>
                            <?= $atendimento['id_atendimento'] ?>
                        </td>

                        <td>
                            <?= $atendimento['tipo_atendimento'] ?>
                        </td>

                        <td>
                            <?= $atendimento['cliente'] ?>
                        </td>

                        <td>
                            <?= date(
                                'd/m/Y H:i',
                                strtotime($atendimento['dt_inicio'])
                            ) ?>
                        </td>

                        <td class="text-center">

                            <?php if ($atendimento['ativo'] == 'N'): ?>

                                <span class="badge badge-inativo">
                                    <i class="bi bi-x-circle-fill"></i>
                                    Cancelado
                                </span>

                            <?php elseif (empty($atendimento['dt_fim'])): ?>

                                <span class="badge badge-aberto">
                                    <i class="bi bi-clock-fill"></i>
                                    Em Aberto
                                </span>

                            <?php else: ?>

                                <span class="badge badge-concluido">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Concluído
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

    <div class="d-flex gap-1">

        <a
            href="form.php?id=<?= $atendimento['id_atendimento'] ?>"
            class="btn btn-eeepe-warning btn-sm"
        >
            <i class="bi bi-pencil-square"></i>
            Editar
        </a>

        <?php if (
            $atendimento['ativo'] == 'S'
            && empty($atendimento['dt_fim'])
        ): ?>

            <a
                href="concluir.php?id=<?= $atendimento['id_atendimento'] ?>"
                class="btn btn-success btn-sm btn-status"
            >
                <i class="bi bi-check-circle"></i>
                Concluir
            </a>

        <?php endif; ?>

        <?php if ($atendimento['ativo'] == 'S'): ?>

            <a
                href="toggleAtivo.php?id=<?= $atendimento['id_atendimento'] ?>"
                class="btn btn-secondary btn-sm btn-status"
            >
                <i class="bi bi-pause-circle"></i>
                Cancelar
            </a>

        <?php else: ?>

            <a
                href="toggleAtivo.php?id=<?= $atendimento['id_atendimento'] ?>"
                class="btn btn-secondary btn-sm btn-status"
            >
                <i class="bi bi-play-circle"></i>
                Reativar
            </a>

        <?php endif; ?>

    </div>

</td>

                        <td class="text-center">

                            <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse"
                                data-bs-target="#detalhes<?= $atendimento['id_atendimento'] ?>">
                                <i class="bi bi-chevron-down"></i>
                            </button>

                        </td>

                    </tr>
                    <tr>

                        <td colspan="7" class="p-0 border-0">

                            <div class="collapse" id="detalhes<?= $atendimento['id_atendimento'] ?>">

                                <div class="card card-body bg-light border-0 rounded-0">

                                    <div class="row">

                                        <div class="col-md-4">

                                            <strong>Atendente</strong>

                                            <br>

                                            <?= $atendimento['atendente'] ?>

                                        </div>

                                        <div class="col-md-4">

                                            <strong>Data Início</strong>

                                            <br>

                                            <?= date(
                                                'd/m/Y H:i',
                                                strtotime($atendimento['dt_inicio'])
                                            ) ?>

                                        </div>

                                        <div class="col-md-4">

                                            <strong>Data Fim</strong>

                                            <br>

                                            <?= $atendimento['dt_fim']
                                                ? date(
                                                    'd/m/Y H:i',
                                                    strtotime($atendimento['dt_fim'])
                                                )
                                                : '-' ?>

                                        </div>

                                    </div>

                                    <hr>

                                    <div>

                                        <strong>Descrição</strong>

                                        <p class="mt-2 mb-0">

                                            <?= nl2br(
                                                htmlspecialchars(
                                                    $atendimento['descricao']
                                                )
                                            ) ?>

                                        </p>

                                    </div>

                                </div>

                            </div>

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
        Novo Atendimento
    </a>

</div>

<?php require '../includes/footer.php'; ?>