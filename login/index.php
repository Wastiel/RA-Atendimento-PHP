<?php require '../includes/header.php'; ?>

<div class="login-container">

    <div class="login-card">

        <div class="text-center mb-4">

            <div class="login-logo">
                ⭐
            </div>

            <h2 class="login-title">
                Sistema de Atendimento EEEPE
            </h2>

            <p class="login-subtitle">
                Faça login para acessar o sistema
            </p>

        </div>

        <form action="autenticar.php" method="POST">

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Usuário
                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-person-fill"></i>

                    </span>

                    <input
                        type="text"
                        name="login"
                        class="form-control"
                        placeholder="Digite seu usuário"
                        required
                    >

                </div>

            </div>

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Senha
                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-lock-fill"></i>

                    </span>

                    <input
                        type="password"
                        name="senha"
                        class="form-control"
                        placeholder="Digite sua senha"
                        required
                    >

                </div>

            </div>

            <button
                type="submit"
                class="btn btn-eeepe w-100"
            >
                <i class="bi bi-box-arrow-in-right"></i>
                Entrar
            </button>

        </form>

    </div>

</div>

<?php require '../includes/footer.php'; ?>