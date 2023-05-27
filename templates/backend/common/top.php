<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo??'' ?></title>
    <!-- CSS PRINCIPAL -->
    <link rel="stylesheet" href="/assets/css/style-sb-admin.css">
    <link rel="stylesheet" href="/assets/css/style-admin.css">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

    <!-- FONT AWESOME ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    
    <!-- SWEET ALERT -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark d-flex align-items-center justify-content-between ">
        <div class="menu-esquerda">
            <a class="navbar-brand ps-3" href="/"><?= $nomesite??'' ?></a>

            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- <button>Modo Noturno</button> -->
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>

                        <a class="nav-link" href="/admin/home">
                            <div class="sb-nav-link-icon"><i class="bi bi-house-fill"></i></div>
                            Home
                        </a>

                        <a class="nav-link" href="/admin/categorias">
                            <div class="sb-nav-link-icon"><i class="bi bi-diagram-2-fill"></i></div>
                            Categorias
                        </a>
                        <a class="nav-link" href="/admin/marcas">
                            <div class="sb-nav-link-icon"><i class="bi bi-bookmarks-fill"></i></div>
                            Marcas
                        </a>
                        <a class="nav-link" href="/admin/produtos">
                            <div class="sb-nav-link-icon"><i class="bi bi-tags-fill"></i></div>
                            Produtos
                        </a>

                        <a class="nav-link" href="/admin/clientes">
                            <div class="sb-nav-link-icon"><i class="bi bi-people-fill"></i></div>
                            Clientes
                        </a>
                        <a class="nav-link" href="/admin/usuarios ">
                            <div class="sb-nav-link-icon"><i class="bi bi-person-fill-lock"></i></div>
                            Usuários
                        </a>

                        <a class="nav-link" href="/admin/empresas">
                            <div class="sb-nav-link-icon"><i class="bi bi-building-fill"></i></div>
                            Empresas
                        </a>
                        <a class="nav-link" href="/admin/noticias">
                            <div class="sb-nav-link-icon"><i class="bi bi-envelope-paper-fill"></i></div>
                            Notícias
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer d-flex align-item-center justify-content-between">
                    <div class="usuario">
                        <div class="small">Logado como:</div>
                        <?= $usuario['nome']??'' ?>
                    </div>

                    <ul class="navbar-nav ms-auto me-3 me-lg-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user fa-fw"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/admin/config">Configurações</a></li>
                                <li><a href="/admin/log" class="dropdown-item" href="/admin/log">Exibir log</a></li>
                                <li class="px-2"><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/logout">Sair</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?= $tituloInterno??'' ?></h1>