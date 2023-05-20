<section id="catalogo" class="section-p1 text-center">
    <div class="pro-container d-flex flex-wrap">
        <?php
            $tempShort = 0;
            foreach($produtos as $p) {
                $nome = strlen($p['nome']) <= 60 ? $p['nome']  : substr($p['nome'], 0, 57) . '...';
                $precoTotal = number_format($p['preco'], 2, ',', '.');
                $favoritar = ($p['ativo'] == 'S') ? 'solid' : 'regular';

                if($p['idcategoria'] == 6) {
                    if ($tempShort < 4) {
                        echo <<<HTML
                            <div class="pro">
                                <img src="{$p['imagens'][1]['url']}" alt="">
                                <div class="des">
                                    <span>{$p['marca']}</span>
                                    <h5>{$nome}</h5>
                                    <h4>R\${$precoTotal}</h4>
                                </div>
                                <a href="#" class="favoritar" data-idproduto="{$p['idproduto']}" title="Favoritar este produto">
                                    <i class="fa-{$favoritar} fa-heart"></i>
                                </a>
                            </div>
                        HTML;
                    }
                    $tempShort++;
                }
            }
        ?>
    </div>
</section>