<section id="header" class="d-flex align-items-center justify-content-between position-sticky">
        <a href="/"><img src="/assets/img/icones/logos/logo-black.png" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a href="/" class="<?= ($_SERVER['REQUEST_URI'] == '/') ? 'ativo' : '' ?>">Home</a></li>
                <li><a href="#" class="<?= ($_SERVER['REQUEST_URI'] == '/catalogo') ? 'ativo' : '' ?>">Catálogo</a></li>
                <li><a href="/sobre" class="<?= ($_SERVER['REQUEST_URI'] == '/sobre') ? 'ativo' : '' ?>">Sobre</a></li>
                <li><a href="/contato" class="<?= ($_SERVER['REQUEST_URI'] == '/contato') ? 'ativo' : '' ?>">Contato</a></li>
                <li id="li-usuario"><a href="/login" class="<?= ($_SERVER['REQUEST_URI'] == '/login') ? 'ativo' : '' ?>"><i class="fa fa-regular fa-user"></i></a></li>
                <a href="#" id="fechar"><i class="fa-solid fa-xmark"></i></a>
            </ul>
        </div>

        <div id="celular">
            <a href="#"><i class="fa fa-regular fa-user"></i></a>
            <i id="bar" class="fa fa-solid fa-bars"></i>
        </div>
</section>