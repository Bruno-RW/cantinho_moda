<section id="cadastro" class="section-p1">
    <div class="container d-flex align-items-center justify-content-center position-relative">
        <i class="fa-solid fa-xmark"></i>

        <div class="form-box registrar">
            <h2>Registrar</h2>

            <?= retornaHTMLAlertMensagemSessao() ?>

            <i class="fa-solid fa-envelope"></i>
            <i class="fa-solid fa-lock"></i>

            <?= $formCadastro ?>

            <div class="termos">
                <p>Ao cadastrar-se, você concorda com os <a href="#">Termos de Uso</a> e <a href="#">Políticas de Privacidade</a>.</p>
            </div>

            <div class="logar-registrar">
                <p>Já tem uma conta? <a href="#" class="link-logar">Entrar</a></p>
            </div>
        </div>
    </div>
</section>