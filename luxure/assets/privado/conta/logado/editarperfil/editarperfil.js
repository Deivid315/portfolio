
import { configurarSocket } from "../../websocket";

const socket = configurarSocket();

socket.on('35159AE3F3AC6A569D7A632B76E940D8D4929098909BEDC9DE94A7A0B1441F0947FF9D589BD3A357B72875C543AC3C0F6C13FC081C137392A5E83AAE12942BFE', function (data) {
    updateTexts(data.texts);
});

function updateTexts(texts) {
    const fotos = texts['arquivos_publicos'][0];
    const id_p = texts['id'];

    let contagem = 0;

    fotos.forEach(function (ff) {
        if (ff.includes('foto_de_perfil_da_conta')) {

            document.getElementById("bt_c").style.display = 'block';
            const capa = document.getElementById("rm_0");
            capa.dataset.url = ff;

            let animac = document.getElementById('efeito_rm_0');
            animac.style.display = 'none';

            let img = document.createElement('img');
            img.style.height = '100px';
            img.src = ff;
            img.setAttribute("id", "imagem_rm_0");
            capa.appendChild(img);

        } else {
            // restante das imagens e vídeos
            contagem = (contagem + 1);
            let attr = null;
            let data_ids = [];
            let atual = document.getElementById('rm_' + contagem);

            let data_id = atual.getAttribute('data-val');
            if (ff.endsWith('png') || ff.endsWith('jpeg') || ff.endsWith('jpg')) {
                soma_img++;
                data_ids[contagem] = data_id;
                atual.dataset.url = ff;
                let add = 'rm_' + data_id;
                atual.id = add;

                let animac = document.getElementById('efeito_' + data_id);
                animac.style.display = 'none';

                let img = document.createElement('img');
                img.style.height = '100px';
                img.src = ff;

                let anim = document.getElementById(add);
                anim.appendChild(img);

            } else {
                soma_video++;
                atual.classList.remove('imagem-container');
                atual.classList.add('video-container');

                // Remove o primeiro filho do elemento
                if (atual.hasChildNodes()) {
                    atual.removeChild(atual.children[0]);
                }


                data_ids[contagem] = data_id;
                atual.dataset.url = ff;
                let add = 'rm_' + data_id;
                atual.id = add;


                let p = document.createElement("video");
                p.style.height = '100px';
                p.src = ff;
                p.setAttribute('controls', ''); // Correção aqui
                atual.appendChild(p);

            }

            let cont_remov_ = document.getElementById('remq_id_' + contagem);
            cont_remov_.style.display = 'block';
            cont_remov_.dataset.id = data_ids[contagem];
            atual.classList.remove('carreg');
            document.getElementById('edit_perfil_form_save').removeAttribute('disabled');
        }
    });

}
const textarea = document.getElementById('edit_perfil_form_biografia');

const valor_value = document.getElementById('valor_value').getAttribute('data-valor');
const valor = document.getElementById('edit_perfil_form_valor');
valor.value = valor_value;

const loc = document.getElementById('loc').getAttribute('data-loc');
const local = document.querySelector('input[type="radio"][value="' + loc + '"]');
if (local) {
    local.checked = true;
}

const posit = document.getElementById('posit').getAttribute('data-posit');
const posicao = document.querySelector('input[type="radio"][value="' + posit + '"]');
if (posicao) {
    posicao.checked = true;
}

let fetichesSelecionados = document.getElementById('fetiches_selecionados').getAttribute('data-fetiches');
let fetichesArray = JSON.parse(fetichesSelecionados);
if (fetichesArray) {
    fetichesArray.forEach(function (fetiche) {
        var checkbox = document.querySelector('input[type="checkbox"][value="' + fetiche + '"]');
        if (checkbox) {
            checkbox.checked = true;
        }
    });
}

let remov_mime_img = 0;
let remov_mime_vid = 0;


