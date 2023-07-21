const bar = document.querySelector('#header #bar');
const fecharBar = document.querySelector('#header #fechar');
const navbar = document.querySelector('#header #navbar');
// const secao = document.querySelectorAll('section :not(#header)');

bar.addEventListener('click', () => {
    navbar.classList.add('ativo');
});

fecharBar.addEventListener('click', () => {
    navbar.classList.remove('ativo');
});

// secao.addEventListener('click', () => {
//     navbar.classList.remove('ativo');
// });

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

// if (window.location.pathname == '/catalogo' && window.location.href.indexOf('catalogo') > 0) {
//     //Teste para iniciar a pág com dropdowns abertos
//     document.querySelectorAll('#catalogo .accordion-button').classList.add('collapsed');
//     document.querySelectorAll('#catalogo .collapse').classList.add('show');
// }

// ADICIONA COMPORTAMENTO DE CURTIR AO BOTÃO DE CURTIR / FAVORITAR
document.querySelectorAll('.favoritar').forEach(linkCurtir => {
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
                linkCurtir.querySelector('i').classList.remove('fa-regular fa-heart');
                linkCurtir.querySelector('i').classList.add('fa-solid fa-heart');
            } else {
                linkCurtir.querySelector('i').classList.remove('fa-solid fa-heart');
                linkCurtir.querySelector('i').classList.add('fa-regular fa-heart');
            }
        });
    });
});

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

            document.querySelector('#modalProduto .modal-header').innerHTML = `
                <p class="d-flex">Categoria > ${produto.categoria}</p>
                <button type="button" class="btn-close d-flex" data-bs-dismiss="modal" aria-label="Close"></button>
            `;

            let prodImg = ( 1 in produto['imagens'] ) ? produto['imagens'][1]['url'] : produto['imagens'][0]['url'];
            let prodDes = ''; let stlDes  = ''; let prodEsp = ''; let stlEsp  = '';

            if (produto.descricao) {
                prodDes = `<h3>Descrição</h3>${produto.descricao}`;
                stlDes = "style='margin: 15px 0 10px'";
            }

            if (produto.especificacoes) {
                prodEsp = `<h3>Especificações</h3>${produto.especificacoes}`;
                stlEsp = "style='margin: 15px 0 10px'";
            }

            document.querySelector('#modalProduto .modal-body').innerHTML = `
                <div class="produto d-flex">
                    <div class="img">
                        <img class="img-fluid img-produto" src="${prodImg}" alt="${produto.nome}">
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
                    <div class="prod-desc" ${stlDes}>
                        ${prodDes}
                    </div>
                    <div class="prod-espe" ${stlEsp}>
                        ${prodEsp}
                    </div>
                </div>
            `;
            modalProduto.show();
        });
    });
});


// ADICIONA COMPORTAMENTO DE CADASTRAR NO JORNAL
document.querySelectorAll('#jornal .form button').forEach(btn => {
    btn.addEventListener('click', e => {
        e.preventDefault();

        let email = document.querySelector('#inscreverJornal');

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
                icon: 'success',
                title: 'Sucesso',
                text: 'Inscrição realizada com sucesso'
            });
            return;
        });

        email.value = '';
    });
});


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