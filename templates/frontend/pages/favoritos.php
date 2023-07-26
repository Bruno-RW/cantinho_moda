<section id="header-banner" class="minha-conta-banner">
    <h2>#Favoritos</h2>
    <p>Veja seus produtos favoritos!</p>
</section>

<section id="info-conta" class="section-p1 d-flex flex-column">
    <div class="favoritos">
        <h2>PRODUTOS FAVORITOS</h2>
        <div class="pro-container d-flex flex-wrap justify-content-center">
            <?php
                foreach($produtos as $p) {
                    $nome = strlen($p['nome']) <= 60 ? $p['nome']  : substr($p['nome'], 0, 57) . '...';
                    $precoTotal = number_format($p['preco'], 2, ',', '.');
                    $favorito = ($p['ativo'] == 'S') ? "style= 'font-weight: 600;'" : "style='font-weight: 500'";
                    $title = ($p['ativo'] == 'S') ? "title='Produto favorito'" : "title='Produto não favorito'";

                    if($p['ativo'] == 'S') {
                        echo <<<HTML
                            <div class="pro" data-idproduto="{$p['idproduto']}">
                                <img src="{$p['imagens'][0]['url']}" alt="">
                                <div class="des">
                                    <span>{$p['marca']}</span>
                                    <h5>{$nome}</h5>
                                    <h4>R\${$precoTotal}</h4>
                                </div>
                                <a href="#" class="favoritar" data-idproduto="{$p['idproduto']}" $title>
                                    <i class="fa-regular fa-heart" $favorito></i>
                                </a>
                            </div>
                        HTML;
                    }
                }
            ?>
        </div>
    </div>
</section>