// para cada arquivo existe uma div que contém o arquivo
// atual tendo o atributo data - url como sendo a url da imagem e
// um id rm_(valor) sendo o valor de 0 até 10
// +
// um input do tipo arquivo.Existem 10 inputs cujos os nomes 
// vão de edit_perfil[input_1] até edit_perfil[input_10] além
// da capa que é edit_perfil[capa], apesar de que todos estão
// englobados pela div com classe 'arq_input' e id que vai de
// input_0 até input_10, isso inclui o input da capa de perfil
// +
// um button com um atributo data - id onde seu valor é o mesmo valor
// de 0 até 10.

// OBS: se existir 5 arquivos na conta, então existirá 6 buttons que 
// serão ocultados uma vez que eles não possuem arquivos para fazerem
//  referência, afinal, não tem como um button apagar um arquivo que não existe.
//  Ao mesmo tempo 6 inputs estarão visíveis e 5 inputs estarão invisíveis e só serão mostrados
//  se o usuário pressionar o botão apagar pois o limite de arquivos são 11,
//  então se na conta tiver 5 só pode ser dada a opção do usuário enviar 6
//  arquivos no máximo, se ele pressionar o botão de apagar então um arquivo
//  será apagado e 1 input será mostrado, então agora teremos 4 arquivos na
//  conta e 7 inputs.
//  OBS 2: considere que o termo 'apagar' se refere a apenas deixar display: none;
//  e mostrar: display: block;



// quando um usuário clicar no button que tem a classe remover
// será contado quantas vezes ele clicou no botão, em seguida
// é capturado o atributo data - id do botão (que é o valor de 0 até 10,
// depende da ordem em que ele está), supondo que seja 3, ou seja,
// existem no mínimo 3 arquivos na conta do usuário e ele selecionou
// o terceiro, então é aplicado um display none no button.

// OBS: o data - id é necessário pois para saber quais imagens o 
// usuário removeu é buscado o elemento cujo o id seja rm_ +
// o data - id do button.
// Todas as imagens e vídeos estão englobadas
// por uma div que possui o id rm_0 até o rm_10, então a função
// do button é apenas: ao ser clicado cultar a div do arquivo
// que possui o rm_ + valor do data - id daquele button e em seguida
// capturar um outro atributo que a div rm_ + ...tem, o atributo
// é o data - url, ele possui a url da imagem que é transferida para
// um campo do formulário do tipo hidden. Então recaptulando:

// 1 - usuário pressiona o button;
// 2 - é capturado o atributo data - id do button, valor esse que
// vai de 0 até 10 e depende de onde está o respectivo button
// em relação aos outros arquivos;
// 3 - é ocultado o button com display none;
// 4 - todos os 11 inputs possuem um id que vai de input_0 até input_10,
// então tendo o valor do atributo data - id do button é buscado
// no DOM o input cuja a div tem o id como sendo 'input_' + o data id do button
// 5 - a div do input é alterada para display block
// 6 - é buscado no DOM a div que possui o id sendo 'rm_' + o
// valor do data - id do button clicado. A div que contém rm_... 
// engloba o arquivo do usuário, com
// 'arquivo' me refiro a imagem ou vídeo apenas;
// 7 - é capturado o atributo data - url dessa div, seu valor é o mesmo
// da url da imagem que faz referência ao arquivo salvo na aws s3
// 8 - é ocultado essa div com display none
// 9 - o valor de data - url é adicionado em um input do tipo hidden 
// que tem o id 'edit_perfil_form_arqs_removidos' seguido por uma vírgula.
// Dessa forma sempre que uma imagem é removida seu valor é adicionado
// a esse input com uma vírgula no final pois dessa forma no beck - end
// eu vou fazer a separação desse valor em um array sempre que 
// encontrar uma vírgula.
// 10 - no final de tudo teremos o button e o arquivo como invisíveis
// e o respectivo input que anteriormente estava como invisível 
// agora visível.
// --
// Fiz outra regra para verificar se o atributo data - id é 0, pois
// ele é específico para a capa de perfil.
// Foi necessário aplicar uma regra diferente a div que engloba a capa,
// div essa que tem o id como sendo rm_0, por dois motivos:

