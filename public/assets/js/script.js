// COMPORTAMENTO DE NAVBAR PARA CELULARES
    const bar = document.querySelector('#header #bar');
    const fecharBar = document.querySelector('#header #fechar');
    const navbar = document.querySelector('#header #navbar');

    bar.addEventListener('click', () => {
        navbar.classList.add('ativo');
    });

    fecharBar.addEventListener('click', () => {
        navbar.classList.remove('ativo');
    });
//


// SISTEMA DE FILTROS DA PÁGINA DE CATÁLOGO
    let categoriaFiltroOrdenacao = document.querySelector('#catalogo #filtroOrdenacao');
    let categoriaFiltroCategoria = document.querySelectorAll('#catalogo .checkCategoria');
    let categoriaFiltroMarcas = document.querySelectorAll('#catalogo .checkMarca');

    if (categoriaFiltroOrdenacao) {
        categoriaFiltroOrdenacao.addEventListener('change', pesquisaPorFiltros);
    }

    categoriaFiltroCategoria.forEach(check=>{
        check.addEventListener('change', pesquisaPorFiltros);
    });

    categoriaFiltroMarcas.forEach(check=>{
        check.addEventListener('change', pesquisaPorFiltros);
    });

    // CONFIGURA QUAIS FILTROS ESTÃO APLICADOS E ADICIONA AO _GET DA PÁGINA
    function pesquisaPorFiltros() {
        let filtro = 'filtro=' + categoriaFiltroOrdenacao.value;

        let categorias = [];
        categoriaFiltroCategoria.forEach(check=>{
            if (check.checked) {
                categorias.push('categoria[]='+check.value);
            }
        });
        let paramCategorias = categorias.length ? '&' + categorias.join('&') : '';

        let marcas = [];
        categoriaFiltroMarcas.forEach(check=>{
            if (check.checked) {
                marcas.push('marca[]='+check.value);
            }
        });
        let paramMarcas = marcas.length ? '&' + marcas.join('&') : '';

        window.location.href = window.location.pathname + `?${filtro}${paramCategorias}${paramMarcas}`;
    }
//


// ADICIONA COMPORTAMENTO DE ENVIAR FORMULÁRIO DE CONTATO
    const btnContato =  document.querySelector('#detalhes-form .btn');

    if (btnContato) {
        btnContato.addEventListener('click', e => {
            e.preventDefault();
            
            const formulario = document.querySelector('#detalhes-form form');
    
            let dadosPost = new FormData();
            dadosPost.append('acao',     'emailContato');
            dadosPost.append('nome',     formulario.nome.value);
            dadosPost.append('email',    formulario.email.value);
            dadosPost.append('assunto',  formulario.assunto.value);
            dadosPost.append('mensagem', formulario.mensagem.value);
    
    
            ajax('/ajax', dadosPost, function(resposta) {
                if (resposta.status != 'success') {
                    Swal.fire({
                        icon: resposta.status,
                        title: 'Opsss...',
                        text: resposta.mensagem
                    });
                    return;
                }
                
                Swal.fire({
                    icon: resposta.status,
                    title: 'Sucesso',
                    text: resposta.mensagem
                });
                return;
            });
            //! Add limpar formulário
        });
    }
//


// SISTEMA DE PÁGINA COM ELEMENTOS ABERTOS

    // PEGA INFORMAÇÕES DE UM ELEMENTO _GET DA PÁGINA
    const getUrlVars = (nome) => {
        let vars = {};
        let partes = window.location.href.split('?');

        if (partes.length > 1) {
            let query = partes[1];
            let pares = query.split('&');

            for (let i = 0; i < pares.length; i++) {
                let par = pares[i].split('=');

                vars[par[0]] = par[1];
            }
        };

        return vars[nome];
    };
    
    // TESTA QUAIS FILTROS ESTÃO APLICADOS PARA CARREGAR A PÁGINA COM OS ELEMENTOS ABERTOS
    const categoriaCollapse = getUrlVars('categoria%5B%5D'); // categoria%5B%5D == categoria[]
    const marcaCollapse = getUrlVars('marca%5B%5D'); // marca%5B%5D == marca[]

    if (categoriaCollapse) {
        const collapseCate = document.querySelectorAll('#catalogo #collapseCate');
        const collapseCateAtivo = [...collapseCate].map(collapseEl => new bootstrap.Collapse(collapseEl));
    }

    if (marcaCollapse) {
        const collapeMarc = document.querySelectorAll('#catalogo #collapseMarc');
        const collapeMarcAtivo = [...collapeMarc].map(collapseEl => new bootstrap.Collapse(collapseEl));
    }
