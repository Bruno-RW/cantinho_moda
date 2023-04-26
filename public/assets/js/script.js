const bar = document.querySelector('#header #bar');
const fecharBar = document.querySelector('#header #fechar');
const navbar = document.querySelector('#header #navbar');
// const secao = document.querySelector('section :not(#header)');

bar.addEventListener('click', () => {
    navbar.classList.add('ativo');
});

fecharBar.addEventListener('click', () => {
    navbar.classList.remove('ativo');
});

// secao.addEventListener('click', () => {
//     navbar.classList.remove('ativo');
// });

const mensagem = document.querySelector('#login .form-box .alert');
const loginContainer = document.querySelectorAll('#login .container');
const loginIcone = document.querySelectorAll('#login .form-box i').classList.add('ativo');

if (mensagem) {
    loginContainer.classList.add('ativo');
    loginIcone.classList.add('ativo');
}


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