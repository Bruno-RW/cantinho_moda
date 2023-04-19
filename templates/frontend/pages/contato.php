<section id="header-banner" class="contato-banner">
    <h2>#NosContate</h2>
    <p>Entre em contato em caso de dúvidas ou sugestões</p>
</section>

<section id="detalhes-contato" class="section-p1 d-flex justify-content-between align-center">
    <div class="detalhes d-flex flex-column justify-content-center">
        <span>ENTRE EM CONTATO</span>
        <h2>Visite nossa loja ou nos contate agora</h2>
        <h3>Informações</h3>
        <div>
            <li>
                <i class="fas fa-map"></i>
                <p>Avenida Tucunduva, 300 - Sala 101</p>
            </li>
            <li>
                <i class="fas fa-envelope"></i>
                <p>cantinho_moda@hotmail.com</p>
            </li>
            <li>
                <i class="fas fa-phone"></i>
                <p>(55) 9 9988-0103</p>
            </li>
            <li>
                <i class="fas fa-clock"></i>
                <p>Segunda á Sexta, 07:30-17:00</p>
            </li>
        </div>
    </div>

    <div class="mapa">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3534.90876954468!2d-54.31047282442903!3d-27.62734202344168!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94f943837a1b49b9%3A0xd06e0133fa1c0b3a!2sCantinho%20Da%20Moda!5e0!3m2!1spt-BR!2sbr!4v1681849713423!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>

<section id="detalhes-form" class="d-flex justify-content-start">
    <!-- <form action="" class="d-flex flex-column align-items-start">
        <span>DEIXE UMA MENSAGEM</span>
        <h2>Entre em contato conosco</h2>
        <input type="text" placeholder="Seu nome">
        <input type="text" placeholder="E-mail">
        <input type="text" placeholder="Assunto">
        <textarea name="" id="" cols="30" rows="10" placeholder="Sua mensagem"></textarea>
        <button class="normal">Enviar</button>
    </form> -->

    <div class="row">
        <div class="col">
            <span>DEIXE UMA MENSAGEM</span>
            <h2>Entre em contato conosco</h2>
            <?= retornaHTMLAlertMensagemSessao() ?>
            <?= $formulario ?>
        </div>
    </div>
</section>