//


// ADICIONA COMPORTAMENTO DE CURTIR AO BOTÃO DE CURTIR / FAVORITAR
    document.querySelectorAll('#modalProduto .favoritar').forEach(linkCurtir => {
        linkCurtir.addEventListener('click', e => {
            e.preventDefault();

            let dadosPost = new FormData();
            dadosPost.append('acao', 'curtir');
            dadosPost.append('idproduto', linkCurtir.dataset.idproduto);

            ajax('/ajax', dadosPost, function(resposta) {
                if (resposta.status != 'success') {
                    Swal.fire({
                        icon: resposta.status,
                        title: 'Opsss...',
                        text: resposta.mensagem
                    });
                    return;
                }

                // Se deu tudo certo, executa o código abaixo
                if (resposta.dados.curtiu) {
                    linkCurtir.querySelector('i').style = {
                        fontWeight: "600",
                        color: "#FF2B1C",
                    };
                } else {
                    linkCurtir.querySelector('i').style = {
                        fontWeight: "500",
                        color: "#4D4D4D",
                    };
                }
            });
        });
    });
//


// ADICIONA COMPORTAMENTO DE MOSTRAR PRODUTO COM MODAL
    document.querySelectorAll('.pro').forEach(produto => {
        produto.addEventListener('click', e => {
            e.preventDefault();

            let dadosPost = new FormData();
            dadosPost.append('acao', 'detalhaProduto');
            dadosPost.append('idproduto', produto.dataset.idproduto);

            ajax('/ajax', dadosPost, function(resposta) {
                if (resposta.status != 'success') {
                    Swal.fire({
                        icon: resposta.status,
                        title: 'Opsss...',
                        text: resposta.mensagem
                    });
                    return;
                }
                
                // Se deu tudo certo, executa o código abaixo
                let produto = resposta.dados.produto;
                const modalProduto = new bootstrap.Modal('#modalProduto');

                let favorito = (produto['favorito'].length > 0) ? "ativo" : "";
                let title = (produto['favorito'].length > 0) ? "title='Desfavoritar produto'" : "title='Favoritar produto'";

                document.querySelector('#modalProduto .modal-header').innerHTML = `
                    <p class="d-flex">Categoria > ${produto.categoria}</p>
                    
                    <a href="#" class="favoritar" data-idproduto="${produto.id}" ${title}>
                        <i class="fa-regular fa-heart ${favorito}"></i>
                    </a>

                    <button type="button" class="btn-close d-flex" data-bs-dismiss="modal" aria-label="Close" title="Fechar produto"></button>
                `;

                let prodImg = ( 1 in produto['imagens'] ) ? produto['imagens'][1]['url'] : produto['imagens'][0]['url'];
                let prodDes = ''; let prodEsp = '';

                if (produto.descricao) {
                    prodDes = `
                        <div class="prod-desc">
                            <h3>Descrição</h3>${produto.descricao}
                        </div>
                    `;
                }

                if (produto.especificacoes) {
                    prodEsp = `
                        <div class="prod-espe">
                            <h3>Especificações</h3>${produto.especificacoes}
                        </div>
                    `;
                }

                document.querySelector('#modalProduto .modal-body').innerHTML = `
                    <div class="produto d-flex">
                        <div class="img">
                            <img class="w-100" src="${prodImg}" alt="${produto.nome}">
                        </div>

                        <div class="info d-flex flex-column">
                            <h2>${produto.nome}</h2>

                            <div class="prod-info d-flex">
                                <div class="prod-id">
                                    <p>ID: <span>${produto.id}</span></p>
                                </div>
                                
                                <p class="prod-tamanho">Tamanho: <span>${produto.tamanho}</span></p>
                                <p class="prod-marca">Marca: <span>${produto.marca}</span></p>
                            </div>

                            <div class="prod-preco-full">
                                R$${produto.preco}
                            </div>

                            <div class="prod-preco-off d-flex align-items-center">
                                <span class="preco">R$${produto.precodesconto}</span>
                                <span class="off">a vista</span>
                            </div>

                            <div class="prod-preco-parcela">
                                ou em <span>4X R$${produto.precoparcela} sem juros</span>
                            </div>
                        </div>
                    </div>

                    <div class="extra d-flex flex-column">
                        ${prodDes}
                        ${prodEsp}
                    </div>
                `;
                modalProduto.show();
            });
        });
    });
