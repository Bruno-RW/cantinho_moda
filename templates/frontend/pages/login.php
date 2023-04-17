<?= retornaHTMLAlertMensagemSessao() ?>

<section id="login" class="section-p1">
    <div class="container d-flex align-items-center justify-content-center position-relative">
        <i class="fa-solid fa-xmark"></i>

        <div class="form-box logar">
            <h2>Login</h2>
            <form method="POST" action="<?=$_SERVER['REQUEST_URI']?>" enctype="'application/x-www-form-urlencoded'">
                <div class="input-box">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email1" id="email1" required>
                    <label for="email1">E-mail</label>
                </div>
                <div class="input-box">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="senha1" id="senha1" required>
                    <label for="senha1">Senha</label>
                </div>

                <div class="esqueci-senha">
                    <label>
                        <input type="checkbox">Manter conectado
                    </label>
                    <a href="#">Esqueceu a senha?</a>
                </div>

                <button type="submit" class="btn">Entrar</button>

                <div class="logar-registrar">
                    <p>Não tem uma conta? <a href="#" class="link-registrar">Registrar</a></p>
                </div>
            </form>
        </div>

        <div class="form-box registrar">
            <h2>Registrar</h2>
            <form action="#">
                <div class="input-box">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="nome" id="nome" required>
                    <label for="nome">Nome</label>
                </div>
                <div class="input-box">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email2" id="email2" required>
                    <label for="email2">E-mail</label>
                </div>
                <div class="input-box">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="senha2" id="senha2" required>
                    <label for="senha2">Senha</label>
                </div>

                <div class="termos">
                    <p>Ao cadastrar-se, você concorda com os <a href="#">Termos de Uso</a> e <a href="#">Políticas de Privacidade</a>.</p>
                </div>

                <button type="submit" class="btn">Registrar</button>

                <div class="logar-registrar">
                    <p>Já tem uma conta? <a href="#" class="link-logar">Entrar</a></p>
                </div>
            </form>
        </div>
    </div>
</section>