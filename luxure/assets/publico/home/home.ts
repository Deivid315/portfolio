
import { json } from 'express';
import estadosCidades from '../../json/estados-cidades.json';

interface Estado {
    nome: string;
    sigla: string;
    cidades: string[];
}

interface EstadosCidades {
    estados: Estado[];
}

const estadosCidadesData: EstadosCidades = estadosCidades as EstadosCidades;

function populateEstados(): void {
    const estadoSelect = document.getElementById('estado') as HTMLSelectElement;
    estadosCidadesData.estados.forEach((estado: Estado) => {
        estadoSelect.options.add(new Option(estado.nome, estado.sigla));
    });
}

const estadoSelect = document.getElementById('estado') as HTMLSelectElement;
estadoSelect.addEventListener('change', function () {
    marqueCidades(this.value);
});

populateEstados();

function marqueCidades(valor: string): void {
    const estadoSelecionado = valor;
    const cidadesSelect = document.getElementById('cidades') as HTMLSelectElement;
    cidadesSelect.innerHTML = '';

    if (estadoSelecionado) {
        const estado = estadosCidadesData.estados.find((estado: Estado) => estado.sigla === estadoSelecionado);
        if (estado) {
            estado.cidades.forEach((cidade: string) => {
                cidadesSelect.options.add(new Option(cidade, cidade));
            });
        }
    }
}

const todos_form = document.getElementById('todos_localizacao_formulario') as HTMLFormElement;
const select_cidade = document.getElementById('cidades') as HTMLSelectElement;
const select_estado = document.getElementById('estado') as HTMLSelectElement;

function alterarHidden(): boolean {
    let local = JSON.parse(localStorage.getItem('local'));
    if (local) {
        // Marcar a opção do estado
        const optionToSelect = select_estado.querySelector(`option[value="${local.estado}"]`) as HTMLOptionElement;
        if (optionToSelect) {
            optionToSelect.selected = true;
            marqueCidades(local.estado);
        }

        let cid = "";
        let cidad = "";
        if (Array.isArray(local.cidades) && local.cidades.length > 0) {
            cid = local.cidades.join(',');
            cidad = local.cidades.join(', ');
        }
        document.getElementById('locl').textContent = `Buscar em > Estado: ${local.estado} > cidade(s): ${cidad}`;

        const form_todos = document.querySelectorAll('.estado_cid') as NodeListOf<HTMLInputElement>;
        form_todos.forEach(element => {
            element.value = `${local.estado}:${cid}`;
        });

        Array.from(select_cidade.options).forEach(option => {
            if (local.cidades.includes(option.value)) {
                option.selected = true;
            }
        });

        return true;
    } else {
        return false;
    }
}

alterarHidden();

let local = JSON.parse(localStorage.getItem('local'));

if (local) {
    const formData = new FormData(todos_form);
    retornoPerfis(todos_form.action, formData);
} else {
    acrescAlerta("Escolha um estado e cidade para começar a busca");
}


let form_busca = document.getElementById('busca_form_fetiches') as HTMLFormElement;
let output = document.getElementById('fetichesText') as HTMLElement;
document.getElementById('busca_form_idade')?.addEventListener('input', function (this: HTMLInputElement, e) {
    if (this.value.length > 2) {
        this.value = this.value.slice(0, 2);
    }
});

document.getElementById('busca_form_username')?.addEventListener('input', function (this: HTMLInputElement, e) {
    if (this.value.length > 80) {
        this.value = this.value.slice(0, 80);
    }
});

let checkedBoxes = form_busca.querySelectorAll<HTMLInputElement>('input[type="checkbox"]:checked');
let values = Array.from(checkedBoxes).map(checkbox => checkbox.value);
output.textContent = values.join(', ');

form_busca.addEventListener('change', () => {
    let checkedBoxes = form_busca.querySelectorAll<HTMLInputElement>('input[type="checkbox"]:checked');
    let values = Array.from(checkedBoxes).map(checkbox => checkbox.value);
    output.textContent = values.join(', ');
});

