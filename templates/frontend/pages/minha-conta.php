<section id="header-banner" class="minha-conta-banner">
    <h2>#SuaConta</h2>
    <p>Veja e altere suas informações de conta</p>
</section>

<section id="info-conta" class="section-p1 d-flex flex-column">
    <h1>Informações Pessoais</h1>
    <div class="conta d-flex flex-column">
        <div class="conteudo d-flex flex-column">
            <div class="topico d-flex">
                <p>Nome:</p><span><?= $dados['cliente']['nome'] ?></span>
            </div>
            <div class="topico d-flex">
                <p>E-mail:</p><span><?= $dados['cliente']['email'] ?></span>
            </div>
            <div class="topico d-flex">
                <p>Dt. Cadastro:</p><span><?= $dados['cliente']['created_at'] ?></span>
            </div>
        </div>

        <div class="botoes">
            <a href="#">Alterar e-mail</a>
            <a href="#">Alterar senha</a>
        </div>
    </div>
</section>