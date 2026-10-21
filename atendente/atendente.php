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
";

$resultado = $pdo->query($sql);

$atendentes = $resultado->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atendentes</title>
</head>
<body>
<?php require '../header.php'; ?>
<?php require '../menu.php'; ?>

    <h1>Lista de Atendentes</h1>

    <table border="1" cellpadding="10">

        <tr>
            <th>ID</th>
            <th>Login</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Tipo Acesso</th>
            <th>Ativo</th>
            <th>Ações</th>
        </tr>

        <?php foreach($atendentes as $atendente): ?>

            <tr>

                <td>
                    <?= $atendente['id_atendente'] ?>
                </td>

                <td>
                    <?= $atendente['login'] ?>
                </td>

                <td>
                    <?= $atendente['nome'] ?>
                </td>

                <td>
                    <?= $atendente['cpf'] ?>
                </td>

                <td>
                    <?= $atendente['tipo_acesso'] ?>
                </td>

                <td>
                    <?= $atendente['ativo'] ?>
                </td>

                <td>

                    <a href="../atendente/editarAtendente.php?id=<?= $atendente['id_atendente'] ?>">
                        Editar
                    </a>

                    |

                    <a href="../atendente/toggleAtivoAtendente.php?id=<?= $atendente['id_atendente'] ?>">

                        <?php if($atendente['ativo'] == 'S'): ?>

                            Desativar

                        <?php else: ?>

                            Ativar

                        <?php endif; ?>

                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

    </table>

        <?php require '../footer.php'; ?>
</body>
</html>