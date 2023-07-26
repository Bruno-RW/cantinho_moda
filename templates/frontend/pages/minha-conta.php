<section id="header-banner" class="minha-conta-banner">
    <h2>#SuaConta</h2>
    <p>Veja e altere suas informações de conta</p>
</section>

<section id="info-conta" class="section-p1 d-flex flex-column">
    <div class="dados">
        <h2>INFORMAÇÕES PESSOAIS</h2>
        <div class="conta d-flex justify-content-center">
            <div class="conteudo d-flex flex-column">
                <p>Nome:   <span><?= $dados['cliente']['nome'] ?></span></p>
                <p>E-mail: <span><?= $dados['cliente']['email'] ?></span></p>
                <p>Senha:  <span><?= $dados['cliente']['senha'] ?></span></p>
            </div>
        </div>
    </div>
</section>