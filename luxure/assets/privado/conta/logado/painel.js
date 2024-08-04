
import { configurarSocket } from "../websocket";

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

            atual.classList.remove('carreg');
        }
    });
	
}