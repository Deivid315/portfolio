
import { configurarSocket } from "../../websocket";
const socket = configurarSocket();

document.getElementById('finalizando_cadastro_form_valor').addEventListener('input', function (e) {
    if (this.value.length > 4) {
        this.value = this.value.slice(0, 4);
    }
});

const form = document.getElementById('form_edicao');

form.addEventListener('submit', (event) => {

    event.preventDefault();
    
    const textarea = document.getElementById('finalizando_cadastro_form_biografia'); 

    if (textarea.value.length < 10 | textarea.value.length > 500) {
        alert('a biografia não pode ser menor que 10 ou maior que 500 caracteres');
        return;
    }
    let mime_img = 0;
    let mime_video = 0;
    for (let i = 1; i <= 10; i++) {
        let inputName = 'finalizando_cadastro_form[arq_' + i + ']';
        let input = document.querySelector('input[name="' + inputName + '"]');

        if (input.files.length) {
            let mimeType = input.files[0].type;
            let tamanho = input.files[0].size / 1024 / 1024;

            if (input.files[0].name.endsWith('.heic')) {
                if (tamanho > 10) {
                    alert('A imagem: ' + input.files[0].name + ' é muito grande, por favor insira uma imagem menor');
                    return;
                }
                mime_img++;
            } else if (mimeType.startsWith('image/')) {
                if (tamanho > 10) {
                    alert('A imagem: ' + input.files[0].name + ' é muito grande, por favor insira uma imagem menor');
                    return;
                }
                mime_img++;
            } else if (mimeType.startsWith('video/')) {
                if (tamanho > 100) {
                    alert('O vídeo: ' + input.files[0].name + ' é muito grande, por favor insira um vídeo menor');
                    return;
                }
                mime_video++;
            } else {
                alert('Envie uma imagem ou vídeo válidos');
                return;
            }
        }
    }

    if (!mime_img && !mime_video) {
        alert('Envie ao menos um arquivo');
        return;
    }
    if (!mime_img && mime_video) {
        alert('não é permitido ter apenas vídeos na página');
        return;
    }

    const cap_c = document.querySelector('input[name="finalizando_cadastro_form[capa]"]');

    if (!cap_c.files.length) {
        alert('é obrigatório o envio da imagem de perfil');
        return;
    }
    const validacao = document.querySelector('input[name="finalizando_cadastro_form[validacao]"]');

    if (!validacao.files.length) {
        alert('é obrigatório o envio da foto de validação');
        return;
    }

    document.getElementById('finalizando_cadastro_form_save').setAttribute('disabled', '');

    form.submit();

});