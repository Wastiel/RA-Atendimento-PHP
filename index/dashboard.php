<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';
require '../includes/conexao.php';

$totalClientes = $pdo
    ->query("SELECT COUNT(*) FROM cliente")
    ->fetchColumn();

$totalAtendentes = $pdo
    ->query("SELECT COUNT(*) FROM atendente")
    ->fetchColumn();

$totalTipos = $pdo
    ->query("SELECT COUNT(*) FROM tipo_atendimento")
    ->fetchColumn();

$totalAtendimentos = $pdo
    ->query("SELECT COUNT(*) FROM atendimento")
    ->fetchColumn();

require '../includes/header.php';
require '../includes/menu.php';

?>

<div class="border-start border-4 border-warning ps-3 mb-4">

    <h2 class="page-title">
        Dashboard
    </h2>

    <p class="page-description">
        Visão geral do sistema de atendimentos.
    </p>

</div>

<div class="row g-4">

    <div class="col-md-3">

        <div class="card shadow-sm dashboard-card h-100">

            <div class="card-body text-center">

                <i
                    class="bi bi-people-fill text-eeepe"
                    style="font-size: 2.5rem;"
                ></i>

                <h6 class="text-muted mt-3">
                    Clientes
                </h6>

                <h2 class="fw-bold text-eeepe">
                    <?= $totalClientes ?>
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm dashboard-card h-100">

            <div class="card-body text-center">

                <i
                    class="bi bi-person-badge-fill text-eeepe"
                    style="font-size: 2.5rem;"
                ></i>

                <h6 class="text-muted mt-3">
                    Atendentes
                </h6>

                <h2 class="fw-bold text-eeepe">
                    <?= $totalAtendentes ?>
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm dashboard-card h-100">

            <div class="card-body text-center">

                <i
                    class="bi bi-tags-fill text-eeepe"
                    style="font-size: 2.5rem;"
                ></i>

                <h6 class="text-muted mt-3">
                    Tipos de Atendimento
                </h6>

                <h2 class="fw-bold text-eeepe">
                    <?= $totalTipos ?>
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm dashboard-card h-100">

            <div class="card-body text-center">

                <i
                    class="bi bi-clipboard-check-fill text-eeepe"
                    style="font-size: 2.5rem;"
                ></i>

                <h6 class="text-muted mt-3">
                    Atendimentos
                </h6>

                <h2 class="fw-bold text-eeepe">
                    <?= $totalAtendimentos ?>
                </h2>

            </div>

        </div>

    </div>

</div>

<?php require '../includes/footer.php'; ?>