<section id="catalogo" class="section-p1 text-center">
    <div class="container">
        <div class="ordenar d-flex flex-wrap align-items-center justify-content-end w-100">
            <span>Ordenar por:</span>
            <select  name="filtro" id="filtroOrdenacao" class="selectOrdenar">
                <?php $ordem = $GET['filtro'] ?? 'De A a Z'; ?>
                <option <?= $ordem == 'De A a Z'    ? 'selected' : '';?>>De A a Z</option>
                <option <?= $ordem == 'De Z a A'    ? 'selected' : '';?>>De Z a A</option>
                <option <?= $ordem == 'Maior preço' ? 'selected' : '';?>>Maior preço</option>
                <option <?= $ordem == 'Menor preço' ? 'selected' : '';?>>Menor preço</option>
            </select>
        </div>

        <div class="conteudo d-flex flex-wrap">
            <div class="filtro">
                <div class="titulo">
                    <span>Filtrar</span>
                </div>
                <div class="accordion accordion-flush" id="acordeaoFiltro">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Categorias
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#acordeaoFiltro">
                            <div class="accordion-body">
                                <?php
                                    foreach($dados['categorias'] as $d) {
                                        $checked = '';
                                        foreach($_GET['categoria']??[] as $cat) {
                                            if ($d['idcategoria'] == $cat) {
                                                $checked = 'checked';
                                            }
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
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Marcas
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#acordeaoFiltro">
                            <div class="accordion-body">
                                <?php
                                    foreach($dados['marcas'] as $m) {
                                        $idMarca = "checkMarca"."{$m['idmarca']}";
                                        echo(
                                            <<<HTML
                                                <label class="form-check form-check-reverse">
                                                    <input class="form-check-input checkMarca" type="checkbox" name="marca[]" value="{$m['idmarca']}" id="{$idMarca}">
                                                    <label class="form-check-label" for="{$idMarca}">{$m['marca']}</label>
                                                </label>
                                            HTML
                                        );
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                Faixa de preços
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#acordeaoFiltro">
                            <div class="accordion-body">
                                SSSS
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="pro-container d-flex flex-wrap justify-content-between">
                <?php
                    foreach ($produtos as $p) {
                        $imagem = (array_key_exists(1, $p['imagens'])) ? $p['imagens'][1]['url'] : $p['imagens'][0]['url'];
                        $nome = strlen($p['nome']) <= 60 ? $p['nome']  : substr($p['nome'], 0, 57) . '...';
                        $precoTotal = number_format($p['preco'], 2, ',', '.');
                        $favoritar = ($p['ativo'] == 'S') ? 'solid' : 'regular';

                        echo <<<HTML
                                <div class="pro">
                                    <img src="{$imagem}" alt="">
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
                ?>
            </div>
        </div>
</section>