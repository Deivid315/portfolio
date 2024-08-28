<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="cache-control" content="max-age=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
    <meta http-equiv="pragma" content="no-cache">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description"
        content="A Connection USA te ajuda a estudar nos Estados Unidos e a resolver todos os detalhes do seu processo, desde vistos à matrículas">
    <title>Estude nos EUA</title>
    <meta name="author" content="Magnos Sites">
    <meta name="robots" content="index,follow">
    <meta property="description"
        content="A Connection USA te ajuda a estudar nos Estados Unidos e a resolver todos os detalhes do seu processo, desde vistos à matrículas">
    <meta http-equiv="content-language" content="pt-br">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="keywords"
        content="intercambio, green card, processos migratorios, imigracao, emigracao, exterior, viagens,escolas de ingles, estudos, estudante">
    <link rel="icon" type="image/x-icon" href="/estudenoseua/img/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="/estudenoseua/img/favicon.ico">
    <meta name="msapplication-TileImage" content="/estudenoseua/img/favicon.ico">
    <link rel="shortcut icon" href="/estudenoseua/img/favicon.ico">

    <!-- facebook-->
    <meta property="og:title" content="Connection USA">
    <meta property="og:description"
        content="A Connection USA te ajuda a estudar nos Estados Unidos e a resolver todos os detalhes do seu processo, desde vistos à matrículas">
    <meta property="og:image" content="URL da imagem">
    <meta property="og:url" content="URL do seu site">

    <!--twitter-->
    <meta name="twitter:title" content="Connection USA">
    <meta name="twitter:description"
        content="A Connection USA te ajuda a estudar nos Estados Unidos e a resolver todos os detalhes do seu processo, desde vistos à matrículas">
    <meta name="twitter:image" content="URL da imagem">

    <style>
        @font-face {
            font-family: 'MinhaFonte';
            src: url('/fonte/Lato-Light.woff') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
        }

        html {
            width: 100%;
        }

        body {
            width: 100vw;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            box-sizing: border-box;
        }

        body::-webkit-scrollbar {
            width: 0.52vw;
            background-color: #E1C506;
        }


        body::-webkit-scrollbar-thumb {
            background-color: #000080;
            border: 0.15vw solid #000080;
        }


        body {
            line-height: 20px;
            font-family: 'MinhaFonte', sans-serif;
            background-color: white;
            font-size: 17px;
        }

        body a {
            font-family: 'MinhaFonte', sans-serif;
        }

        #container {
            width: 100%;
            transition: height 1s ease;
            padding-right: 10px;
        }

        #f_c {
            width: 100vw;
            position: fixed;
            z-index: -10;
        }

        #f_c img {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
        }

        #pre {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #000069;
            display: fixed;
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            line-height: 3vw;
        }

        .pre2 {
            border: 0.2vw solid #E1C506;
            padding: 5vw;
            animation: bs 3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 2vw;
        }

        #pre h1 {
            color: rgb(255, 255, 255);
            transform: rotate3d(10deg);
            font-size: 3vw;
            font-weight: lighter;
            animation: at 2s linear forwards;
        }

        .a {
            position: absolute;
            margin-top: 10vw;
            animation: a 3s linear forwards;

        }

        @keyframes at {
            0% {
                filter: blur(100px);
            }

            100% {
                filter: blur(0);
            }

        }

        @keyframes a {
            0% {
                left: -10%;
            }

            100% {
                left: 100%;
            }

        }

        @keyframes bs {
            0% {
                transform: rotateY(180deg);

            }

            100% {
                transform: rotateY(0deg);

            }

        }

        #pre img {
            transform: rotate3d(10deg);
            width: 50px;
        }

        #pre img:nth-child(2) {
            display: none;
        }

        #logo {
            width: 10.5vw;
            height: 10.5vw;
            display: flex;
            justify-content: center;

        }

        #logo span:nth-child(1) {
            width: 10.5vw;
            height: 10.5vw;
            background-color: white;
            border-radius: 50%;
            display: inline-block;
            position: absolute;
            margin-top: -1.8vw;
            border: 0.3vw solid #E1C506;
        }

        #logo img {
            margin-top: 2.5vw;
            height: 7.81vw;
            z-index: 2;
        }


        #menu {
            background-color: #000080;
            width: 100vw;
            height: 3vw;
            position: fixed;
            display: flex;
            justify-content: center;
            z-index: 10;
        }

        #menu::after {
            content: "";
            position: fixed;
            width: 100vw;
            height: 0.3vw;
            background: linear-gradient(90deg, rgba(225, 197, 6, 1) 42%, rgba(0, 0, 128, 1) 50%, rgba(0, 0, 128, 1) 55%, rgba(225, 197, 6, 1) 62%);
            margin-top: 3vw;
        }

        #lp_m,
        #menu_m {
            display: none;
        }



        #menu ul {
            list-style: none;
            width: 75%;
            height: 100%;
            padding: 0;
            margin-top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #menu ul li {
            height: 70%;
            width: 8vw;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8vw;
        }

        #menu ul li:hover {
            color: #E1C506;
        }

        #menu ul li a {
            height: 100%;
            width: 8vw;
            display: flex;
            align-items: center;
            justify-content: center;
            color: unset;
            text-decoration: none;
            cursor: pointer;
            margin-top: -0.5vw;
        }

        #menu ul li:nth-child(-n+3)::after {
            content: "";
            width: 1.1vw;
            height: 1vw;
            background-image: url("/estudenoseua/img/av.png");
            background-size: cover;
            /* Pode ser 'contain' dependendo do seu requisito */
            background-repeat: no-repeat;
            position: absolute;
            margin-left: 8vw;
            margin-top: 1.2vw;
        }


        #menu ul li:nth-child(n+5):nth-child(-n+7)::after {
            content: "";
            width: 1.1vw;
            height: 1vw;
            background-image: url("/estudenoseua/img/av.png");
            transform: rotate(180deg);
            background-size: cover;
            /* Pode ser 'contain' dependendo do seu requisito */
            background-repeat: no-repeat;
            position: absolute;
            margin-left: -8vw;
            margin-top: 1.4vw;
        }

        #menu ul li:nth-child(n+5):nth-child(-n+7)::before {
            content: "";
            width: 7vw;
            height: 0.2vw;
            background-color: #ffffff;
            position: absolute;
            margin-top: 1.4vw;
        }

        #menu ul li:nth-child(n):hover::before {
            background-color: #E1C506;
        }

        #menu ul li:nth-child(n):hover::after {
            background-image: url("/estudenoseua/img/ava.png");
        }

        #menu ul li:nth-child(-n+3)::before {
            content: "";
            width: 7vw;
            height: 0.2vw;
            background-color: #ffffff;
            position: absolute;
            margin-top: 1.4vw;
        }

        #efect_principal {
            margin-top: 0.78vw;
            width: 100vw;
            position: fixed;
            display: flex;
            justify-content: center;
            z-index: 10;

        }

        #efect {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 74vw;
            height: 0.20vw;
            margin-left: 1vw;
            margin-right: 1vw;

        }

        #efectdiv {
            list-style: none;
            width: 100%;
            height: 100%;
            padding: 0;
            margin-top: 0;
            display: flex;
            justify-content: space-between;
        }

        #efectdiv span {
            background-color: #E1C506;
            height: 100%;
            width: 10%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            visibility: hidden;
        }

        #efectdiv span:nth-child(3) {

            margin-right: 9%;
        }

        #efectdiv span:nth-child(4) {

            margin-left: 9%;
        }

        .portugues {
            align-items: center;
            display: flex
        }

        #language-selector {
            width: 3.5vw;
            font-size: .9vw;
            font-family: MinhaFonte, sans-serif;
            border: none
        }

        #language-selector:focus-visible {
            outline: none
        }

        #language-selector_m {
            width: 70px;
            font-size: 18px;
            font-family: MinhaFonte, sans-serif;
            border: none
        }

        #language-selector_m:focus-visible {
            outline: none
        }

        .portugues {
            position: absolute;
            background-color: #fff;
            width: 6vw;
            margin-top: .5vw;
            color: #000;
            height: 2vw;
            right: 0;
            justify-content: left
        }

        .portugues img {
            width: 2vw;
            margin-top: .2vw
        }
    </style>

    <script type="text/javascript" src="/estudenoseua/js/jquery-3.7.1.min.js"></script>
    <script>
        var pageLoaded = false;

        var minimumDurationReached = false;

        $(window).on("load", function() {
            pageLoaded = true;
            hidePreloader();
        });

        setTimeout(() => {
            pageLoaded = true;
            $("#pre").css("display", "none");
        }, 10000);

        var minimumDuration = 4000;
        setTimeout(function() {
            minimumDurationReached = true;
            hidePreloader();
        }, minimumDuration);

        function hidePreloader() {
            if (pageLoaded && minimumDurationReached) {
                $("#pre").css("display", "none");
            }
        }
    </script>
    <link rel="stylesheet" href="/estudenoseua/css/estilo.css?v010">
