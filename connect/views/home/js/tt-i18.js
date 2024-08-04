document.addEventListener('DOMContentLoaded', function () {

    // Função para atualizar o conteúdo com as traduções
    function updateContent() {
        document.body.localize();
    }

    // Definição de idioma inicial com base no navegador
    let defin = "";
    if (navigator.language.toLowerCase().includes("pt-br") || navigator.language.toLowerCase().includes("pt")) {
        defin = "pt-BR";
        var options = document.querySelectorAll("#language-selector option");
        options[0].selected = true;
        var options_m = document.querySelectorAll("#language-selector_m option");
        options_m[0].selected = true;
        trocaimg();
    } else if (navigator.language.toLowerCase().includes("en-us") || navigator.language.toLowerCase().includes("en")) {
        defin = "en-US";
        var options = document.querySelectorAll("#language-selector option");
        options[1].selected = true;
        var options_m = document.querySelectorAll("#language-selector_m option");
        options_m[1].selected = true;
        trocaimg();
    } else if (navigator.language.toLowerCase().includes("es-es") || navigator.language.toLowerCase().includes("es")) {
        defin = "es-ES";
        var options = document.querySelectorAll("#language-selector option");
        options[2].selected = true;
        var options_m = document.querySelectorAll("#language-selector_m option");
        options_m[2].selected = true;
        trocaimg();
    } else {
        defin = "en-US";
        var options = document.querySelectorAll("#language-selector option");
        options[1].selected = true;
        var options_m = document.querySelectorAll("#language-selector_m option");
        options_m[1].selected = true;
        trocaimg();
    }

    // Função para carregar o idioma sob demanda
    function loadLanguage(lang) {
        fetch('views/home/js/' + lang + '.json')
            .then(response => response.json())
            .then(translations => {
                i18next.init({
                    lng: lang,
                    resources: {
                        [lang]: {
                            translation: translations
                        }
                    }
                }, function (err, t) {
                    if (err) {
                        console.error('Erro ao carregar o idioma:', err);
                        return;
                    }
                    console.log('Idioma alterado:', i18next.language);
                    updateContent();
                });
            })
            .catch(error => {
                console.error('Erro ao carregar o arquivo de tradução:', error);
            });
    }

    // Função para trocar a imagem com base no idioma
    function trocaimg() {
        var imgElements = document.querySelectorAll('.imglanguage');
        imgElements.forEach(function (imgElement) {
            imgElement.remove();
        });

        var imgElement = document.createElement('img');
        imgElement.className = "imglanguage";
        var imgSrc;
        var imgAlt;

        if (defin && (defin.toLowerCase() === "pt-br")) {
            imgSrc = "views/home/img/brasil.png";
            imgAlt = "bandeira do brasil";
        } else if (defin && (defin.toLowerCase() === "en-us")) {
            imgSrc = "views/home/img/eua.png";
            imgAlt = "bandeira dos eua";
        } else if (defin && (defin.toLowerCase() === "es-es")) {
            imgSrc = "views/home/img/esp.png";
            imgAlt = "bandeira da espanha";
        }

        imgElement.src = imgSrc;
        imgElement.alt = imgAlt;

        var portuguesElement = document.querySelector('.portugues');
        if (portuguesElement) {
            portuguesElement.insertBefore(imgElement.cloneNode(true), portuguesElement.firstChild);
        }

        var portuguesElement_m = document.querySelector('.portugues_m');
        if (portuguesElement_m) {
            portuguesElement_m.insertBefore(imgElement.cloneNode(true), portuguesElement_m.firstChild);
        }
    }

    // Chamada inicial para carregar o idioma inicial
    if (defin) {
        loadLanguage(defin);
    }

    // Evento para alterar o idioma quando o usuário seleciona uma opção
    var lang;
    var selector = document.querySelector('#language-selector');
    selector.addEventListener('change', function () {
        lang = this.value;
        defin = lang;
        loadLanguage(lang); // Carrega o idioma selecionado sob demanda
        trocaimg();
    });

    var selector_m = document.querySelector('#language-selector_m');
    selector_m.addEventListener('change', function () {
        lang = this.value;
        defin = lang;
        loadLanguage(lang); // Carrega o idioma selecionado sob demanda
        trocaimg();
    });

});