type PerfilSimplificado = {
    alcunha: string;
    capa: string;
    detalhes: {
        altura: number,
        peso: number,
        valor: number
    },
    nascimento: {
        date: string;
    },
    username: string
}

if (local === null && typeof local === "object") {

    navigator.geolocation.getCurrentPosition(posicaoObtidaComSucesso);
}

function posicaoObtidaComSucesso(geolocalizacao: GeolocationPosition) {
    fetch(window.location.href, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ coords: { latitude: geolocalizacao.coords.latitude, longitude: geolocalizacao.coords.longitude } })
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro durante o processamento dos dados!');
            }
            return response.json();
        })
        .then(data => {
            acrescAlerta("");
            assincrono(data);
            return data;
        })
        .then(data => {
            if (500 in data.data.msg) {
                throw new Error("Erro 500");
            } else if (!(530 in data.data.msg)) {
                localStorage.setItem('local', JSON.stringify({ estado: data.data.estado, cidades: [data.data.cidade] }));
                alterarHidden();
            }

            if (p_alerta) {
                p_alerta.textContent = "";
            }
        })
        .catch(error => {
            console.error('Houve um erro durante a busca do usuário: ', error);
            acrescAlerta('Houve um erro durante a busca do usuário');
        });
}

const cidadesSelect = document.getElementById('cidades') as HTMLSelectElement;
cidadesSelect.addEventListener('change', function () {
    if (this.selectedOptions.length > 3) {
        alerta.textContent = "Você só pode selecionar até 3 cidades.";

        for (let i = this.selectedOptions.length - 1; i >= 3; i--) {
            this.selectedOptions[i].selected = false;
        }
    } else {
        alerta.textContent = "";
    }
});

const arqs = document.getElementById("arqs") as HTMLDivElement;
const carregando = document.getElementById("carregando") as HTMLDivElement;
const esta_cid = document.getElementById('estado_cidade') as HTMLFormElement;
const submit_botao = document.querySelectorAll('.subm') as NodeListOf<HTMLButtonElement>;
const p_alerta: HTMLParagraphElement = document.getElementById("alerta_elemento") as HTMLParagraphElement;
const alerta: HTMLParagraphElement = document.getElementById("alerta_c_e") as HTMLParagraphElement;

esta_cid.addEventListener('submit', function (e: Event) {

    e.preventDefault();

    submit_botao.forEach(element => {
        element.disabled = true;
    });

    if (select_estado.value === '' || select_cidade.value === '') {
        alerta.textContent = "Selecione um estado e cidade(s)";

        submit_botao.forEach(element => {
            element.disabled = false;
        });
        return;
    }

    let p_alerta: HTMLParagraphElement = document.getElementById("alerta_elemento") as HTMLParagraphElement;
    if (p_alerta.textContent !== "") {
        p_alerta.textContent = "";
    }
    alerta.textContent = "";

    carregando.style.display = "block";

    const formData = new FormData(esta_cid);
    const data: { [key: string]: any } = {};

    formData.forEach((value, key) => {
        if (key.endsWith('[]')) {
            const actualKey = key.slice(0, -2);
            if (!Array.isArray(data[actualKey])) {
                data[actualKey] = [];
            }
            data[actualKey].push(value);
        } else {
            data[key] = value;
        }
    });

    localStorage.setItem('local', JSON.stringify({ estado: data.estado, cidades: data.cidades }));

    alterarHidden();

    retornoPerfis(esta_cid.action, formData);
});

const form = document.getElementById('form-ajax') as HTMLFormElement;

todos_form.addEventListener('submit', function (e: Event) {
    e.preventDefault();

    let loc: HTMLInputElement = document.getElementById('todos_form_localizacao') as HTMLInputElement;
    let p_alerta: HTMLParagraphElement = document.getElementById("alerta_elemento") as HTMLParagraphElement;

    if (loc.value === undefined || loc.value === "") {

        if (p_alerta.textContent === "") {
            p_alerta.textContent = "Escolha um estado e cidade para continuar";
        }
        return;
    }

    p_alerta.textContent = "";

    submit_botao.forEach(element => {
        element.disabled = true;
    });
    carregando.style.display = "block";

    const formData = new FormData(todos_form);

    retornoPerfis(todos_form.action, formData);
});


