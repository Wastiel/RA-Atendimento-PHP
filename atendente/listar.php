<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';


$sql = "
    SELECT
        id_atendente,
        login,
        nome,
        cpf,
        tipo_acesso,
        ativo
    FROM atendente
    ORDER BY nome
";

$atendentes = $pdo->query($sql)->fetchAll();

require '../includes/header.php';
require '../includes/menu.php';

?>

<div class="border-start border-4 border-warning ps-3 mb-4">

    <h2 class="page-title">
        Atendentes
    </h2>

    <p class="page-description">
        Cadastro e manutenção dos atendentes do sistema.
    </p>

</div>

<div class="card shadow-sm">

    <div class="card-body">

        <table class="table table-striped table-hover align-middle mb-0">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Login</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th class="text-center">Perfil</th>
                    <th class="text-center">Status</th>
                    <th width="220">Ações</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($atendentes as $atendente): ?>

                    <tr>

                        <td><?= $atendente['id_atendente'] ?></td>

                        <td><?= $atendente['login'] ?></td>

                        <td><?= $atendente['nome'] ?></td>

                        <td><?= substr($atendente['cpf'], 0, 3) ?>.***.***-**</td>

                        <td class="text-center">

                            <?php if ($atendente['tipo_acesso'] == 'A'): ?>

                                <span class="badge badge-admin">

                                    <i class="bi bi-shield-lock-fill"></i>

                                    Administrador

                                </span>

                            <?php else: ?>

                                <span class="badge badge-usuario">

                                    <i class="bi bi-person-fill"></i>

                                    Usuário

                                </span>

                            <?php endif; ?>

                        </td>

                        <td class="text-center">

                            <?php if ($atendente['ativo'] == 'S'): ?>

                                <span class="badge badge-ativo">

                                    <i class="bi bi-check-circle-fill"></i>

                                    Ativo

                                </span>

                            <?php else: ?>

                                <span class="badge badge-inativo">

                                    <i class="bi bi-x-circle-fill"></i>

                                    Inativo

                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <a href="form.php?id=<?= $atendente['id_atendente'] ?>" class="btn btn-eeepe-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                                Editar
                            </a>

                            <a href="toggleAtivo.php?id=<?= $atendente['id_atendente'] ?>"
                                class="btn btn-secondary btn-sm btn-status">

                                <?php if ($atendente['ativo'] == 'S'): ?>

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
        Novo Atendente
    </a>

</div>

<?php require '../includes/footer.php'; ?>