</head>

<body>

    <div id="pre">
        <picture>
            <source srcset="/estudenoseua/img/av.webp" type="image/webp">
            <source srcset="/estudenoseua/img/av.png" type="image/png">
            <img src="/estudenoseua/img/av.webp" alt="avião" class="a">
        </picture>
        <div class="pre2">
            <h1>CONNECTION USA</h1>
        </div>
    </div>
    <div class="meio_m">
        <nav id="menu_m">
            <span class="all">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <div id="up_m">
                <ul class="menu_tam_m">
                    <li><a href="https://connectionusa.net" data-i18n="menu.home"></a></li>
                    <li><a href="https://connectionusa.net/#nossosservicos" id="link_servicos_m"
                            data-i18n="menu.servicos"></a></li>
                    <li><a href="#" data-i18n="menu.estude"></a></li>
                    <li><a href="https://connectionusa.net/#consultoria" id="link_planejamento_m"
                            data-i18n="menu.planejamento"></a></li>
                    <li><a href="https://contato.connectionusa.net" data-i18n="menu.contato"></a></li>
                    <li><a href="https://connectionusa.net/#sobrenos" id="link_sobre_m" data-i18n="menu.sobrenos"></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div id="container">

        <section id="Home">

            <nav id="menu">
                <ul class="menu_tam">
                    <li><a href="https://connectionusa.net" data-i18n="menu.home"></a></li>
                    <li><a href="https://connectionusa.net/#nossosservicos" id="link_servicos"
                            data-i18n="menu.servicos"></a>
                    </li>
                    <li><a href="#" data-i18n="menu.estude"></a></li>
                    <div id="logo">
                        <span></span>
                        <img src="/estudenoseua/img/logo.webp" alt="logomarca da empresa">
                    </div>
                    <li><a href="https://connectionusa.net/#consultoria" id="link_planejamento"
                            data-i18n="menu.planejamento"></a></li>
                    <li><a href="https://contato.connectionusa.net" data-i18n="menu.contato"></a></li>
                    <li><a href="https://connectionusa.net/#sobrenos" id="link_sobre" data-i18n="menu.sobrenos"></a>
                    </li>
                </ul>

                <span class="portugues">
                    <select id="language-selector">
                        <option value="pt">PT</option>
                        <option value="en">EN</option>
                        <option value="es">ES</option>
                    </select>

                    <img id="flag-pt" class="imglanguage" src="/home/img/brasil.png" alt="bandeira do brasil">
                    <img id="flag-en" class="imglanguage" src="/home/img/eua.png" alt="bandeira dos eua">
                    <img id="flag-es" class="imglanguage" src="/home/img/esp.png" alt="bandeira da espanha">

                </span>
            </nav>
            <div id="lp_m">
                <div id="logo_m">
                    <span></span>
                    <img src="/estudenoseua/img/logo.webp" alt="logomarca da empresa">
                </div>
                <span class="portugues_m">

                    <select id="language-selector_m">
                        <option value="pt">PT</option>
                        <option value="en">EN</option>
                        <option value="es">ES</option>
                    </select>
                </span>
            </div>


            <div id="efect_principal">
                <div id="efect">
                    <div id="efectdiv">
                        <span data-target="1"></span>
                        <span data-target="2"></span>
                        <span data-target="3"></span>
                        <span data-target="4"></span>
                        <span data-target="5"></span>
                        <span data-target="6"></span>
                    </div>
                </div>
            </div>
        </section>
        <img data-src="/estudenoseua/img/fix" data-format="png" alt="estrada numa floresta" class="imgfix">

        <header>
            <h1 class="titulo">
                <span data-i18n="tit.pt1"></span>
                <span data-i18n="tit.pt2"></span>
                <span data-i18n="tit.pt3"></span>
                <span data-i18n="tit.pt4"></span>
            </h1>
            <div class="or_he">
                <span class="circ_not_dashed">
                    <span class="cir_dashed">
                        <img data-src="/estudenoseua/img/bandeira" data-format="webp"
                            alt="bandeira dos estados unidos">
                    </span>
                </span>

                <div class="text_he">
                    <h2 data-i18n="text"></h2>
                </div>

                <span class="circ_not_dashed">
                    <span class="cir_dashed">
                        <img data-src="/estudenoseua/img/torredaliberdade" data-format="png"
                            alt="torre da liberdade dos estados unidos">
                    </span>
                </span>

            </div>
        </header>

        <main>
            <span class="esc_title">
                <h1 data-i18n="esc"></h1>
            </span>

            <div id="estados">
                <div class="pt1">
                    <div class="pt1_1">
                        <div class="estado pri_est" data-index="ca">
                            <p>Califórnia</p>
                        </div>
                        <div class="estado" data-index="fl">
                            <p>Flórida</p>
                        </div>
                        <div class="estado" data-index="sc">
                            <p>South Carolina</p>
                        </div>
                        <div class="estado" data-index="ind">
                            <p>Indiana</p>
                        </div>
                        <div class="estado" data-index="ut">
                            <p>Utah</p>
                        </div>
                    </div>
                    <div class="pt1_2">
                        <div class="estado" data-index="ge">
                            <p>Georgia</p>
                        </div>
                        <div class="estado" data-index="nj">
                            <p>New Jersey</p>
                        </div>
                        <div class="estado" data-index="ms">
                            <p>Massachusetts</p>
                        </div>
                        <div class="estado" data-index="wa">
                            <p>Washington</p>
                        </div>
                    </div>
                </div>
                <div class="pt2">
                    <div class="pt2_1">
                        <div class="estado" data-index="hi">
                            <p>Hawaii</p>
                        </div>
                        <div class="estado" data-index="tx">
                            <p>Texas</p>
                        </div>
                        <div class="estado" data-index="co">
                            <p>Colorado</p>
                        </div>
                        <div class="estado" data-index="md">
                            <p>Maryland </p>
                        </div>
                        <div class="estado" data-index="cn">
                            <p>Connecticut</p>
                        </div>
                    </div>
                    <div class="pt2_2">
                        <div class="estado" data-index="il">
                            <p>Illinois</p>
                        </div>
                        <div class="estado" data-index="dc">
                            <p>D.C.</p>
                        </div>
                        <div class="estado" data-index="ny">
                            <p>Nova York</p>
                        </div>
                        <div class="estado" data-index="va">
                            <p>Virginia</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="mencao">
                <div id="corpo">
                    <div class="feche">
                        <span class="x1"></span>
                        <span class="x2"></span>

                    </div>
                    <h1 class="titulo_escolas"></h1>
                    <div id="estado_lista">
                    </div>
                </div>
            </div>

            <div id="detalhes">
                <div id="corpo_d">
                    <div class="feche2">
                        <span class="x1"></span>
                        <span class="x2"></span>

                    </div>
                    <div id="sep">
                        <div class="titulo_escolas_d">
                            <h1></h1>
                        </div>
                        <div class="primeiro">
                            <span class="pergun l_pri loc">Localizações:</span>
                            <span class="resp prime respl"></span>
                        </div>
                        <div class="primeiro">
                            <span class="pergun mat">Matrícula:</span>
                            <span class="resp respm"></span>
                        </div>
                        <div class="primeiro">
                            <span class="pergun val">Valores:</span>
                            <div class="varl">
                                <span class="3m"></span>
                                <span class="6m"></span>
                                <span class="9m"></span>
                                <span class="12m"></span>

                                <span class="exce">*Valores sujeitos a mudança.</span>
                                <span class="exce">*Quantia total paga após a aprovação do visto o da troca de
                                    status.</span>
                            </div>
                        </div>
                        <div class="primeiro com">
                            <span class="pergun">Comprovação Financeira:</span>
                            <div class="comp ult">
                                <span class="3c"></span>
                                <span class="6c"></span>
                                <span class="9c"></span>
                                <span class="12c"></span>
                            </div>
                        </div>

                    </div>
                </div>
        </main>
        <div id="emissao">
            <div class="romainfix">

            </div>
            <h1 data-i18n="roma.pt1"></h1>

            <h2 data-i18n="roma.pt2"></h2>
            <img data-src="/estudenoseua/img/logo" data-format="png" alt="logomarca" class="lgdet">

        </div>

        <div id="trocar">
            <div class="blue">
                <h1 data-i18n="troc.pt1"></h1>
            </div>
            <div class="blue_det">
                <h2 data-i18n="troc.pt2"></h2>
            </div>
        </div>

        <div id="mot">
            <h1 data-i18n="mot"></h1>
        </div>


        <footer id="fim">
            <div class="he">
                <img data-src="/estudenoseua/img/hea_viag" data-format="png" alt="aeroporto" class="hea_viag">

            </div>
            <div class="infoheader">
                <h1>CONNECTION USA <br data-i18n="infoheader.pt1"></h1>

                <img src="/home/img/logo.png" alt="logomarca da empresa">


                <button>
                    <a href="https://wa.me/17149367257" data-i18n="infoheader.pt2" style="max-width: 70%;"></a>
                </button>
                <h1 class="h1__" data-i18n="infoheader.pt3" style="max-width: 80%;"></h1>
                <a href="https://politica.connectionusa.net" class="politica" style="line-height: 1.5vw"
                    data-i18n="infoheader.pt4"></a>

            </div>
            <div class="creator">
                <a href="https://magnossites.com" data-i18n="desenvolvedor"></a>

            </div>
        </footer>
    </div>

    <script src="https://unpkg.com/i18next/i18next.js" defer></script>
    <script src="https://unpkg.com/i18next-http-backend/i18nextHttpBackend.js" defer></script>
    <script src="https://unpkg.com/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.js" defer></script>
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {

            const flags = {
                pt: document.getElementById('flag-pt'),
                en: document.getElementById('flag-en'),
                es: document.getElementById('flag-es')
            };

            i18next
                .use(i18nextHttpBackend)
                .use(i18nextBrowserLanguageDetector)
                .init({
                    fallbackLng: 'pt',
                    backend: {
                        loadPath: '/estudenoseua/js/{{lng}}.json',
                    },
                    detection: {
                        order: ['querystring', 'cookie', 'localStorage', 'navigator', 'htmlTag', 'path', 'subdomain'],
                        lookupQuerystring: 'lng',
                        checkWhitelist: true
                    },
                    whitelist: ['en', 'pt-BR', 'pt', 'pt-br', 'en-us', 'en-US', 'es', 'es-ES', 'es-es'],
                    lowerCaseLng: true,
                    load: 'languageOnly',
                    debug: false,
                }, function(err, t) {
                    let lang = i18next.language;

                    setLanguageSelector(lang);

                    updateFlags(lang.toLowerCase().slice(0, 2));

                    updateContent();

                });

            function updateContent() {

                document.querySelectorAll('[data-i18n]').forEach((element) => {
                    const key = element.getAttribute('data-i18n');
                    element.innerHTML = i18next.t(key, {
                        what: 'i18n'
                    });
                });
            }

            // Listener para mudança de idioma
            i18next.on('languageChanged', () => {
                updateContent();
            });


            let lang;
            var selector = document.querySelector('#language-selector');
            selector.addEventListener('change', function() {
                i18next.changeLanguage(this.value);
                updateFlags(this.value.toLowerCase().slice(0, 2));
            });

            var selector_m = document.querySelector('#language-selector_m');
            selector_m.addEventListener('change', function() {
                i18next.changeLanguage(this.value);
                updateFlags(this.value.toLowerCase().slice(0, 2));
            });

            function updateFlags(val) {

                Object.keys(flags).forEach(lang => {
                    if (lang === val) {
                        flags[lang].style.display = 'block';
                    } else {
                        flags[lang].style.display = 'none';
                    }
                });
            }

            function setLanguageSelector(lang) {
                const langPrefix = lang.toLowerCase().slice(0, 2); // Obter os primeiros 2 caracteres do idioma
                const selector = document.getElementById('language-selector');
                const selectorm = document.getElementById('language-selector_m');

                if (selector) {
                    Array.from(selector.options).forEach(option => {
                        option.selected = option.value === langPrefix;
                    });
                }
                if (selectorm) {
                    Array.from(selectorm.options).forEach(option => {
                        option.selected = option.value === langPrefix;
                    });
                }
            }

        });
        var homes = document.querySelectorAll(".mous_ef"),
            linkElement2 = document.querySelector('link[href="/home/css/style.css"]'),
            linkElement3 = document.querySelector('script[src="/home/js/index.js"]'),
            p_ani = 0;
        homes.forEach(function(e) {
            e.addEventListener("mouseenter", function() {
                if (!linkElement2) {
                    var e = document.createElement("link");
                    e.rel = "stylesheet", e.href = "/home/css/style.css", document.head.appendChild(e)
                }
                if (!linkElement3) {
                    var r = document.createElement("script");
                    r.type = "text/javascript", r.src = "/home/js/index.js", document.body.appendChild(r)
                }
                p_ani++
            }), e.addEventListener("mouseleave", function(e) {
                var r = document.querySelector('link[href="/home/css/style.css"]'),
                    s = document.querySelector('script[src="/home/js/index.js"]');
                r && r.parentNode.removeChild(r), s && s.parentNode.removeChild(s), p_ani >= 2 && document.getElementById("cursor").remove()
            })
        });
    </script>
    <script src="/estudenoseua/js/webp.js-master/lib/modernizr.webp.js"></script>
    <script src="/estudenoseua/js/webp.js-master/lib/webp.min.js"></script>
    <script>
        $(document).ready(function() {

            var spans = $("#efectdiv span");

            $(".menu_tam > li").hover(
                function() {
                    var menuItemIndex = $(this).index(".menu_tam > li"); // Calcula o índice manualmente

                    $(this).stop().animate({
                        marginTop: "0.4vw"
                    }, 100);

                    spans.each(function(index) {
                        if (index === menuItemIndex) {
                            $(this).css("visibility", "visible");
                        } else {
                            $(this).css("visibility", "hidden");
                        }
                    });
                },
                function() {
                    $(this).stop().animate({
                        marginTop: "0"
                    }, 100);

                    spans.css("visibility", "hidden");
                }
            );


            var b = 0;

            $(".all, .menu_tam_m a").click(function() {
                if (b == 0) {

                    $("#container").css("background-color", "#000080")
                    $(".imgfix").css("display", "none")
                    $("#container").css("position", "relative")
                    $("body").addClass("body_alter")
                    $("#container").css("overflow", "hidden")
                    $("#container").animate({
                        width: "10vw",
                        height: "70vh",
                        top: "15vh",
                        left: "90vw"
                    }, 1000)

                    $(".intro").animate({
                        height: "70vh",
                    }, 1000)

                    $(".all span:nth-child(2)").animate({
                        opacity: "0"
                    }, 1000)

                    $(".all span:nth-child(1)").animate({
                        top: "15px"
                    }, 1000)

                    $(".all span:nth-child(3)").animate({
                        top: "10.5px"
                    }, 1000)

                    $(".all span:nth-child(1)").css("transform", "rotate(30deg)");
                    $(".all span:nth-child(3)").css("transform", "rotate(-30deg)");

                    $("#up_m").animate({
                        left: "0"
                    }, 1000)

                    setTimeout(() => {
                        $(".menu_tam_m li").css("width", "210px")
                    }, 1000)

                    b++

                } else {

                    setTimeout(() => {
                        $(".imgfix").css("display", "inline-block")
                        $("#container").css("position", "static")
                        $("#container").css("background-color", "initial")
                        $("body").removeClass("body_alter")
                        $("#container").css("height", "auto")

                    }, 1000);
                    $("#container").css("overflow", "initial")
                    $("#container").animate({
                        left: "0",
                        width: "100%",
                        top: "0"
                    }, 1000)

                    $(".intro").animate({
                        height: "100vh",
                    }, 1000)

                    $(".all span:nth-child(2)").animate({
                        opacity: "1"
                    }, 1000)

                    $(".all span:nth-child(1)").animate({
                        top: "7.5px"
                    }, 1000)

                    $(".all span:nth-child(3)").animate({
                        top: "19px"
                    }, 1000)

                    $(".all span:nth-child(1)").css("transform", "rotate(0deg)");
                    $(".all span:nth-child(3)").css("transform", "rotate(0deg)");

                    $("#up_m").animate({
                        left: "-80vw"
                    }, 1000)

                    $(".menu_tam_m li").css("width", "0")

                    b--

                }

            })

            const csrfTokenName = '<?= csrf_token() ?>';
            let csrfTokenValue = '<?= csrf_hash() ?>';

            var elemento;
            $(".estado").click(function() {
                $("#mencao").css("display", "flex")
                $("body").css("overflow-y", "hidden")
                elemento = $(this).data("index");

                $.ajax({
                    type: "POST",
                    url: "http://localhost:8080/detalhes/esc",
                    data: JSON.stringify({
                        esco: elemento,
                        [csrfTokenName]: csrfTokenValue
                    }),
                    dataType: "json",
                    success: function(response) {

                        if (response.newCsrfToken) {
                            csrfTokenValue = response.newCsrfToken;
                        }
 
                        var escolas_ = response.data.escolas;
                        var ids = response.data.id;
                        console.log(escolas_);
                        console.log(ids);

                        var titulo = response.data.escolas[0];
                        $(".titulo_escolas").append("<span>" + titulo + "</span>");

                        console.log(response.data.escolas.length);
                        console.log(response.data.id.length);

                        if (response.data.escolas.length > 0 && response.data.id.length > 0) {
                            response.data.escolas.forEach(function(es, index) {
                                var id = response.data.id[index];
                                var mm = "<div class='delta' data-index='" + id + "'><h1>" + es + "</h1></div>";
                                $("#estado_lista").append(mm);
                            });
                        } else {
                            alert("Os arrays de retorno estão vazios. Consulte o bda");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro na requisição AJAX:" + error);
                    }
                });

            })
            $(document).on("click", ".delta", function() {
                $("#detalhes").css("display", "flex")
                var outer = $(this).data("index")

                $.ajax({
                    type: "POST",
                    url: "http://localhost:8080/detalhes/esc",
                    data: JSON.stringify({
                        det: outer,
                        es: elemento,
                        [csrfTokenName]: csrfTokenValue
                    }),
                    dataType: "json",
                    success: function(response) {
                        if (response.newCsrfToken) {
                            csrfTokenValue = response.newCsrfToken;
                        }

                        $(".titulo_escolas_d h1").append(response.data.nome);
                        $(".respl").append(response.data.cidade);
                        $(".respm").append(response.data.matricula);
                        $(".3m").append(response.data.mv_3);
                        $(".6m").append(response.data.mv_6);
                        $(".9m").append(response.data.mv_9);
                        $(".12m").append(response.data.mv_12);
                        $(".3c").append(response.data.mc_3);
                        $(".6c").append(response.data.mc_6);
                        $(".9c").append(response.data.mc_9);
                        $(".12c").append(response.data.mc_12);

                    },
                    error: function(xhr, status, error) {
                        console.error("Erro na requisição AJAX:" + error);
                    }
                });
            });

            $(".feche2").click(function() {
                $("#detalhes").css("display", "none")

                $(".titulo_escolas_d h1").empty();
                $(".respl").empty();
                $(".respm").empty();
                $(".3m").empty();
                $(".6m").empty();
                $(".9m").empty();
                $(".12m").empty();
                $(".3c").empty();
                $(".6c").empty();
                $(".9c").empty();
                $(".12c").empty();
            })

            $(".feche").click(function() {
                $("#mencao").hide();
                $("body").css("overflow-y", "scroll");
                $("#estado_lista").empty();
                $(".titulo_escolas").empty();
            });

        })
    </script>

</body>

</html>