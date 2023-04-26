<section id="login" class="section-p1">
    <div class="container d-flex align-items-center justify-content-center position-relative">
        <i class="fa-solid fa-xmark"></i>

        <div class="form-box">
            <h2>Login</h2>

            <?= retornaHTMLAlertMensagemSessao() ?>

            <i class="fa-solid fa-envelope"></i>
            <i class="fa-solid fa-lock"></i>

            <?= $formLogin ?>

            <div class="logar-registrar">
                <p>Não tem uma conta? <a href="/cadastro" class="link-registrar">Registrar</a></p>
            </div>
        </div>
    </div>
</section>