form.addEventListener('submit', function (e: Event) {

    e.preventDefault();

    submit_botao.forEach(element => {
        element.disabled = true;
    });

    const p_alerta: HTMLParagraphElement = document.getElementById("alerta_elemento") as HTMLParagraphElement;
    let loc: HTMLInputElement = document.getElementById('busca_form_localizacao') as HTMLInputElement;

    if (loc.value === undefined || loc.value === "") {

        if (p_alerta.textContent === "") {
            p_alerta.textContent = "Escolha um estado e cidade para continuar";
        }
        submit_botao.forEach(element => {
            element.disabled = false;
        });
        form.reset();
        return;
    }

    p_alerta.textContent = "";

    const formData = new FormData(form);

    let isAnyFieldFilled = 0;

    formData.forEach((value) => {

        if (typeof value === 'string' && value.trim() !== '') {
            isAnyFieldFilled++;
        }
    });

    if (isAnyFieldFilled <= 2) {
        p_alerta.textContent = "Preencha ao menos um dado do formulário";
        submit_botao.forEach(element => {
            element.disabled = false;
        });
        form.reset();
        return;
    }

    let idade: HTMLInputElement = document.getElementById("busca_form_idade") as HTMLInputElement;
    if (idade.value.trim() !== "" && +idade.value < 18) {

        p_alerta.textContent = "Nosso site foi criado para pessoas maiores de idade! Não existem acompanhantes menores que 18 anos!";

        submit_botao.forEach(element => {
            element.disabled = false;
        });
        form.reset();
        return;
    } else if (idade.value.trim() !== "" && +idade.value > 100) {
        p_alerta.textContent = "Não existe acompanhante maior que 99 anos, digite uma idade válida!";

        submit_botao.forEach(element => {
            element.disabled = false;
        });
        form.reset();
        return;
    }

    carregando.style.display = "block";

    retornoPerfis(form.action, formData);

    form.reset();
});

function acrescAlerta(mensagem: string): void {
    const alerta = document.getElementById("notificacao") as HTMLDivElement;
    alerta.textContent = mensagem;
}


function ret(): void {

    setTimeout(() => {
        submit_botao.forEach(element => {
            element.disabled = false;
        });
    }, 1000);
    carregando.style.display = "none";

}

function retornoPerfis(action: string, corpo: BodyInit): boolean {

    if (arqs) {
        arqs.innerHTML = "";
    }

    acrescAlerta("");

    fetch(action, {
        method: 'POST',
        body: corpo,
    })
        .then(response => {

            if (!response.ok) {
                throw new Error('Erro durante o processamento dos dados!');
            }
            return response.json();

        })
        .then(data => {
            return assincrono(data);

        })
        .then(() => { })
        .catch(error => {

            console.error('Houve um erro durante a busca do usuário: ', error);
            acrescAlerta('Houve um erro durante a busca do usuário');
            carregando.style.display = "none";
            ret();
            return false;
        });

    return true;
}

function assincrono(data: any): void {
    console.log(data);
    const fragmento = document.createDocumentFragment();

    // Verifica mensagens de erro e exibe alertas
    const selecionados = data.data.selecionado ?? null;
    if (data.data.select !== null) {
        if (selecionados !== undefined && selecionados !== null) {

            const destaque: HTMLDivElement = document.getElementById('destaque') as HTMLDivElement;
            const perfis_destacados: HTMLDivElement = document.getElementById('perfis_destacados') as HTMLDivElement;

            if (data.data.select && selecionados && selecionados.length > 0) {
                // fazer verificação do etag aqui

                perfis_destacados.innerHTML = "";

                const fragmento_destaque: DocumentFragment = document.createDocumentFragment() as DocumentFragment;

                const todosPerfisDestaques: Array<PerfilSimplificado> = selecionados;
                todosPerfisDestaques.forEach(element => {
                    fragmento_destaque.appendChild(criarPerfil(element));
                });

                destaque.style.display = "block";

                perfis_destacados.appendChild(fragmento_destaque);
            } else {
                perfis_destacados.innerHTML = "";
                destaque.style.display = "none";
            }
        }
    }

    if (10 in data.data.msg) {
        acrescAlerta(data.data.msg[10]);
    }

    if (200 in data.data.msg || 10 in data.data.msg) {
        const cri = document.createElement("div") as HTMLDivElement;
        cri.id = "perf_o";

        const todosPerfis: Array<PerfilSimplificado> = data.data.perfis;
        todosPerfis.forEach(element => {
            cri.appendChild(criarPerfil(element));
        });

        fragmento.appendChild(cri);

        if (data.data.parametros !== null) {
            const crie = document.createElement("p") as HTMLParagraphElement;
            crie.id = "parametros";
            crie.textContent = "Resultado da busca para: " + data.data.parametros;
            fragmento.appendChild(crie);
        }

        arqs.appendChild(fragmento);
        ret();
    } else {
        tratarErro(data);
    }
}

