document.querySelectorAll('.table .link-excluir').forEach(link => {
    // Para cada link com a classe .link-excluir, adiciona-se confirmação
    link.addEventListener('click', e => {
        // Impede que o href do link seja acionado
        e.preventDefault();

        Swal.fire({
            title: 'ATENÇÃO',
            html: "Tem certeza que deseja remover este registro?<br><br>Você <b>NÃO</b> poderá reverter esta decisão!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, remover',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link.href;
            }
        })
    });
});