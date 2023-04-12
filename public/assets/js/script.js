const bar = document.getElementById('bar');
const fecharBar = document.getElementById('fechar');
const navbar = document.getElementById('navbar');

if (bar) {
    bar.addEventListener('click', () => {
        navbar.classList.add('active');
    })
}

if (fecharBar) {
    fecharBar.addEventListener('click', () => {
        navbar.classList.remove('active');
    })
}