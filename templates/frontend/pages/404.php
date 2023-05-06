<?php
    $link = URL . $_SERVER['REQUEST_URI'];
?>

<section id="erro" class="section-p1 d-flex align-items-center justify-content-center">
    <div class="container d-flex flex-column align-items-center justify-content-center">
        <h1>404</h1>
        <h4>Ops! Página não encontrada</h4>
        <p>Desculpe, a página <span><?=$link?></span> não existe. Caso tenha algo de errado, entre em contado.</p>

        <div class="btn">
            <a href="/">Voltar à home</a>
            <a href="/contato">Reportar problema</a>
        </div>
    </div>
</section>