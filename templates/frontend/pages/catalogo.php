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

<section id="catalogo" class="section-p1 text-center">
    <div class="container">
        <div class="ordenar d-flex flex-wrap align-items-center w-100">
            <span>Ordenar por:</span>
            <select  name="filtro" id="filtroOrdenacao" class="selectOrdenar">
                <?php $ordem = $_GET['filtro'] ?? 'De A a Z' ?>
                <option <?= $ordem == 'De A a Z'    ? 'selected' : ''?> >De A a Z</option>
                <option <?= $ordem == 'De Z a A'    ? 'selected' : ''?> >De Z a A</option>
                <option <?= $ordem == 'Maior preço' ? 'selected' : ''?> >Maior preço</option>
                <option <?= $ordem == 'Menor preço' ? 'selected' : ''?> >Menor preço</option>
            </select>
        </div>

        <div class="conteudo d-flex justify-content-center align-items-start">
            <div class="filtro">
                <div class="titulo">
                    <span>Filtrar</span>
                </div>
                <div class="accordion accordion-flush" id="acordeaoFiltro">                   
                    <div class="categorias accordion-item">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCate" aria-expanded="false" aria-controls="collapseCate">
                            Categorias
                        </button>
                        
                        <div class="collapse" id="collapseCate">
                            <div class="card card-body">
                                <?php
                                    foreach($dados['categorias'] as $d) {
                                        $checked = '';
                                        foreach($_GET['categoria']??[] as $cat) {
                                            ( $d['idcategoria'] == $cat ) ? $checked = 'checked' : $checked;
                                        }
                                        $idCategoria = "checkCate"."{$d['idcategoria']}";
                                        echo(
                                            <<<HTML
                                                <label class="form-check form-check-reverse">
                                                    <input class="form-check-input checkCategoria" type="checkbox" name="categoria[]" value="{$d['idcategoria']}" id="{$idCategoria}" $checked>
                                                    <label class="form-check-label" for="{$idCategoria}">{$d['nome']}</label>
                                                </label>
                                            HTML
                                        );
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="marcas accordion-item">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMarc" aria-expanded="false" aria-controls="collapseMarc">
                            Marcas
                        </button>
                        
                        <div class="collapse" id="collapseMarc">
                            <div class="card card-body">
                                <?php
                                    foreach($dados['marcas'] as $m) {
                                        $checked = '';
                                        foreach($_GET['marca']??[] as $mar) {
                                            ( $m['idmarca'] == $mar ) ? $checked = 'checked' : $checked;
                                        }
                                        $idMarca = "checkMarca"."{$m['idmarca']}";
                                        echo(
                                            <<<HTML
                                                <label class="form-check form-check-reverse">
                                                    <input class="form-check-input checkMarca" type="checkbox" name="marca[]" value="{$m['idmarca']}" id="{$idMarca}" $checked>
                                                    <label class="form-check-label" for="{$idMarca}">{$m['marca']}</label>
                                                </label>
                                            HTML
                                        );
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="faixa-preco accordion-item">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaix" aria-expanded="false" aria-controls="collapseFaix">
                            Faixa de preços
                        </button>
                        
                        <div class="collapse" id="collapseFaix">
                            <div class="card card-body">
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pro-container d-flex flex-wrap justify-content-center">
                    <?php
                        foreach ($produtos as $p) {
                            $imagem =     ( array_key_exists(1, $p['imagens']) ) ? $p['imagens'][1]['url'] : $p['imagens'][0]['url'];
                            $nome =       ( strlen($p['nome']) <= 60 ) ? $p['nome'] : substr($p['nome'], 0, 57) . '...';
                            $favorito = ($p['ativo'] == 'S') ? "style= 'font-weight: 600; color: #FF2B1C'" : "style='font-weight: 500'";
                            $precoTotal = number_format($p['preco'], 2, ',', '.');

                            echo <<<HTML
                                <div class="pro col-1" data-idproduto="{$p['idproduto']}">
                                    <img src="{$imagem}" alt="">
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
                    ?>
            </div>
        </div>
</section>