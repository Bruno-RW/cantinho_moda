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

categoriaFiltroOrdenacao.addEventListener('change', pesquisaPorFiltros);

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
//     document.querySelectorAll('#catalogo .accordion-collapse').classList.add('show');
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
                linkCurtir.querySelector('i').classList.remove('regular');
                linkCurtir.querySelector('i').classList.add('solid');
            } else {
                linkCurtir.querySelector('i').classList.remove('solid');
                linkCurtir.querySelector('i').classList.add('regular');
            }
        });
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