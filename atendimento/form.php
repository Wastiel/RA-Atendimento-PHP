<?php
require '../includes/validarLogin.php';
require '../includes/conexao.php';


$id = $_GET['id'] ?? null;

$atendimento = [

    'id_atendimento'      => '',
    'id_tipo_atendimento' => '',
    'id_atendente'        => '',
    'id_cliente'          => '',
    'dt_inicio'           => '',
    'dt_fim'              => '',
    'descricao'           => ''

];

if ($id) {

    $stmt = $pdo->prepare("
        SELECT *
        FROM atendimento
        WHERE id_atendimento = :id
    ");

    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $resultado = $stmt->fetch();

    if ($resultado) {
        $atendimento = $resultado;
    }
}

$tipos = $pdo->query("
    SELECT *
    FROM tipo_atendimento
    WHERE ativo = 'S'
    ORDER BY tipo_atendimento
")->fetchAll();

$atendentes = $pdo->query("
    SELECT *
    FROM atendente
    WHERE ativo = 'S'
    ORDER BY nome
")->fetchAll();

$clientes = $pdo->query("
    SELECT *
    FROM cliente
    WHERE ativo = 'S'
    ORDER BY nome
")->fetchAll();

require '../includes/header.php';
require '../includes/menu.php';

?>

<div class="border-start border-4 border-warning ps-3 mb-4">

    <h2 class="page-title">

        <?= $id
            ? 'Editar Atendimento'
            : 'Novo Atendimento'
        ?>

    </h2>

    <p class="page-description">

        <?= $id
            ? 'Altere as informações do atendimento.'
            : 'Cadastre um novo atendimento.'
        ?>

    </p>

</div>

<div class="card shadow-sm">

    <div class="card-body">

        <form action="salvar.php" method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= $atendimento['id_atendimento'] ?>"
            >

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label
                        for="id_tipo_atendimento"
                        class="form-label fw-semibold"
                    >
                        Tipo de Atendimento
                    </label>

                    <select
                        id="id_tipo_atendimento"
                        name="id_tipo_atendimento"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Selecione
                        </option>

                        <?php foreach ($tipos as $tipo): ?>

                            <option
                                value="<?= $tipo['id_tipo_atendimento'] ?>"
                                <?= $tipo['id_tipo_atendimento'] == $atendimento['id_tipo_atendimento']
                                    ? 'selected'
                                    : ''
                                ?>
                            >

                                <?= $tipo['tipo_atendimento'] ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label
                        for="id_cliente"
                        class="form-label fw-semibold"
                    >
                        Cliente
                    </label>

                    <select
                        id="id_cliente"
                        name="id_cliente"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Selecione
                        </option>

                        <?php foreach ($clientes as $cliente): ?>

                            <option
                                value="<?= $cliente['id_cliente'] ?>"
                                <?= $cliente['id_cliente'] == $atendimento['id_cliente']
                                    ? 'selected'
                                    : ''
                                ?>
                            >

                                <?= $cliente['nome'] ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label
                        for="id_atendente"
                        class="form-label fw-semibold"
                    >
                        Atendente
                    </label>

                    <select
                        id="id_atendente"
                        name="id_atendente"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Selecione
                        </option>

                        <?php foreach ($atendentes as $atendente): ?>

                            <option
                                value="<?= $atendente['id_atendente'] ?>"
                                <?= $atendente['id_atendente'] == $atendimento['id_atendente']
                                    ? 'selected'
                                    : ''
                                ?>
                            >

                                <?= $atendente['nome'] ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="col-md-3 mb-3">

                    <label
                        for="dt_inicio"
                        class="form-label fw-semibold"
                    >
                        Data Início
                    </label>

                    <input
                        type="datetime-local"
                        id="dt_inicio"
                        name="dt_inicio"
                        class="form-control"
                        value="<?= $atendimento['dt_inicio']
                            ? date('Y-m-d\TH:i', strtotime($atendimento['dt_inicio']))
                            : ''
                        ?>"
                        required
                    >

                </div>

                <div class="col-md-3 mb-3">

                    <label
                        for="dt_fim"
                        class="form-label fw-semibold"
                    >
                        Data Fim
                    </label>

                    <input
                        type="datetime-local"
                        id="dt_fim"
                        name="dt_fim"
                        class="form-control"
                        value="<?= $atendimento['dt_fim']
                            ? date('Y-m-d\TH:i', strtotime($atendimento['dt_fim']))
                            : ''
                        ?>"
                    >

                </div>

            </div>

            <div class="mb-3">

                <label
                    for="descricao"
                    class="form-label fw-semibold"
                >
                    Descrição
                </label>

                <textarea
                    id="descricao"
                    name="descricao"
                    rows="5"
                    class="form-control"
                ><?= $atendimento['descricao'] ?></textarea>

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