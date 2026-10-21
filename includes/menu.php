<nav class="navbar navbar-expand-lg navbar-eeepe rounded mb-4">

    <div class="container-fluid">

        <a
            class="navbar-brand"
            href="../index/index.php"
        >
            ⭐ Sistema de Atendimento EEEPE
        </a>

        <div class="navbar-nav">

            <li class="nav-item dropdown list-unstyled">

                <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    role="button"
                    data-bs-toggle="dropdown"
                >
                    Cadastros
                </a>

                <ul class="dropdown-menu">

                    <li>

                        <a
                            class="dropdown-item"
                            href="../cliente/listar.php"
                        >
                            Clientes
                        </a>

                    </li>

                    <li>

                        <a
                            class="dropdown-item"
                            href="../atendente/listar.php"
                        >
                            Atendentes
                        </a>

                    </li>

                    <li>

                        <a
                            class="dropdown-item"
                            href="../tipoAtendimento/listar.php"
                        >
                            Tipos de Atendimento
                        </a>

                    </li>

                </ul>

            </li>

            <a
                class="nav-link"
                href="../atendimento/listar.php"
            >
                Atendimentos
            </a>

            <a
                class="nav-link"
                href="../index/dashboard.php"
            >
                Dashboard
            </a>

        </div>

        <div class="d-flex align-items-center ms-auto">

            <span class="navbar-text text-white me-3">

                <i class="bi bi-person-circle"></i>

                <?= $_SESSION['usuario']['nome'] ?? 'Usuário' ?>

            </span>

            <a
                class="nav-link text-white"
                href="../login/logout.php"
            >
                <i class="bi bi-box-arrow-right"></i>
                Sair
            </a>

        </div>

    </div>

</nav>