// 1 - inicialmente esse input não é requerido, mas se o usuário remover
// a imagem dele clicando no button então ele se torna, pois
// o usuáro pode muito bem apenas alterar algumas outras imagens
// e não mexer na do perfil assim o input seria enviado vazio
// mas estaria tudo bem pois já existe uma imagem de perfil no banco de dados
// 2 - caso o usuário remova a imagem é acrescentado o atributo
// required, pois assim é obrigatório o envio de um arquivo. Também
// é acrescentado o atributo data - obg com valor true, pois
// caso o usuário desabilite a verificação do html no formulário,
// antes do formulário ser submetido é verificado pelo js se o
// input de id edit_perfil_form_capa tem algum valor, caso não tenha
// é verificado se existe esse atributo, se o atributo existir quer dizer
// que o usuário clicou no botão(foi adicionado o atributo) mas
// não enviu nada no input, assim é dado um alerta, mas claro, isso
// ocorre somente se o usuário alterar o html, por exemplo,
// acrescentar 'novalidate' ao formulario.

// Sempre que um arquivo for removido é verificado se no valor do atributo
// data - url tem no final da string .heic, .png, .jpg, ou .jpeg, caso tenha
// é somado +1 a variavel remov_mime_img, se tiver .mp4 ou .webm
// é acrescentado +1 a remov_mime_vid

document.querySelectorAll('.remover').forEach(function (div) {
    div.addEventListener('click', function (e) {

        let targetElement = e.target.classList.contains('remover') ? e.target : e.target.closest('.remover');
        let dataId = targetElement.getAttribute('data-id');
        targetElement.style.display = 'none';

        if (dataId === '0') {
            const som = 'rm_' + dataId;

            let del_ = document.getElementById('rm_0');
            let url = del_.getAttribute('data-url');
            del_.style.display = 'none';

            let cla2 = document.getElementById('input_0');
            cla2.style.display = 'block';

            document.getElementById('edit_perfil_form_capa').setAttribute('required', 'required');
            document.getElementById('edit_perfil_form_capa').setAttribute('data-obg', 'true');

            let arq_rem = document.getElementById('edit_perfil_form_arqs_removidos');
            arq_rem.value += url + ',';

        } else {

            let cla = document.getElementById('input_' + dataId);
            cla.style.display = 'block';

            let del_ = document.getElementById('rm_' + dataId);
            let url = del_.getAttribute('data-url');
            del_.style.display = 'none';
            let arq_rem = document.getElementById('edit_perfil_form_arqs_removidos');
            arq_rem.value += url + ',';

            if (url.endsWith(".mp4") || url.endsWith(".webm")) {
                remov_mime_vid++;
            } else if (url.endsWith(".png") || url.endsWith(".heic") || url.endsWith(".jpg") || url.endsWith(".jpeg")) {
                remov_mime_img++;
            }
        }
    })
})

const form = document.getElementById('form_edit');
document.getElementById('edit_perfil_form_arqs_removidos').value = '';



// é verificado se foi enviado algum arquivo nos inputs, caso tenha
// sido é verificado o tipo mime dos arquivos onde se for imagem
// é acrescentado + 1 em mime_img e se for vídeo em mime_video,
// caso ele altere a regra do input e envie algo diferente é dado
// um alert com o erro;



// criei um if com algumas validações. Atualmente existem 6
// variáveis importantes para o seguimento do formulário, são elas:

// 1 - {{ imagens }} = variável do twig passada pelo php, ela contabiliza
// quantos arquivos com final .heic, .png, .jpg, .jpeg existem na conta do usuário,
// fiz essa validação por lá pois achei mais fácil.
// 2 - {{ videos }} = a mesma coisa que {{ imagens }} mas com webm e mp4.
// 3 - remov_mime_img = toda imagem removida é verificada se é uma imagem
// com jpg, jpeg, heic ou png.
// 4 - remov_mime_vid = mesma coisa que a anterior mas com mp4 e webm
// 5 - mime_img = verifica se tem o tipo mime image/ o arquivo que 
// o usuário fez o upload no input.
// 6 - mime_video = mesma coisa que o anterior mas com video/

