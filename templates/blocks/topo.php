<?php
    $testaPagAtual = [
        ($_SERVER['REQUEST_URI'] == '/')         ? 'ativo' : '',
        ($_SERVER['REQUEST_URI'] == '/catalogo') ? 'ativo' : '', 
        ($_SERVER['REQUEST_URI'] == '/sobre')    ? 'ativo' : '',
        ($_SERVER['REQUEST_URI'] == '/contato')  ? 'ativo' : '',
        ($_SERVER['REQUEST_URI'] == '/login') ? 'ativo' : ''
    ];

    if (empty($cliente)) {
        $opcaoLogin = "<li id='li-usuario'><a href='/login' class='{$testaPagAtual[4]}'><i class='fa fa-regular fa-user'></i></a></li>";
    } else {
        $opcaoLogin = <<<HTML
            <li id='li-usuario'>
                <div class="dropdown">
                    <a href='#' class='dropdown-toggle {$testaPagAtual[4]}' data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='fa fa-regular fa-user'></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/minha-conta">Minha conta</a></li>
                        <li><a class="dropdown-item" href="/favoritos">Favoritos</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/logout">Sair</a></li>
                    </ul>
                </div>
            </li>
        HTML;
    }
?>

<section id="header" class="d-flex align-items-center justify-content-between position-sticky">
        <a href="/"><img src="/assets/img/icones/logos/logo-black.png" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a href="/"         class="<?= $testaPagAtual[0] ?>">Home</a></li>
                <li><a href="/catalogo" class="<?= $testaPagAtual[1] ?>">Catálogo</a></li>
                <li><a href="/sobre"    class="<?= $testaPagAtual[2] ?>">Sobre</a></li>
                <li><a href="/contato"  class="<?= $testaPagAtual[3] ?>">Contato</a></li>
                <?= $opcaoLogin ?>
                <a href="#" id="fechar"><i class="fa-solid fa-xmark"></i></a>
            </ul>
        </div>

        <div id="celular">
            <a href="#"><i class="fa fa-regular fa-user"></i></a>
            <i id="bar" class="fa fa-solid fa-bars"></i>
        </div>
</section>