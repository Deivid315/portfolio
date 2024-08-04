

window.onload = function () {

    const url = window.location.href;
    const regex = /[?&]erro=([^&#]*)/;

    const match = regex.exec(url);

    const sucesso = match && decodeURIComponent(match[1].replace(/\+/g, ' '));

    const urlParams = new URLSearchParams(window.location.search);
    if (sucesso) {
        urlParams.delete('erro');
    }

    // Seleciona todos os filhos diretos da div #formulario
    const filhos = document.querySelectorAll('#formulario > *');

    // Itera sobre os filhos diretos
    filhos.forEach(filho => {
        // Verifica se o filho é uma div com uma ul dentro
        const ul = filho.querySelector('ul');
        if (ul) {
            // Verifica se a ul tem um li dentro
            const li = ul.querySelector('li');
            if (li) {
                // Remove o marcador e adiciona a cor azul à letra
                li.style.listStyleType = 'none';
                li.style.color = 'red';
            }
        }
    });

    const form = document.getElementById('formulario');
    form.addEventListener('submit', function(e){

        e.preventDefault();

        const dateInput = document.getElementById('cadastro_inicial_form_nascimento');
        const dateValue = dateInput.value;

        if (dateValue) {
            const birthDate = new Date(dateValue);
            const today = new Date();
            const eighteenYearsAgo = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

            if (birthDate > eighteenYearsAgo) {
                alert('Você deve ter pelo menos 18 anos.');
            } else {
                e.target.submit();
            }
        } else {
            alert('Por favor, insira uma data válida.');
        }

    })
}