//


// ADICIONA COMPORTAMENTO DE JORNAL

    // ADICIONA POSSIBILIDADE DE CADASTRAR COM A TECLA "ENTER"
    document.querySelector("#jornal #emailNews").addEventListener('keydown', e => {
        if (e.key === "Enter") {
            document.querySelector("#jornal button").click();
        }
    });

    // FUNÇÃO DE COMPORTAMENTO E ENVIO DE DADOS PARA CADASTRAR
    document.querySelector('#jornal .form button').addEventListener('click', e => {
        e.preventDefault();

        let email = document.querySelector('#emailNews');

        let dadosPost = new FormData();
        dadosPost.append('acao', 'cadastraNews');
        dadosPost.append('email', email.value);

        ajax('/ajax', dadosPost, function(resposta) {
            if (resposta.status != 'success') {
                Swal.fire({
                    icon: resposta.status,
                    title: 'Opsss...',
                    text: resposta.mensagem
                });
                return;
            }

            Swal.fire({
                icon: resposta.status,
                title: 'Sucesso',
                text: resposta.mensagem
            });
            return;
        });

        email.value = '';
    });

    // ADICIONA POSSIBILIDADE DE DESCADASTRAR COM A TECLA "ENTER"
    let inputCancelaNews = document.querySelector("#cancelar-jornal #cancelaNews");
    if (inputCancelaNews) {
        inputCancelaNews.addEventListener('keydown', e => {
            if (e.key === "Enter") {
                document.querySelector("#cancelar-jornal .btn a").click();
            }
        });
    }

    // FUNÇÃO DE COMPORTAMENTO E ENVIO DE DADOS PARA DESCADASTRAR
    const btnCancelaNews = document.querySelector('#cancelar-jornal .btn a');

    if (btnCancelaNews) {
        btnCancelaNews.addEventListener('click', e => {
            e.preventDefault();
    
            let dadosPost = new FormData();
            dadosPost.append('acao', 'cancelaNews');
            dadosPost.append('email', inputCancelaNews.value);
    
            ajax('/ajax', dadosPost, function(resposta) {
                if (resposta.status != 'success') {
                    Swal.fire({
                        icon: resposta.status,
                        title: 'Opsss...',
                        text: resposta.mensagem
                    });
                    return;
                }
    
                Swal.fire({
                    icon: resposta.status,
                    title: 'Sucesso',
                    text: resposta.mensagem
                });
                return;
            });
    
            inputCancelaNews.value = '';
        });
    }
//


// FUNÇÃO AJAX DO PROJETO
    function ajax(url, dados, callBack) {
        if (!url, !dados, !callBack) {
            throw 'Todos os parâmetros devem ser preenchidos';
        }

        let dadosCallBack = {};
        let xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.onload = function() {
            if (xhr.readyState == 4) {
                if (xhr.status != 200) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'warning',
                        title: 'Falha na comunicação',
                        text: 'Ocorreu um erro de conexão, por favor, tente novamente. Se o erro persistir, contate o suporte',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    return;
                }
                try {
                    dadosCallBack = JSON.parse( xhr.responseText );
                } catch(e) {
                    Swal.fire({
                        position: 'top-center',
                        icon: 'warning',
                        title: 'Falha de processamento',
                        text: 'A resposta não pôde ser processada, tente novamente ou entre em contato com o suporte',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    return;
                }

                callBack(dadosCallBack);
            }
        };

        xhr.onerror = function() {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Falha na comunicação',
                text: 'Ocorreu um erro de conexão, por favor, tente novamente',
                showConfirmButton: false,
                timer: 3000
            });
        };

        xhr.send(dados);
    }
//