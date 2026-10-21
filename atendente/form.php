<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';


$id = $_GET['id'] ?? null;

$atendente = [

    'id_atendente' => '',
    'login' => '',
    'senha' => '',
    'nome' => '',
    'cpf' => '',
    'tipo_acesso' => 'USUARIO'

];

if ($id) {

    $stmt = $pdo->prepare("
        SELECT *
        FROM atendente
        WHERE id_atendente = :id
    ");

    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $atendente = $stmt->fetch();
}

require '../includes/header.php';
require '../includes/menu.php';

?>

<div class="mb-4">

    <h2 class="fw-bold text-eeepe">

        <?= $id
            ? 'Editar Atendente'
            : 'Novo Atendente'
        ?>

    </h2>

    <p class="text-muted mb-0">

        <?= $id
            ? 'Altere as informações do atendente.'
            : 'Cadastre um novo atendente no sistema.'
        ?>

    </p>

</div>



<div class="card shadow-sm">

    <div class="card-body">

        <form action="salvar.php" method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= $atendente['id_atendente'] ?>"
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
                    value="<?= $atendente['nome'] ?>"
                    required
                    autofocus
                >

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label
                        for="login"
                        class="form-label fw-semibold"
                    >
                        Login
                    </label>

                    <input
                        type="text"
                        id="login"
                        name="login"
                        class="form-control"
                        value="<?= $atendente['login'] ?>"
                        required
                    >

                </div>

                <div class="col-md-6 mb-3">

                    <label
                        for="tipo_acesso"
                        class="form-label fw-semibold"
                    >
                        Perfil
                    </label>

                    <select
                        id="tipo_acesso"
                        name="tipo_acesso"
                        class="form-select"
                    >

                        <option
                            value="U"
                            <?= $atendente['tipo_acesso'] == 'USUARIO' ? 'selected' : '' ?>
                        >
                            Usuário
                        </option>

                        <option
                            value="A"
                            <?= $atendente['tipo_acesso'] == 'ADMIN' ? 'selected' : '' ?>
                        >
                            Administrador
                        </option>

                    </select>

                </div>

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
                        value="<?= $atendente['cpf'] ?>"
                        required
                    >

                </div>

                <div class="col-md-6 mb-3">

                    <label
                        for="senha"
                        class="form-label fw-semibold"
                    >
                        Senha
                    </label>

                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        class="form-control"
                        value="<?= $atendente['senha'] ?>"
                        required
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