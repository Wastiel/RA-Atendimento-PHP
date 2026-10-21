<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';



$id = $_GET['id'] ?? null;

$tipo = [
    'id_tipo_atendimento' => '',
    'tipo_atendimento' => ''
];

if ($id) {

    $stmt = $pdo->prepare("
        SELECT *
        FROM tipo_atendimento
        WHERE id_tipo_atendimento = :id
    ");

    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $tipo = $stmt->fetch();
}

require '../includes/header.php';
require '../includes/menu.php';

?>

<div class="border-start border-4 border-warning ps-3 mb-4">

    <h2 class="fw-bold text-eeepe">

        <?= $id
            ? '✏️ Editar Tipo de Atendimento'
            : '➕ Novo Tipo de Atendimento'
        ?>

    </h2>

    <p class="text-muted mb-0">

        <?= $id
            ? 'Altere as informações do tipo de atendimento.'
            : 'Cadastre um novo tipo de atendimento no sistema.'
        ?>

    </p>

</div>

<div class="card shadow-sm">

    <div class="card-body">

        <form action="salvar.php" method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= $tipo['id_tipo_atendimento'] ?>"
            >

            <div class="mb-3">

                <label
                    for="tipo_atendimento"
                    class="form-label fw-semibold"
                >
                    Tipo de Atendimento
                </label>

                <input
                    type="text"
                    id="tipo_atendimento"
                    name="tipo_atendimento"
                    class="form-control"
                    value="<?= $tipo['tipo_atendimento'] ?>"
                    required
                    autofocus
                >

            </div>

            <div class="d-flex justify-content-end gap-2">

                <a
                    href="listar.php"
                    class="btn btn-outline-secondary"
                >
                    <i class="bi bi-arrow-left"></i>
                    Voltar
                </a>

                <button
                    type="submit"
                    class="btn btn-eeepe"
                >
                    <i class="bi bi-check-circle"></i>
                    Salvar
                </button>

            </div>

        </form>

    </div>

</div>

<?php require '../includes/footer.php'; ?>

