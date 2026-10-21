<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';


$id = $_GET['id'] ?? null;

$cliente = [

    'id_cliente' => '',
    'nome' => '',
    'cpf' => '',
    'telefone' => ''

];

if ($id) {

    $stmt = $pdo->prepare("
        SELECT *
        FROM cliente
        WHERE id_cliente = :id
    ");

    $stmt->bindValue(':id', $id);

    $stmt->execute();

    $cliente = $stmt->fetch();
}

require '../includes/header.php';
require '../includes/menu.php';

?>

<div class="mb-4">

    <h2 class="fw-bold text-eeepe">

        <?= $id
            ? 'Editar Cliente'
            : 'Novo Cliente'
        ?>

    </h2>

    <p class="text-muted mb-0">

        <?= $id
            ? 'Altere as informações do cliente.'
            : 'Cadastre um novo cliente no sistema.'
        ?>

    </p>

</div>

<div class="card shadow-sm">

    <div class="card-body">

        <form action="salvar.php" method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= $cliente['id_cliente'] ?>"
            >

            <div class="mb-3">

                <label
                    for="nome"
                    class="form-label fw-semibold"
                >
                    Nome
                </label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    class="form-control"
                    value="<?= $cliente['nome'] ?>"
                    required
                    autofocus
                >

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label
                        for="cpf"
                        class="form-label fw-semibold"
                    >
                        CPF
                    </label>

                    <input
                        type="text"
                        id="cpf"
                        name="cpf"
                        class="form-control"
                        value="<?= $cliente['cpf'] ?>"
                        required
                    >

                </div>

                <div class="col-md-6 mb-3">

                    <label
                        for="telefone"
                        class="form-label fw-semibold"
                    >
                        Telefone
                    </label>

                    <input
                        type="text"
                        id="telefone"
                        name="telefone"
                        class="form-control"
                        value="<?= $cliente['telefone'] ?>"
                    >

                </div>

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