function criarPerfil(element: PerfilSimplificado): HTMLDivElement {
    const novaDiv = document.createElement('div') as HTMLDivElement;
    novaDiv.classList.add('arqs');

    const h2 = document.createElement("h2") as HTMLHeadingElement;
    h2.textContent = "Foto de perfil";
    novaDiv.appendChild(h2);

    const href = document.createElement("a") as HTMLAnchorElement;
    href.href = "/perfil/" + element.username;
    novaDiv.appendChild(href);

    const img = document.createElement("img") as HTMLImageElement;
    img.src = element.capa;
    href.appendChild(img);

    const alcunha = document.createElement("div") as HTMLDivElement;
    alcunha.textContent = "Nome: " + element.alcunha;
    novaDiv.appendChild(alcunha);

    const idade = calcularIdade(element.nascimento.date);
    const idadeDiv = document.createElement("div") as HTMLDivElement;
    idadeDiv.textContent = "Idade: " + idade;
    novaDiv.appendChild(idadeDiv);

    const pA = document.createElement("div") as HTMLDivElement;
    pA.textContent = "Peso/Altura: " + element.detalhes.peso + " kg/ " + element.detalhes.altura + " m";
    novaDiv.appendChild(pA);

    const valor = document.createElement("div") as HTMLDivElement;
    valor.textContent = "Valor: R$ " + element.detalhes.valor + ",00";
    novaDiv.appendChild(valor);

    return novaDiv;
}

function calcularIdade(nascimento: string): number {
    const nascimentoDate = new Date(nascimento);
    const anoNasc = nascimentoDate.getFullYear();
    const anoAtual = new Date().getFullYear();

    return anoAtual - anoNasc;
}

function tratarErro(data: any): void {
    if (101 in data.data.msg) {
        const local = JSON.parse(localStorage.getItem('local') || '{}');
        let cid = "";

        if (Array.isArray(local.cidades) && local.cidades.length > 0) {
            cid = local.cidades.join(', ');
        }

        const locais = local.estado + ": " + cid;

        acrescAlerta('Ainda não há perfis em ' + locais);
        ret();
    } else {
        const valores = Object.values(data.data.msg);
        const primeiroValor = valores[0] as string;

        acrescAlerta(primeiroValor);
        ret();
    }
}

const fil = document.getElementById('filtro') as HTMLDivElement;
let n = 1;
const ff = document.getElementById('form-ajax') as HTMLDivElement;

fil.addEventListener('click', () => {
    if (n) {
        // Calcula a altura em pixels
        if (innerWidth > 1000) {
            const scrollHeightPx = ff.scrollHeight;
            // Converte a altura para vw
            const vwHeight = (scrollHeightPx / window.innerWidth) * 100 + "vw";
            // Define a altura em vw
            ff.style.height = vwHeight;
            ff.style.padding = '2vw';
        } else {
            ff.style.height = '300px';
            ff.style.padding = '10px';
        }
        fil.textContent = "Esconder";
        n = 0;
    } else {
        ff.style.padding = '0';
        ff.style.height = "0";
        fil.textContent = "Filtros";
        n = 1;
    }
});