// agora temos as possíveis situações no if:
// quantidade de imagens originais - quantiadade de imagens que
// foram removidas (somado +1 quando pressionado o button) 
// + quantidade de imagens que foi feito o uplod, essa conta
// tem que dar 0, isso significa que o usuário removeu todas
// as imagens da conta e não enviou nenhuma. A segunda afirmação
// do if é a mesma coisa que a primeira mas com vídeos, se ambas
// forem verdadeiras, então isso quer dizer que o usuário removeu
// todos os arquivos e fez o upload de nenhum.

// o segundo caso é se a primeira afirmação for verdadeira e a
// segunda for maior ou igual a 0, isso significa que o usuário
// removeu todas as imagens e não fez o upload de nenhuma e que:
// 1 - a conta possue vídeos mas ele não removeu nenhum e não fez
// o upload de nenhum vídeo também, ou:
// 2 - ele removeu os vídeos da conta e fez upload de mais vídeos, ou:
// 3 - ele não removeu os vídeos da conta e fez upload de mais vídeos;

// Os 3 casos vão resultar numa conta cujo o valor é maior ou igual a 1,
// o que quer dizer que no perfil do usuário atualmente tem apenas vídeos
// e isso não é algo permitido.

// se o primeiro e segundo if forem verdadeiros, ou seja, a conta do usuário
// tem imagens então é verificado se a imagem de perfil foi
// removida (quando isso ocorre é  acrescentado o atributo data-obg na div dela)
// e se existe um arquivo no input dela, se não tiver arquivo é dado um alerta de imagem
// obrigatória, se tiver então é ignorado o if.

// OBS: é importante salientar que a verificação da foto de perfil feita
// pelo js é apenas uma segunda segurança, pois ao remover a foto o input
// edit_perfil[capa] tem o atributo required, ou seja, a validação feita pelo
// js só soará um alert se o usuário por acaso apagar o atributo required
// ou acrescentar novalidate no formulario.

let soma_img = 0;
let soma_video = 0;
const vid = parseInt(document.getElementById('vid').getAttribute('data-vid'));
const im = parseInt(document.getElementById('im').getAttribute('data-im'));

document.getElementById('edit_perfil_form_valor').addEventListener('input', function (e) {
    if (this.value.length > 4) {
        this.value = this.value.slice(0, 4);
    }
});
//enviando formulario
form.addEventListener('submit', (event) => {

    event.preventDefault();

    if (textarea.value.length < 10 | textarea.value.length > 500) {
        alert('a biografia não pode ser menor que 10 ou maior que 500 caracteres');
        return;
    }

    let mime_img = 0;
    let mime_video = 0;
    for (let i = 1; i <= 10; i++) {
        let inputName = 'edit_perfil_form[arq_' + i + ']';
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

    if (((im + soma_img) - remov_mime_img + mime_img) === 0 && ((vid + soma_video) - remov_mime_vid + mime_video) === 0) {
        alert('não enviou nenhum arquivo');
        return;
    } else if (((im + soma_img) - remov_mime_img + mime_img) === 0 && ((vid + soma_video) - remov_mime_vid + mime_video) >= 1) {
        alert('não é permitido ter apenas vídeos na página');
        return;
    }

    const cap_c = document.querySelector('input[name="edit_perfil_form[capa]"]');

    if (!cap_c.files.length && cap_c.getAttribute('data-obg') == 'true') {
        alert('é obrigatório o envio da imagem de perfil');
        return;
    }

    form.submit();

});

if (document.querySelector('.carreg')) {
    document.getElementById('edit_perfil_form_save').setAttribute('disabled', '');
}
window.addEventListener("beforeunload", function () {
    var inputs = form.querySelectorAll('input[type="text"], input[type="file"]');
    inputs.forEach(function (input) {
        input.value = '';
    });
});