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

<section id="hero" class="d-flex flex-column align-items-start justify-content-center w-100">
    <h4>Novidades em moda</h4>
    <h2>Ofertas com valores excelentes</h2>
    <h1>Em todos os produtos</h1>
    <p>Sempre atualizando o inventário</p>
    <a href="/catalogo" class="veja">Veja agora</a>
</section>

<section id="produtos" class="section-p1 text-center">
    <h2>Coleção de Inverno</h2>
    <p>Produtos em Destaque</p>
    
    <div class="pro-container d-flex flex-wrap">
        <?php
            $tempTricot = 0;
            foreach($produtos as $p) {
                $imagem =     ( array_key_exists(1, $p['imagens']) ) ? $p['imagens'][1]['url'] : $p['imagens'][0]['url'];
                $nome = strlen($p['nome']) <= 60 ? $p['nome']  : substr($p['nome'], 0, 57) . '...';
                $precoTotal = number_format($p['preco'], 2, ',', '.');
                $favorito = ($p['ativo'] == 'S') ? "style= 'font-weight: 600;'" : "style='font-weight: 500'";
                $title = ($p['ativo'] == 'S') ? "title='Produto favorito'" : "title='Produto não favorito'";

                if($p['idcategoria'] == 7) {
                    if ($tempTricot < 4) {
                        echo <<<HTML
                            <div class="pro" data-idproduto="{$p['idproduto']}">
                                <img src="{$imagem}" alt="">
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
                    $tempTricot++;
                }
            }
        ?>
    </div>
</section>

<section id="banner" class="section-m1 d-flex flex-column align-items-center justify-content-center text-center">
    <h4>Produtos de qualidade </h4>
    <h2>Até <span>15% off</span> - Roupas & Acessórios</h2>
    <a href="/catalogo">Explore Mais</a>
</section>

<section id="produtos" class="section-p1 text-center">
    <h2>Coleção de Verão</h2>
    <p>Produtos em Destaque</p>

    <div class="pro-container d-flex flex-wrap">
        <?php
            $tempShort = 0;
            $tempSaia = 0;
            foreach($produtos as $p) {
                $imagem =     ( array_key_exists(1, $p['imagens']) ) ? $p['imagens'][1]['url'] : $p['imagens'][0]['url'];
                $nome = strlen($p['nome']) <= 60 ? $p['nome']  : substr($p['nome'], 0, 57) . '...';
                $precoTotal = number_format($p['preco'], 2, ',', '.');
                $favorito = ($p['ativo'] == 'S') ? "style= 'font-weight: 600;'" : "style='font-weight: 500'";
                $title = ($p['ativo'] == 'S') ? "title='Produto favorito'" : "title='Produto não favorito'";

                if($p['idcategoria'] == 6) {
                    if ($tempShort < 4) {
                        echo <<<HTML
                            <div class="pro" data-idproduto="{$p['idproduto']}">
                                <img src="{$imagem}" alt="">
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
                    $tempShort++;
                }

                if($p['idcategoria'] == 5) {
                    if ($tempSaia < 4) {
                        echo <<<HTML
                            <div class="pro" data-idproduto="{$p['idproduto']}">
                                <img src="{$p['imagens'][1]['url']}" alt="">
                                <div class="des">
                                    <span>{$p['marca']}</span>
                                    <h5>{$nome}</h5>
                                    <h4>R\${$precoTotal}</h4>
                                </div>
                                <a href="#" class="favoritar" data-idproduto="{$p['idproduto']}" title="Favoritar produto">
                                    <i class="fa-regular fa-heart" $favorito></i>
                                </a>
                            </div>
                        HTML;
                    }
                    $tempSaia++;
                }
            }
        ?>
    </div>
</section>

<section id="sm-banner" class="section-p1 d-flex flex-wrap justify-content-between">
    <div class="banner-box d-flex flex-column align-items-start justify-content-center">
        <h4>O melhor para você</h4>
        <h2>Qualidade e elegância</h2>
        <span>Estilo é uma forma de viver</span>
        <a href="/catalogo" class="white">Veja Mais</a>
    </div>
    <div class="banner-box banner-box2 d-flex flex-column align-items-start justify-content-center">
        <h4>Inverno & Verão</h4>
        <h2>Roupas diversificadas</h2>
        <span>Diversos modelos de roupa para o seu gosto</span>
        <a href="/catalogo" class="white">Veja Mais</a>
    </div>
</section>

<section id="banner3" class="d-flex flex-wrap justify-content-between">
    <div class="banner-box d-flex flex-column align-items-start justify-content-center">
        <h2>DIVERSOS ACESSÓRIOS</h2>
        <h4>Pulseiras, colares, etc</h4>
    </div>
    <div class="banner-box banner-box2 d-flex flex-column align-items-start justify-content-center">
        <h2>NOVOS CASACOS</h2>
        <h4>Coleção Inverno - 2023</h4>
    </div>
    <div class="banner-box banner-box3 d-flex flex-column align-items-start justify-content-center">
        <h2>APROVEITE</h2>
        <h4>Seja mais você</h4>
    </div>
</section>