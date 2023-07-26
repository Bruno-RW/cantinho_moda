<section id="modalProduto" class="modal fade" tabindex="-1" aria-labelledby="modalProdutoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered justify-content-center">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalProdutoLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body d-flex flex-column">

            </div>

        </div>
    </div>
</section>

<section id="header-banner" class="favoritos-banner">
    <h2>#Favoritos</h2>
    <p>Veja seus produtos favoritos!</p>
</section>

<section id="favoritos" class="section-p1 d-flex flex-column">
    <h1>Produtos Favoritos</h1>
    <div class="pro-container d-flex flex-wrap justify-content-start">
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
</section>