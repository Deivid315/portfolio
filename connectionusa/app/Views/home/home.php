<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="cache-control" content="max-age=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
    <meta http-equiv="pragma" content="no-cache">
    <meta charset="UTF-8">
    <link rel="canonical" href="https://connectionusa.net">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description"
        content="Connection USA, uma empresa focada em resolver quaisquer situações relacionada a processos migratórios, além do auxílio em intercâmbio e situações semelhantes">
    <title>Connection USA</title>
    <meta name="author" content="Magnos Sites">
    <meta name="robots" content="index,follow">
    <meta http-equiv="content-language" content="pt-br">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="icon" type="image/x-icon" href="/home/img/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="/home/img/favicon.ico">
    <meta name="msapplication-TileImage" content="/home/img/favicon.ico">
    <link rel="shortcut icon" href="/home/img/favicon.ico">
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords"
        content="intercambio, green card, processos imigratorios, imigracao, emigracao, exterior, viagens, viagem, morar fora, brasil, eua, estados unidos">
    <meta property="og:title" content="Connection USA">
    <meta property="og:description"
        content="Connection USA, uma empresa focada em resolver quaisquer situações relacionada a processos migratórios, além do auxílio em intercâmbio e situações semelhantes">
    <meta property="og:image" content="https://www.connectionusa.net/home/img/logo.png">
    <meta property="og:url" content="https://connectionusa.net">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Connection USA">
    <meta name="twitter:site" content="@connectionusa">
    <meta name="twitter:title" content="Connection USA">
    <meta name="twitter:description"
        content="Connection USA, uma empresa focada em resolver quaisquer situações relacionada a processos migratórios, além do auxílio em intercâmbio e situações semelhantes">
    <meta name="twitter:image" content="https://www.connectionusa.net/home/img/logo.png">
    <meta name="twitter:card" content="summary_large_image">

    <style>
        #menu,
        body {
            width: 100vw
        }

        #fale_conosco,
        #menu,
        #pre {
            position: fixed
        }

        #menu ul li:nth-child(-n+3)::after,
        #menu ul li:nth-child(n+5):nth-child(-n+7)::after {
            width: 1.1vw;
            height: 1vw;
            background-image: url(/home/img/av.png);
            background-size: cover;
            background-repeat: no-repeat;
            position: absolute
        }

        #container,
        #efectdiv,
        #pre,
        html {
            width: 100%
        }

        #efectdiv,
        #menu ul {
            list-style: none;
            padding: 0;
            margin-top: 0;
            height: 100%
        }

        #pre h1,
        .slidee p {
            font-weight: lighter
        }

        #but::after,
        #but::before {
            background-color: #fff;
            box-shadow: .2vw .2vw 8px #fff;
            content: ""
        }

        #pre,
        .blob-btn,
        .buttons,
        .jorn_p,
        .slidee p {
            text-align: center
        }

        .blob-btn,
        .blob-btn__inner,
        body,
        body a {
            font-family: MinhaFonte, sans-serif
        }

        #menu ul li a,
        .but a {
            text-decoration: none
        }

        #fale_conosco {
            width: 4vw;
            height: 4vw;
            bottom: 30px;
            right: 2vw;
            z-index: 9
        }

        #fale_conosco a img {
            height: 4vw;
            width: 4vw;
            border: 2px solid navy;
            border-radius: 50%
        }

        #fale_conosco a {
            border-radius: 50%
        }

        #fale_conosco:hover {
            transform: scale(110%)
        }

        *,
        body {
            margin: 0;
            padding: 0
        }

        #container,
        body {
            overflow-x: hidden;
            overflow-y: hidden
        }

        #pre h1,
        #pre picture img {
            transform: rotate3d(10deg)
        }

        @font-face {
            font-family: MinhaFonte;
            src: url(/fonte/Lato-Light.woff) format('truetype');
            font-weight: 400;
            font-style: normal
        }

        body {
            height: 100vh;
            box-sizing: border-box;
            line-height: 2.5vw;
            background-color: #fff;
            font-size: .8vw
        }

        body::-webkit-scrollbar {
            width: .52vw;
            background-color: #e1c506
        }

        body::-webkit-scrollbar-thumb {
            background-color: navy;
            border: .15vw solid navy
        }

        #container {
            transition: height 1s;
            padding-right: 10px
        }

        #pre {
            height: 100%;
            top: 0;
            left: 0;
            background-color: #000069;
            display: fixed;
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            line-height: 3vw
        }

        .pre2 {
            border: .2vw solid #E1C506;
            padding: 5vw;
            animation: 3s bs;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 2vw
        }

        #pre h1 {
            color: #fff;
            font-size: 3vw;
            animation: 2s linear forwards at
        }

        .a {
            position: absolute;
            margin-top: 10vw;
            animation: 3s linear forwards a
        }

        @keyframes at {
            0% {
                filter: blur(100px)
            }

            100% {
                filter: blur(0)
            }
        }

        @keyframes a {
            0% {
                left: -10%
            }

            100% {
                left: 100%
            }
        }

        @keyframes bs {
            0% {
                transform: rotateY(180deg)
            }

            100% {
                transform: rotateY(0)
            }
        }

        #pre img {
            width: 50px
        }

        #but::after,
        #but::before,
        #lp_m,
        #menu_m,
        #pre img:nth-child(2),
        .conn,
        .primeiro_a {
            display: none
        }

        #logo,
        #menu {
            display: flex
        }

        #logo {
            width: 10.5vw;
            height: 10.5vw;
            justify-content: center
        }

        #logo span:first-child {
            opacity: 0;
            width: 10.5vw;
            height: 10.5vw;
            background-color: #fff;
            border-radius: 50%;
            display: inline-block;
            position: absolute;
            margin-top: -1.8vw;
            border: .3vw solid #e1c506
        }

        #logo img {
            margin-top: 4vw;
            width: auto;
            height: 7vw;
            border: .3vw solid navy;
            border-radius: 50%;
            z-index: 2
        }

        #menu {
            background-color: navy;
            height: 3vw;
            justify-content: center;
            z-index: 10
        }

        #menu::after {
            content: "";
            position: fixed;
            width: 100vw;
            height: .3vw;
            background: linear-gradient(90deg, rgba(225, 197, 6, 1) 0%, rgba(225, 197, 6, 1) 40%, rgba(0, 0, 128, 1) 45%, rgba(0, 0, 128, 1) 55%, rgba(225, 197, 6, 1) 60%, rgba(225, 197, 6, 1) 100%);
            margin-top: 3vw
        }

        #menu ul li,
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
            border-radius: 10px;
            background-color: white;
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

        #but,
        #frases,
        .intro,
        main {
            width: 100vw
        }

        .portugues img {
            width: 2vw;
            margin-top: .2vw
        }

        #menu ul {
            width: 75%;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        #menu ul li {
            height: 70%;
            width: 8vw;
            justify-content: center;
            color: #fff;
            font-size: .8vw
        }

        #menu ul li:hover {
            color: #e1c506
        }

        #menu ul li a {
            font-weight: 700;
            height: 100%;
            width: 8vw;
            display: flex;
            align-items: center;
            justify-content: center;
            color: unset;
            cursor: pointer;
            margin-top: -.5vw
        }

        #menu ul li:nth-child(-n+3)::after {
            content: "";
            margin-left: 8vw;
            margin-top: 1.2vw
        }

        #menu ul li:nth-child(n+5):nth-child(-n+7)::after {
            content: "";
            transform: rotate(180deg);
            margin-left: -8vw;
            margin-top: 1.4vw
        }

        #menu ul li:nth-child(-n+3)::before,
        #menu ul li:nth-child(n+5):nth-child(-n+7)::before {
            content: "";
            width: 7vw;
            height: .2vw;
            background-color: #fff;
            position: absolute;
            margin-top: 1.4vw
        }

        #efectdiv span,
        #menu ul li:nth-child(n):hover::before {
            background-color: #e1c506
        }

        #menu ul li:nth-child(n):hover::after {
            background-image: url(/home/img/ava.png)
        }

        #efect_principal {
            margin-top: .78vw;
            width: 100vw;
            position: fixed;
            display: flex;
            justify-content: center;
            z-index: 10
        }

        #efect {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 74vw;
            height: .2vw;
            margin-left: 1vw;
            margin-right: 1vw
        }

        #efectdiv {
            display: flex;
            justify-content: space-between
        }

        #efectdiv span,
        .slidee {
            display: flex;
            align-items: center
        }

        #efectdiv span {
            height: 100%;
            width: 10%;
            justify-content: center;
            color: #fff;
            visibility: hidden
        }

        #efectdiv span:nth-child(3) {
            margin-right: 9%
        }

        #efectdiv span:nth-child(4) {
            margin-left: 9%
        }

        .intro {
            position: fixed;
            z-index: -1;
            height: 100vh;
            object-fit: cover
        }

        #but,
        #but::after,
        #but::before,
        #frases,
        #trac span,
        .slidee,
        .slidee p {
            position: absolute
        }

        #frases {
            overflow: hidden;
            height: 12vw;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 17vw;
            color: #fff;
            font-size: 2.2vw
        }

        .slidee {
            opacity: 0;
            height: 12vw;
            justify-content: center;
            transition: opacity 1s ease-in-out
        }

        #carousell,
        .slidee p {
            align-items: center;
            width: 35vw;
            display: flex
        }

        .slidee p {
            justify-content: center;
            height: 11vw
        }

        #carousell {
            justify-content: center;
            height: 12vw
        }

        #trac span {
            background-color: #fff
        }

        #trac span:first-child {
            width: 5.85vw;
            height: .31vw;
            top: .78vw;
            margin-left: 29vw
        }

        #trac span:nth-child(2) {
            width: 5.85vw;
            height: .31vw;
            bottom: 1vw
        }

        #trac span:nth-child(3) {
            width: .31vw;
            height: 2.34vw;
            bottom: 1vw
        }

        #trac span:nth-child(4) {
            width: .31vw;
            height: 2.34vw;
            top: .78vw;
            margin-left: 34.7vw
        }

        #but {
            height: 13.02vw;
            margin-top: 40vw;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: column
        }

        .jorn_p {
            margin: 0;
            font-size: 2.1vw;
            color: #fff;
            width: 31.25vw;
            text-decoration: underline
        }

        #but::after {
            width: 31.77vw;
            height: .2vw;
            top: 2.6vw
        }

        #but::before {
            width: 22.6vw;
            height: .2vw;
            top: 5.2vw
        }

        .buttons {
            margin-top: 2.6vw;
            border-radius: 1.56vw
        }

        .blob-btn {
            width: 16.66vw;
            height: 3.64vw;
            z-index: 1;
            position: relative;
            padding: 1.04vw 2.39vw;
            margin-bottom: 1.56vw;
            text-transform: uppercase;
            background-color: transparent;
            outline: 0;
            border: none;
            transition: color .5s;
            cursor: pointer;
            border-radius: 1.56vw;
            color: #000
        }

        .blob-btn:after,
        .blob-btn:before,
        .blob-btn__inner {
            position: absolute;
            width: 100%
        }

        .bb {
            font-size: 1.24vw;
            margin-top: -.5vw;
            text-transform: none
        }

        .blob-btn:before {
            content: "";
            z-index: 1;
            left: 0;
            top: 0;
            border-radius: 1.56vw
        }

        .blob-btn:after {
            content: "";
            z-index: -2;
            left: .15vw;
            top: .15vw;
            height: 100%;
            transition: .3s .2s;
            border-radius: 1.56vw
        }

        .blob-btn:hover {
            color: #fff;
            border-radius: 1.56vw
        }

        .blob-btn:hover:after {
            transition: .3s;
            left: 0;
            top: 0;
            border-radius: 1.56vw
        }

        .blob-btn__inner {
            z-index: -1;
            overflow: hidden;
            left: 0;
            top: 0;
            height: 100%;
            border-radius: 2.6vw;
            box-shadow: .31vw .31vw navy;
            background: #fff;
            transition: box-shadow 1s
        }

        #Home,
        .blob-btn__blobs,
        main {
            position: relative
        }

        .blob-btn__blobs {
            display: block;
            height: 100%;
            filter: url("#goo")
        }

        .blob-btn__blob {
            position: absolute;
            top: .1vw;
            width: 25%;
            height: 100%;
            background: #0505a9;
            border-radius: 100%;
            transform: translate3d(0, 150%, 0) scale(1.7);
            transition: transform .45s
        }

        .blob-btn__blob:first-child {
            left: 0;
            transition-delay: 0s
        }

        .blob-btn__blob:nth-child(2) {
            left: 30%;
            transition-delay: 80ms
        }

        .blob-btn__blob:nth-child(3) {
            left: 60%;
            transition-delay: 0.16s
        }

        .blob-btn__blob:nth-child(4) {
            left: 90%;
            transition-delay: 0.24s
        }

        .blob-btn:hover .blob-btn__blob {
            transform: translateZ(0) scale(1.7)
        }

        @supports (filter:url("#goo")) {
            .blob-btn__blob {
                transform: translate3d(0, 150%, 0) scale(1.4)
            }

            .blob-btn:hover .blob-btn__blob {
                transform: translateZ(0) scale(1.4)
            }
        }

        #Home {
            height: 50vw
        }

        main {
            height: 39vw;
            margin-top: 9vw
        }
    </style>

    <script>
        var pageLoaded = false;
        var minimumDurationReached = false;

        window.addEventListener("load", function() {
            pageLoaded = true;
            hidePreloader();
        });

        setTimeout(() => {
            pageLoaded = true;
            document.getElementById("pre").style.display = "none";
            document.body.style.overflowY = "scroll";
        }, 10000);

        var minimumDuration = 4000;
        setTimeout(function() {
            minimumDurationReached = true;
            hidePreloader();
        }, minimumDuration);

        function hidePreloader() {
            if (pageLoaded && minimumDurationReached) {
                document.getElementById("pre").style.display = "none";
                document.body.style.overflowY = "scroll";
            }
        }
    </script>
    <link rel="preload" href="/home/css/estilo.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="/home/css/estilo.css">
    </noscript>

    <link rel="stylesheet" href="/home/css/respon.css" media="(max-width: 1024px)">

</head>

<body>
    <div id="pre">
        <img src="/home/img/av.png" alt="avião" class="a">

        <div class="pre2">
            <h1>CONNECTION USA</h1>
        </div>
    </div>
    <div id="fale_conosco">
        <a href="https://wa.me/17149367257">
            <img src="/home/img/whatsapp.png" alt="whatsapp">

        </a>
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
                    <li><a href="#" data-i18n="menu.home">Página Inicial</a></li>
                    <li><a href="#nossosservicos" id="link_servicos_m" data-i18n="menu.servicos">Serviços</a></li>
                    <li><a href="https://estudenoseua.connectionusa.net/" data-i18n="menu.estude">Estude nos EUA</a>
                    </li>
                    <li><a href="#consultoria" id="link_planejamento_m" data-i18n="menu.planejamento">Planejamento</a>
                    </li>
                    <li><a href="https://contato.connectionusa.net" data-i18n="menu.contato">Contato</a></li>
                    <li><a href="#sobrenos" id="link_sobre_m" data-i18n="menu.sobrenos">Sobre Nós</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <div id="container">

        <div class="mous_ef">
            <section id="Home">

                <nav id="menu">
                    <ul class="menu_tam">
                        <li><a href="#" data-i18n="nav.home">Página Inicial</a></li>
                        <li><a href="#nossosservicos" id="link_servicos" data-i18n="nav.servicos">Serviços</a></li>
                        <li><a href="https://estudenoseua.connectionusa.net/" data-i18n="nav.estude">Estude nos EUA</a>
                        </li>
                        <div id="logo">
                            <span></span>
                            <img src="/home/img/logo.png" alt="logomarca da empresa">
                        </div>
                        <li><a href="#consultoria" id="link_planejamento" data-i18n="nav.planejamento">Planejamento</a>
                        </li>
                        <li><a href="https://contato.connectionusa.net" data-i18n="nav.contato">Contato</a></li>
                        <li><a href="#sobrenos" id="link_sobre" data-i18n="nav.sobrenos">Sobre Nós</a></li>
                    </ul>
                    <span class="portugues">
                        <select id="language-selector">
                            <option value="pt">PT</option>
                            <option value="en">EN</option>
                            <option value="es">ES</option>
                        </select>

                        <img id="flag-pt" class="imglanguage" src="home/img/brasil.png" alt="bandeira do brasil">
                        <img id="flag-en" class="imglanguage" src="home/img/eua.png" alt="bandeira dos eua">
                        <img id="flag-es" class="imglanguage" src="home/img/esp.png" alt="bandeira da espanha">

                    </span>
                </nav>
                <div id="lp_m">
                    <div id="logo_m">
                        <span></span>
                        <img src="/home/img/logo.png" alt="logomarca da empresa">
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

                <video class="intro" autoplay="" loop="" muted="" playsinline="" preload="auto"
                    poster="/home/img/fundo_poster.png">
                    <source src="home/img/intro5.mp4" type="video/mp4">
                    Seu navegador não suporta este vídeo.
                </video>

                <div id="frases">
                    <div id="trac">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <div id="carousell">
                        <div class="fr1 slidee" data-index="1">
                            <p data-i18n="fr.pri">'Abra-se para o novo e descubra um mundo de oportunidades'</p>
                        </div>
                        <div class="fr2 slidee" data-index="2">
                            <p data-i18n="fr.seg">'As melhores história são encontradas entre as páginas de um
                                passaporte'</p>
                        </div>
                        <div class="fr3 slidee" data-index="3">
                            <p data-i18n="fr.ter">'O objetivo é morrer com memórias, não sonhos'</p>
                        </div>
                        <div class="fr4 slidee" data-index="4">
                            <p data-i18n="fr.qua">'O mundo é um livro, e quem não viaja lê apenas a primeira página!'
                            </p>
                        </div>
                        <div class="fr5 slidee" data-index="5">
                            <p data-i18n="fr.qui">'Connection USA, Sua melhor conexão no Exterior!'</p>
                        </div>
                    </div>

                </div>

                <div id="but">
                    <div id="jornada">
                        <p class="jorn_p"><span data-i18n="smc.um">Connection USA,</span><br><span
                                data-i18n="smc.dois">Sua melhor conexão no Exterior!</span></p>
                    </div>

                    <a href="https://wa.me/17149367257" class="primeiro_a">
                        <button data-i18n="contato">Entre em contato</button>
                    </a>

                    <a href="https://wa.me/17149367257" class="segundo_a">
                        <div class="buttons button">
                            <button class="blob-btn">
                                <p class="bb" data-i18n="contato">Entre em contato</p>
                                <span class="blob-btn__inner">
                                    <span class="blob-btn__blobs">
                                        <span class="blob-btn__blob"></span>
                                        <span class="blob-btn__blob"></span>
                                        <span class="blob-btn__blob"></span>
                                        <span class="blob-btn__blob"></span>
                                    </span>
                                </span>
                            </button>
                            <br>

                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
                                <defs>
                                    <filter id="goo">
                                        <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10">
                                        </feGaussianBlur>
                                        <feColorMatrix in="blur" mode="matrix"
                                            values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7" result="goo">
                                        </feColorMatrix>
                                        <feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
                                    </filter>
                                </defs>
                            </svg>

                            <!--<a href=""><button type="button" class="button">Fale Conosco</button></a>-->

                        </div>
                    </a>
                </div>
            </section>
            <main>

                <div class="imgfundodivvv">
                    <img src="/home/img/fundoimg12.png" alt="imagem de fundo amarela" class="imsobrenos">

                </div>
                <img src="/home/img/fundoimg2.png" alt="vistos" class="imsobrenos2 obs">

                <div class="tot_">
                    <section id="sobrenos" class="obs">
                        <h1 data-i18n="qso.pt1">Quem Somos:</h1>
                        <img src="/home/img/fla1.png" alt="tela de fundo" class="fla1">

                        <h2>
                            <span data-i18n="qso.pt2">Conheça a</span>
                            <span class="conn">CONNECTION USA</span>
                        </h2>
                        <span class="sobre_tras">CONNECTION USA</span>
                        <p data-i18n="qso.pt3">Descubra uma maneira eficiente e confiável para realizar o seu sonho
                            americano! Somos uma Agência Imigratória especializada em processos de GreenCard por
                            Casamento, Removal of Conditions, Cidadania, Troca e Extensão de Status, Vistos em geral e
                            muito mais. Estamos comprometidos em tornar esse caminho mais simples, eficiente e menos
                            estressante para você. Temos uma equipe treinada e preparada para te guiar em cada etapa,
                            desde a aplicação até a aprovação do seu processo. Entre em contato com nossa equipe de
                            especialistas para dar o primeiro passo em direção a realização do seu sonho. A Connection
                            USA quer transformar o seu sonho em realidade!</p>
                        <img src="/home/img/av.png" alt="avião" class="fla2">

                    </section>
                </div>
            </main>
        </div>



        <section id="nossosservicos">
            <div class="intr_im">
                <img src="/home/img/introserv.svg" alt="forma geométrica" class="introserv">
            </div>
            <div class="ordem obs">

                <img src="/home/img/ban.png" alt="bandeira dos eua" class="ban">

                <div class="servicos">
                    <div class="perc_efect">
                        <h1 data-i18n="serv.pt1">Nossos Serviços</h1>
                        <div class="bottom-left-line3"></div>
                        <div class="top-right-line3"></div>
                    </div>

                    <p>
                        <span data-i18n="serv.pt2.pt1">Você sabia que a Connection consegue te ajudar desde a </span>
                        <strong>
                            <span data-i18n="serv.pt2.pt2">aplicação de um visto</span>
                        </strong>
                        <span data-i18n="serv.pt2.pt3"> no seu país de origem até a aplicação da sua </span>
                        <strong>
                            <span data-i18n="serv.pt2.pt4">Cidadania Americana</span>
                        </strong>
                        <span data-i18n="serv.pt2.pt5">? Além disso, também oferecemos assessoria para visto canadense,
                            tradução juramentada de documentos, </span>
                        <strong>
                            <span data-i18n="serv.pt2.pt6">muito mais!</span>
                        </strong>
                    </p>
                </div>

                <img src="/home/img/ban.png" alt="bandeira dos eua" class="ban">


            </div>
            <div id="serv_m">
                <div class="serv_m_1 s_m" data-index="1">
                    <span class="circ_m"></span>
                    <div class="serv_title_m">
                        <h1 data-i18n="serv_m.pt1.pt1">Troca de Status</h1>

                    </div>

                    <img src="/home/img/ptserv1.png" alt="camera" class="serv_img_m tr_c">

                    <div class="serv_text_m">

                        <h2 data-i18n="serv_m.pt1.pt2">Quer trocar o seu status dentro dos EUA para estudar ou turistar
                            e não sabe como?</h2>
                        <p data-i18n="serv_m.pt1.pt3">Esta é uma ótima oportunidade para quem já está nos Estados
                            Unidos, como turista ou visto J-1 por exemplo, e deseja permanecer no país para estudar. Com
                            a Troca de Status você não precisa retornar ao seu país de origem para fazer o processo de
                            obtenção de visto. A Connection USA tem parceria com diversas escolas de inglês e consegue
                            te ajudar com todo o processo!</p>
                    </div>

                    <img src="/home/img/setas-direitas.png" alt="seta para a direita" class="serv_set_m">

                </div>
                <div class="serv_m_2 s_m" data-index="2">
                    <span class="circ_m"></span>
                    <div class="serv_title_m">
                        <h1 data-i18n="serv_m.pt2.pt1">Extensão de Status</h1>

                    </div>

                    <img src="/home/img/ptserv2.png" alt="camera" class="serv_img_m tr_c">

                    <div class="serv_text_m">

                        <h2 data-i18n="serv_m.pt2.pt2">Veio turistar nos EUA e quer ficar um pouco mais?</h2>
                        <p data-i18n="serv_m.pt2.pt3">A Extensão de Status é um processo recomendado para quem está nos
                            Estados Unidos com um status de turista válido e deseja ficar por um período maior de tempo.
                            Com esse processo você ganha mais 6 meses de permanência legal no país para continuar com
                            sua programação de passeios e viagens pelo país e aproveitar ao máximo. A Connection USA te
                            ajuda com todo o processo burocrático, desde a montagem até a aprovação do seu processo.</p>
                    </div>

                    <img src="/home/img/setas-direitas.png" alt="seta para a direita" class="serv_set_m">

                </div>
                <div class="serv_m_3 s_m" data-index="3">
                    <span class="circ_m"></span>
                    <div class="serv_title_m">
                        <h1 data-i18n="serv_m.pt3.pt1">Vistos e Outros Serviços</h1>

                    </div>

                    <img src="/home/img/ptserv3.png" alt="camera" class="serv_img_m tr_c">

                    <div class="serv_text_m">

                        <h2 data-i18n="serv_m.pt3.pt2">A Connection USA oferece suporte para vistos e muito mais!</h2>
                        <p data-i18n="serv_m.pt3.pt3">Oferecemos suporte para vistos, incluindo visto de turismo,
                            estudante, vistos de intercâmbio cultural, tais como aupair e work and travel, vistos e
                            GreenCard por trabalho, tais como EB2, EB2-NIW e EB3, visto religioso, visto de artista, e
                            muitos outros. Também te ajudamos com a aplicação ou renovação do seu passaporte brasileiro
                            no Brasil, aplicação ou renovação do passaporte americano nos EUA, e aplicação ao programa
                            do Global Entry.</p>
                    </div>

                    <img src="/home/img/setas-direitas.png" alt="seta para a direita" class="serv_set_m">

                </div>
                <div class="serv_m_4 s_m" data-index="4">
                    <span class="circ_m"></span>
                    <div class="serv_title_m">
                        <h1 data-i18n="serv_m.pt4.pt1">Green Card por Casamento</h1>

                    </div>

                    <img src="/home/img/ptserv4.png" alt="camera" class="serv_img_m tr_c">

                    <div class="serv_text_m">

                        <h2 data-i18n="serv_m.pt4.pt2">Se casou com um americano e não sabe por onde começar a aplicação
                            do seu Green card?</h2>
                        <p data-i18n="serv_m.pt4.pt3">Essa categoria de Green Card é uma forma de reunificação familiar
                            e permite que o cônjuge estrangeiro viva e trabalhe legalmente nos Estados Unidos de forma
                            permanente. Para obter o Green Card por casamento, o casal precisa comprovar que têm um
                            casamento válido e genuíno, e não apenas com o objetivo de obter benefícios migratórios. É
                            necessário fornecer evidências sólidas de que o casamento é legítimo, como fotos do
                            casamento, contas bancárias conjuntas, contas de serviços públicos em ambos os nomes, entre
                            outros documentos.</p>
                    </div>

                    <img src="/home/img/setas-direitas.png" alt="seta para a direita" class="serv_set_m">

                </div>
                <div class="serv_m_5 s_m" data-index="5">
                    <span class="circ_m"></span>
                    <div class="serv_title_m">
                        <h1 data-i18n="serv_m.pt5.pt1">Removal of Conditions</h1>

                    </div>

                    <img src="/home/img/ptserv5.png" alt="camera" class="serv_img_m tr_c">

                    <div class="serv_text_m">

                        <h2 data-i18n="serv_m.pt5.pt2">Seu GreenCard de 2 anos está vencendo?</h2>
                        <p data-i18n="serv_m.pt5.pt3">Esse é um processo obrigatório de renovação do Green Card, para
                            aqueles portadores do Green Card após o casamento. O Green Card por casamento, vem com
                            validade de 2 anos, e ele é condicional, ou seja, você deve manter um casamento em boa fé.
                            Após os 2 anos de validade do Green Card por casamento, é obrigatório aplicar para o removal
                            of conditions, ou seja, você remove essa condição de estar casado e recebe um novo Green
                            Card com validade de 10 anos.</p>
                    </div>

                    <img src="/home/img/setas-direitas.png" alt="seta para a direita" class="serv_set_m">

                </div>
                <div class="serv_m_6 s_m" data-index="6">
                    <span class="circ_m"></span>
                    <div class="serv_title_m">
                        <h1 data-i18n="serv_m.pt6.pt1">Cidadania Americana</h1>

                    </div>

                    <img src="/home/img/ptserv6.png" alt="camera" class="serv_img_m tr_c">

                    <div class="serv_text_m">

                        <h2 data-i18n="serv_m.pt6.pt2">Já cumpriu o tempo mínimo como Residente Permanente e quer
                            aplicar para sua Cidadania?</h2>
                        <p data-i18n="serv_m.pt6.pt3">Uma pessoa pode se tornar um cidadã dos EUA através de diversos
                            meios, como nascimento nos Estados Unidos, ter um pai ou mãe cidadão dos EUA ou através do
                            processo de naturalização. Para todos esses processos, uma série específica de requisitos
                            legais deve ser atendida. Se você quer aplicar para sua cidadania através do processo de
                            naturalização, a Connection USA está aqui para te ajudar. Para isso, você precisa ser um
                            Residente Permanente Legal no país (portador de um GreenCard) por um período específico de
                            tempo, que pode ser de 3 ou 5 anos. Após esse período você já pode se naturalizar nos
                            Estados Unidos e receber o tão sonhado Passaporte Americano para disfrutar de todos os
                            benefícios de ser um cidadão dos Estados Unidos.</p>
                    </div>

                    <img src="/home/img/setas-direitas.png" alt="seta para a direita" class="serv_set_m">

                </div>
            </div>

            <div id="serv">
                <div class="fund"></div>
                <div class="divisaoprimeira">
                    <div class="serv1 servc" data-target="servinfo1">
                        <figure>

                            <img src="/home/img/ptserv1.png" alt="camera" class="imgservico tr_c">


                            <figcaption>
                                <p data-i18n="serv_m.pt1.pt1">Troca de Status</p>
                            </figcaption>

                        </figure>

                        <img src="/home/img/setas-direitas.png" alt="seta para a direita" class="imgseta">


                    </div>
                    <div class="serv2 servc" data-target="servinfo2">
                        <figure>

                            <img src="/home/img/ptserv2.png" alt="mapa com um carimbo e uma camera por cima"
                                class="imgservico tr_c">


                            <figcaption>
                                <p data-i18n="serv_m.pt2.pt1">Extensão de Status</p>
                            </figcaption>

                        </figure>

                        <img src="/home/img/setas-direitas.png" alt="seta para a direita" class="imgseta">



                    </div>
                    <div class="serv3 servc" data-target="servinfo3">
                        <figure>

                            <img src="/home/img/ptserv3.png" alt="mulher conversando por videoconferencia"
                                class="imgservico tr_c">


                            <figcaption>
                                <p data-i18n="serv_m.pt3.pt1">Vistos e Outros Serviços</p>
                            </figcaption>

                        </figure>

                        <img src="/home/img/setas-direitas.png" alt="seta para a direita" class="imgseta">


                    </div>
                </div>
                <div class="divisaosegunda">
                    <div class="serv4 servc" data-target="servinfo4">

                        <img src="/home/img/setas-direitas.png" alt="seta para a direita"
                            class="imgseta imgsetavirada">

                        <figure>

                            <img src="/home/img/ptserv4.png" alt="fotos antigas" class=" imgservico tr_c">


                            <figcaption>
                                <p data-i18n="serv_m.pt4.pt1">Green Card por Casamento</p>
                            </figcaption>

                        </figure>
                    </div>
                    <div class="serv5 servc" data-target="servinfo5">


                        <img src="/home/img/setas-direitas.png" alt="seta para a direita"
                            class="imgseta imgsetavirada">

                        <figure>

                            <img src="/home/img/ptserv5.png" alt="camera com mapa e carimbo" class="imgservico tr_c">


                            <figcaption>
                                <p data-i18n="serv_m.pt5.pt1">Removal of Conditions</p>
                            </figcaption>

                        </figure>
                    </div>
                    <div class="serv6 servc" data-target="servinfo6">


                        <img src="/home/img/setas-direitas.png" alt="seta para a direita"
                            class="imgseta imgsetavirada">

                        <figure>

                            <img src="/home/img/ptserv6.png" alt="mulher conversando por videoconferencia"
                                class="imgservico tr_c">


                            <figcaption>
                                <p data-i18n="serv_m.pt6.pt1">Cidadania Americana</p>
                            </figcaption>

                        </figure>
                    </div>
                </div>
                <div class="info1 info servinfo1">
                    <h1 data-i18n="serv_m.pt1.pt1">Troca de Status</h1>
                    <div class="text_">
                        <h2 data-i18n="serv_m.pt1.pt2">Quer trocar o seu status dentro dos EUA para estudar ou turistar
                            e não sabe como?</h2>
                        <p data-i18n="serv_m.pt1.pt3">Esta é uma ótima oportunidade para quem já está nos Estados
                            Unidos, como turista ou visto J-1 por exemplo, e deseja permanecer no país para estudar. Com
                            a Troca de Status você não precisa retornar ao seu país de origem para fazer o processo de
                            obtenção de visto. A Connection USA tem parceria com diversas escolas de inglês e consegue
                            te ajudar com todo o processo!</p>
                    </div>
                </div>
                <div class="info2 info servinfo2">
                    <h1 data-i18n="serv_m.pt2.pt1">Extensão de Status</h1>
                    <div class="text_">

                        <h2 data-i18n="serv_m.pt2.pt2">Veio turistar nos EUA e quer ficar um pouco mais?</h2>
                        <p data-i18n="serv_m.pt2.pt3">A Extensão de Status é um processo recomendado para quem está nos
                            Estados Unidos com um status de turista válido e deseja ficar por um período maior de tempo.
                            Com esse processo você ganha mais 6 meses de permanência legal no país para continuar com
                            sua programação de passeios e viagens pelo país e aproveitar ao máximo. A Connection USA te
                            ajuda com todo o processo burocrático, desde a montagem até a aprovação do seu processo.</p>
                    </div>
                </div>
                <div class="info3 info servinfo3">
                    <h1 data-i18n="serv_m.pt3.pt1">Vistos e Outros Serviços</h1>
                    <div class="text_">
                        <h2 data-i18n="serv_m.pt3.pt2">A Connection USA oferece suporte para vistos e muito mais!</h2>
                        <p data-i18n="serv_m.pt3.pt3">Oferecemos suporte para vistos, incluindo visto de turismo,
                            estudante, vistos de intercâmbio cultural, tais como aupair e work and travel, vistos e
                            GreenCard por trabalho, tais como EB2, EB2-NIW e EB3, visto religioso, visto de artista, e
                            muitos outros. Também te ajudamos com a aplicação ou renovação do seu passaporte brasileiro
                            no Brasil, aplicação ou renovação do passaporte americano nos EUA, e aplicação ao programa
                            do Global Entry.</p>
                    </div>
                </div>
                <div class="info4 info servinfo4">
                    <h1 data-i18n="serv_m.pt4.pt1">Green Card por Casamento</h1>
                    <div class="text_">
                        <h2 data-i18n="serv_m.pt4.pt2">Se casou com um americano e não sabe por onde começar a aplicação
                            do seu Green card?</h2>
                        <p class="alt_maior" data-i18n="serv_m.pt4.pt3">Essa categoria de Green Card é uma forma de
                            reunificação familiar e permite que o cônjuge estrangeiro viva e trabalhe legalmente nos
                            Estados Unidos de forma permanente. Para obter o Green Card por casamento, o casal precisa
                            comprovar que têm um casamento válido e genuíno, e não apenas com o objetivo de obter
                            benefícios migratórios. É necessário fornecer evidências sólidas de que o casamento é
                            legítimo, como fotos do casamento, contas bancárias conjuntas, contas de serviços públicos
                            em ambos os nomes, entre outros documentos.</p>
                    </div>
                </div>
                <div class="info5 info servinfo5">
                    <h1 data-i18n="serv_m.pt5.pt1">Removal of Conditions</h1>
                    <div class="text_">
                        <h2 data-i18n="serv_m.pt5.pt2">Seu GreenCard de 2 anos está vencendo?</h2>
                        <p data-i18n="serv_m.pt5.pt3">Esse é um processo obrigatório de renovação do Green Card, para
                            aqueles portadores do Green Card após o casamento. O Green Card por casamento, vem com
                            validade de 2 anos, e ele é condicional, ou seja, você deve manter um casamento em boa fé.
                            Após os 2 anos de validade do Green Card por casamento, é obrigatório aplicar para o removal
                            of conditions, ou seja, você remove essa condição de estar casado e recebe um novo Green
                            Card com validade de 10 anos.</p>
                    </div>
                </div>
                <div class="info6 info servinfo6">
                    <h1 data-i18n="serv_m.pt6.pt1">Cidadania Americana</h1>
                    <div class="text_">
                        <h2 data-i18n="serv_m.pt6.pt2">Já cumpriu o tempo mínimo como Residente Permanente e quer
                            aplicar para sua Cidadania?</h2>
                        <p data-i18n="serv_m.pt6.pt3">Uma pessoa pode se tornar um cidadã dos EUA através de diversos
                            meios, como nascimento nos Estados Unidos, ter um pai ou mãe cidadão dos EUA ou através do
                            processo de naturalização. Para todos esses processos, uma série específica de requisitos
                            legais deve ser atendida. Se você quer aplicar para sua cidadania através do processo de
                            naturalização, a Connection USA está aqui para te ajudar. Para isso, você precisa ser um
                            Residente Permanente Legal no país (portador de um GreenCard) por um período específico de
                            tempo, que pode ser de 3 ou 5 anos. Após esse período você já pode se naturalizar nos
                            Estados Unidos e receber o tão sonhado Passaporte Americano para disfrutar de todos os
                            benefícios de ser um cidadão dos Estados Unidos.</p>
                    </div>
                </div>

            </div>


        </section>

        <section id="consul_inter">
            <div id="consultoria" class="obs">
                <section class="consul_texto">
                    <h1 data-i18n="consultoria.pt1">Consultoria Gratuita</h1>
                    <p>
                        <span data-i18n="consultoria.pt2.pt1">A Connection USA oferece uma sessão de planejamento
                            gratuita exclusiva para você tirar todas as suas dúvidas sobre </span>
                        <strong>
                            <span data-i18n="consultoria.pt2.pt2">processos imigratórios!</span>
                        </strong>
                        <span data-i18n="consultoria.pt2.pt3"> O atendimento por vídeo chamada ou chamada de voz tem
                            duração de até 30 minutos e um de nossos especialistas vai tirar suas dúvidas e explicar
                            tudo o que você precisa saber sobre o processo.</span>
                    </p>
                    <p class="extw" data-i18n="consultoria.pt3">Disponível apenas para Processos Imigratórios!
                        Consultoria para processo de visto disponível por WhatsApp. Não perca tempo. Agende já sua
                        chamada.</p>
                    <h2>
                        <span data-i18n="consultoria.pt4.pt1">Não perca tempo.</span>
                        <strong data-i18n="consultoria.pt4.pt2">Agende</strong>
                        <span data-i18n="consultoria.pt4.pt3">já sua chamada.</span>
                    </h2>
                    <a href="https://wa.me/17149367257"><button class="agend">
                            <p data-i18n="consultoria.pt5">Agendar a minha reunião agora</p>

                            <img src="/home/img/set_button.png" alt="seta para a direita">


                        </button></a>
                </section>

                <div class="consul_video">
                    <video class="conns" controls="" poster="/home/img/consul.png">
                        <source src="/home/img/consul1.mp4" type="video/mp4">
                        Seu navegador não suporta este vídeo.
                    </video>
                </div>
            </div>
            <div id="intercambio" class="obs">
                <div class="intercambio">
                    <h1 data-i18n="intercambio.pt1">Faça seu intercâmbio conosco</h1>
                    <p data-i18n="intercambio.pt2">A Connection USA te auxilia em cada etapa do processo, desde a sua
                        matrícula em uma escola parceira, até a aprovação do seu visto. Venha fazer um intercâmbio
                        inesquecível e viver a melhor experiência da sua vida!</p>
                </div>
                <div class="vi_m">

                    <img src="/home/img/smart.png" alt="tela de celular iphone" class="smart">

                    <video class="video_smart esli" controls="" poster="/home/img/vv.png">
                        <source src="/home/img/vd6.mp4" type="video/mp4">
                        Seu navegador não suporta este vídeo.
                    </video>
                </div>
            </div>
        </section>

        <section id="percentual">
            <div class="divpai2">
                <div class="divfi2">
                    <div class="perc_efect">
                        <p data-i18n="percentual.title">Seu sucesso é a nossa satisfação</p>
                        <div class="bottom-left-line2"></div>
                        <div class="top-right-line2"></div>
                    </div>
                </div>
            </div>

            <div class="circulo">
                <svg>
                    <circle cx="5.23vw" cy="5.23vw" r="3.66vw"></circle>
                    <circle cx="5.23vw" cy="5.23vw" r="3.66vw" class="obs"></circle>
                    <circle cx="15.68vw" cy="15.68vw" r="3.66vw"></circle>
                    <circle cx="15.68vw" cy="15.68vw" r="3.66vw" class="obs"></circle>
                    <circle cx="26.17vw" cy="26.17vw" r="3.66vw"></circle>
                    <circle cx="26.17vw" cy="26.17vw" r="3.66vw" class="obs"></circle>
                </svg>
            </div>

            <div class="circulo_m">
                <svg>
                    <circle cx="50%" cy="80px" r="50px"></circle>
                    <circle cx="50%" cy="80px" r="50px" class="c1 obs"></circle>
                </svg>
                <p id="progress_1_m" class="cir_per1_m n_m obs">0%</p>

                <p class="cir__m ct1" data-i18n="percentual.pt1">de satisfação dos serviços da Connection USA pois
                    sempre há espaço para melhorar.</p>

                <svg>
                    <circle cx="50%" cy="80px" r="50px"></circle>
                    <circle cx="50%" cy="80px" r="50px" class="c2 obs"></circle>
                </svg>
                <p id="progress_2_m" class="cir_per2_m n_m obs">0%</p>
                <p class="cir__m ct2" data-i18n="percentual.pt2">de profissionalismo e competência na montagem de todos
                    os processos.</p>
                <svg>
                    <circle cx="50%" cy="80px" r="50px"></circle>
                    <circle cx="50%" cy="80px" r="50px" class="c3 obs"></circle>
                </svg>
                <p id="progress_3_m" class="cir_per3_m n_m obs">0%</p>
                <p class="cir__m ct3" data-i18n="percentual.pt2">de profissionalismo e competência na montagem de todos
                    os processos.</p>
            </div>

            <div id="cir_frases">
                <p id="progress_1" class="cir_per1 cir obs">0</p>
                <p id="progress_2" class="cir_per2 cir obs"></p>
                <p id="progress_3" class="cir_per3 cir obs"></p>
                <p class="cir_fr1" data-i18n="percentual.pt1">de satisfação dos serviços da Connection USA pois sempre
                    há espaço para melhorar.</p>
                <p class="cir_fr2" data-i18n="percentual.pt2">de profissionalismo e competência na montagem de todos os
                    processos.</p>
                <p class="cir_fr3" data-i18n="percentual.pt3">de aprovação em processos de Greencard.</p>
            </div>


            <img src="/home/img/grafic.png" class="gr obs" alt="gráfico">


        </section>

        <section id="greencard">
            <span class="fund_g"></span>
            <div class="tit_green">
                <h1><span data-i18n="greencard.title.pt1">Já se casou e vai aplicar para o seu</span> Green Card</h1>
            </div>

            <div class="green_m">

                <div class="subt">
                    <h2 data-i18n="greencard.pt1">Deixe a burocracia conosco! A Connection USA é uma empresa
                        especializada em processos imigratórios e está aqui pra te ajudar!</h2>
                </div>
                <div class="sp_m">

                    <img src="/home/img/imgreen.png" alt="green card" class="pass_m">


                    <span class="s1_m"></span>
                    <span class="s2_m"></span>
                </div>
            </div>

            <div class="green2_m">


                <img src="/home/img/imgreen.png" alt="green card" class="pass obs">


                <div class="pt obs">
                    <article data-i18n="greencard.art">Com uma taxa de 100% de aprovação, oferecemos uma assessoria
                        completa e minuciosa para a montagem e acompanhamento do seu processo. Estamos sempre atentos
                        aos mínimos detalhes para dar uma maior chance de aprovação e menor possibilidade de imprevistos
                        e dores de cabeça. Fazemos o acompanhamento total do seu processo até que você receba o seu
                        GreenCard em mãos! A Connection USA está sempre um passo à frente para garantir sua satisfação e
                        o melhor resultado possível.</article>

                    <button class="bttpt">
                        <a href="" class="sss" data-i18n="greencard.contato">Fale conosco</a>
                    </button>
                    <div class="ef">
                        <a href="" data-i18n="greencard.contato">Fale conosco</a>
                    </div>
                </div>

                <span class="s1"></span>
                <span class="s2"></span>

                <span class="sx ss1 obs"></span>
                <span class="sx ss2 obs"></span>
                <span class="sx ss3 obs"></span>
                <span class="sx ss4 obs"></span>
            </div>

        </section>

        <section id="depoimentos">
            <div class="divpai">
                <div class="divfi">
                    <div class="perc_efect">
                        <p data-i18n="depoimentos.title">Depoimentos</p>
                        <div class="bottom-left-line"></div>
                        <div class="top-right-line"></div>
                    </div>
                </div>
            </div>

            <div id="depoimentos_m">
                /<div class="depvideo_m dep_m">
                    <video class="vd8" controls="" poster="/home/img/depoimento8.png">
                        <source src="/home/img/depoimento8.mp4" type="video/mp4">
                        Seu navegador não suporta este vídeo.
                    </video>
                </div>
                /<div class="depvideo_m dep_m">
                    <video class="vd2" controls="" poster="/home/img/depoimento2.png">
                        <source src="/home/img/depoimento2.mp4" type="video/mp4">
                        Seu navegador não suporta este vídeo.
                    </video>
                </div>
                /<div class="depvideo_m dep_m">
                    <video class="vd1" controls="" poster="/home/img/depoimento1.png">
                        <source src="/home/img/depoimento1.mp4" type="video/mp4">
                        Seu navegador não suporta este vídeo.
                    </video>
                </div>
                /<div class="depvideo_m dep_m">
                    <video class="vd3" controls="" poster="/home/img/depoimento3.png">
                        <source src="/home/img/depoimento3.mp4" type="video/mp4">
                        Seu navegador não suporta este vídeo.
                    </video>
                </div>

                /<div class="depvideo_m dep_m">
                    <video class="vd4" controls="" poster="/home/img/depoimento4.png">
                        <source src="/home/img/depoimento4.mp4" type="video/mp4">
                        Seu navegador não suporta este vídeo.
                    </video>
                </div>
                /<div class="depvideo_m dep_m">
                    <video class="vd5" controls="" poster="/home/img/depoimento5.png">
                        <source src="/home/img/depoimento5.mp4" type="video/mp4">
                        Seu navegador não suporta este vídeo.
                    </video>
                </div>
                /<div class="depvideo_m dep_m">
                    <video class="vd6" controls="" poster="/home/img/depoimento6.png">
                        <source src="/home/img/depoimento6.mp4" type="video/mp4">
                        Seu navegador não suporta este vídeo.
                    </video>
                </div>
                /<div class="depvideo_m dep_m">
                    <video class="vd7" controls="" poster="/home/img/depoimento7.png">
                        <source src="/home/img/depoimento7.mp4" type="video/mp4">
                        Seu navegador não suporta este vídeo.
                    </video>
                </div>

                /<div class="depvideo_m dep_m">
                    <video class="vd7" controls="" poster="/home/img/depoimento10.png">
                        <source src="/home/img/depoimento10.mp4" type="video/mp4">
                        Seu navegador não suporta este vídeo.
                    </video>
                </div>
                /<div class="depescrito_m dep_m">
                    <div class="divum_m">
                        <p class="name_m">Marcos</p>
                        <div class="estrelas_m">

                            <img src="/home/img/estrela.png" alt="estrela">


                            <img src="/home/img/estrela.png" alt="estrela">


                            <img src="/home/img/estrela.png" alt="estrela">


                            <img src="/home/img/estrela.png" alt="estrela">


                            <img src="/home/img/estrela.png" alt="estrela">

                        </div>
                    </div>
                    <div class="divdois_m">
                        <p class="comentario_m" data-i18n="depoimentos.pt3">Muito obrigado Matheus! Você é um
                            maravilhosinho! Obrigada pela paciência e atenção! Mesmo com meus montes de perguntas,
                            confusões e insegurança você respondeu até perguntas que nem eram referentes ao processo!
                            Com muita atenção, cuidado e educação! Obrigada mesmo ❤️! Bênçãos sem medida na tua vida e
                            trabalho</p>
                    </div>
                </div>
                /<div class="depvideo_m dep_m">
                    <video class="vd7" controls="" poster="/home/img/depoimento9.png">
                        <source src="/home/img/depoimento9.mp4" type="video/mp4">
                        Seu navegador não suporta este vídeo.
                    </video>
                </div>
                /<div class="depescrito_m dep_m">
                    <div class="divum_m">
                        <p class="name_m">Rose Meury</p>
                        <div class="estrelas_m">

                            <img src="/home/img/estrela.png" alt="estrela">

                            <img src="/home/img/estrela.png" alt="estrela">


                            <img src="/home/img/estrela.png" alt="estrela">


                            <img src="/home/img/estrela.png" alt="estrela">


                            <img src="/home/img/estrela.png" alt="estrela">

                        </div>
                    </div>
                    <div class="divdois_m">
                        <p class="comentario_m" data-i18n="depoimentos.pt2">Muito obrigado por me dar esse ótimo atendimento... Você é uma pessoa que faz seu trabalho com excelência... coisa que é muito difícil de encontrar hoje em dia... Parabéns!</p>
                    </div>
                </div>
            </div>
            <div class="slider-content">
                <div id="setas">
                    <div class="esquerda">
                        <img src="/home/img/setas-esquerda.png" alt="seta para a esquerda">

                    </div>
                    <div class="direita">
                        <img src="/home/img/setas-direitas.png" alt="seta para a direita">

                    </div>
                </div>

                <div class="slide-box primeiro">
                    <div class="um">
                        /<div class="depvideo dep">
                            <video class="vd2" controls="" poster="/home/img/depoimento2.png">
                                <source src="/home/img/depoimento2.mp4" type="video/mp4">
                                Seu navegador não suporta este vídeo.
                            </video>
                        </div>
                        /<div class="depvideo dep">
                            <video class="vd1" controls="" poster="/home/img/depoimento1.png">
                                <source src="/home/img/depoimento1.mp4" type="video/mp4">
                                Seu navegador não suporta este vídeo.
                            </video>
                        </div>
                        /<div class="depvideo dep">
                            <video class="vd5" controls="" poster="/home/img/depoimento5.png">
                                <source src="/home/img/depoimento5.mp4" type="video/mp4">
                                Seu navegador não suporta este vídeo.
                            </video>
                        </div>
                        /<div class="depvideo dep">
                            <video class="vd8" controls="" poster="/home/img/depoimento8.png">
                                <source src="/home/img/depoimento8.mp4" type="video/mp4">
                                Seu navegador não suporta este vídeo.
                            </video>
                        </div>
                    </div>
                </div>
                <div class="slide-box">
                    <div class="um f">
                        /<div class="depvideo dep">
                            <video class="vd3" controls="" poster="/home/img/depoimento3.png">
                                <source src="/home/img/depoimento3.mp4" type="video/mp4">
                                Seu navegador não suporta este vídeo.
                            </video>
                        </div>
                        /<div class="depvideo dep">
                            <video class="vd4" controls="" poster="/home/img/depoimento4.png">
                                <source src="/home/img/depoimento4.mp4" type="video/mp4">
                                Seu navegador não suporta este vídeo.
                            </video>
                        </div>
                        /<div class="depvideo dep">
                            <video class="vd6" controls="" poster="/home/img/depoimento6.png">
                                <source src="/home/img/depoimento6.mp4" type="video/mp4">
                                Seu navegador não suporta este vídeo.
                            </video>
                        </div>
                        /<div class="depvideo dep">
                            <video class="vd7" controls="" poster="/home/img/depoimento7.png">
                                <source src="/home/img/depoimento7.mp4" type="video/mp4">
                                Seu navegador não suporta este vídeo.
                            </video>
                        </div>
                    </div>
                </div>
                <div class="slide-box">
                    <div class="um g">
                        /<div class="depvideo dep">
                            <video class="vd5" controls="" poster="/home/img/depoimento10.png">
                                <source src="/home/img/depoimento10.mp4" type="video/mp4">
                                Seu navegador não suporta este vídeo.
                            </video>
                        </div>
                        /<div class="depescrito dep">
                            <div class="divum">
                                <p class="name">Marcos</p>
                                <div class="estrelas">

                                    <img src="/home/img/estrela.png" alt="estrela">


                                    <img src="/home/img/estrela.png" alt="estrela">


                                    <img src="/home/img/estrela.png" alt="estrela">


                                    <img src="/home/img/estrela.png" alt="estrela">


                                    <img src="/home/img/estrela.png" alt="estrela">

                                </div>
                            </div>
                            <div class="divdois">
                                <p class="comentario" data-i18n="depoimentos.pt3">Muito obrigado Matheus! Você é um
                                    maravilhosinho! Obrigada pela paciência e atenção! Mesmo com meus montes de
                                    perguntas, confusões e insegurança você respondeu até perguntas que nem eram
                                    referentes ao processo! Com muita atenção, cuidado e educação! Obrigada mesmo ❤️!
                                    Bênçãos sem medida na tua vida e trabalho</p>
                            </div>
                        </div>
                        /<div class="depvideo dep">
                            <video class="vd6" controls="" poster="/home/img/depoimento9.png">
                                <source src="/home/img/depoimento9.mp4" type="video/mp4">
                                Seu navegador não suporta este vídeo.
                            </video>
                        </div>
                        /<div class="depescrito dep">
                            <div class="divum">
                                <p class="name">Rose Meury</p>
                                <div class="estrelas">

                                    <img src="/home/img/estrela.png" alt="estrela">


                                    <img src="/home/img/estrela.png" alt="estrela">


                                    <img src="/home/img/estrela.png" alt="estrela">


                                    <img src="/home/img/estrela.png" alt="estrela">


                                    <img src="/home/img/estrela.png" alt="estrela">

                                </div>
                            </div>
                            <div class="divdois">
                                <p class="comentario" data-i18n="depoimentos.pt2">Muito obrigado por me dar esse ótimo
                                    atendimento... Você é uma pessoa que faz seu trabalho com excelência... coisa que é
                                    muito difícil de encontrar hoje em dia... Parabéns!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nav-manual">
                    <span id="radio1" class="radio" data-index="1"></span>
                    <span id="radio2" class="radio" data-index="2"></span>
                    <span id="radio3" class="radio" data-index="3"></span>
                </div>
            </div>

        </section>

        <script>
       
    </script>

    <div id="insta_m">

        <div class="i_m">
            <div class="fundo2_insta_m"></div>

            <img src="/home/img/insta.png" class="fotoinsta_m" alt="instagram">

            <article>@CONNECTIONUSA_</article>
        </div>

        <div class="fundo_insta"></div>
        <span class="separa_1"></span>
        <span class="separa_2"></span>

    </div>

    <div id="insta">
        <article>@CONNECTIONUSA_</article>
        <div class="insta_">

            <img src="/home/img/insta.png" class="fotoinsta" alt="instagram">


        </div>
        <div class="finst"></div>
    </div>

    <header id="fim">
        <div class="he">

            <img src="/home/img/hea_viag.png" alt="aeroporto" class="hea_viag">


        </div>
        <div class="infoheader">
            <h1>CONNECTION USA <br data-i18n="infoheader.pt1"></h1>

            <img src="/home/img/logo.png" alt="logomarca da empresa">


            <button>
                <a href="https://wa.me/17149367257" data-i18n="infoheader.pt2">Saiba mais</a>
            </button>
            <h1 class="h1__" data-i18n="infoheader.pt3"> 'Tudo posso naquele que me fortalece.' (Filipenses 4:13)
            </h1>
            <a href="https://politica.connectionusa.net" class="politica" style="line-height: 1.5vw"
                data-i18n="infoheader.pt4">Política de Privacidade</a>

        </div>
        <div class="creator">
            <a href="https://magnossites.com" data-i18n="desenvolvedor">2024 © Desenvolvido por Magnos. Todos os
                direitos reservados</a>

        </div>
    </header>
    <div id="b"></div>
    </div>

    <script src="https://unpkg.com/i18next/i18next.js" defer=""></script>
    <script src="https://unpkg.com/i18next-http-backend/i18nextHttpBackend.js" defer=""></script>
    <script src="https://unpkg.com/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.js"
        defer=""></script>
    <script defer="">
        document.addEventListener('DOMContentLoaded', function() {

            const flags = {
                pt: document.getElementById('flag-pt'),
                en: document.getElementById('flag-en'),
                es: document.getElementById('flag-es')
            };

            const serv1 = {

            }

            i18next
                .use(i18nextHttpBackend)
                .use(i18nextBrowserLanguageDetector)
                .init({
                    fallbackLng: 'pt',
                    backend: {
                        loadPath: 'home/js/{{lng}}.json',
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

                        const divs = document.querySelectorAll('.imgservico');
                        const divs_m = document.querySelectorAll('.serv_img_m');
                        let a = 0;
                        let arr = []

                        if (innerWidth <= 1024) {
                            divs_m.forEach((div, index) => {
                                a++;
                                arr.push(div);
                                if (index < 6) {
                                    div.src = `/home/img/${lang}serv${index + 1}.png`;
                                }
                            });
                        } else {
                            divs.forEach((div, index) => {
                                a++;
                                arr.push(div);
                                if (index < 6) {
                                    div.src = `/home/img/${lang}serv${index + 1}.png`;
                                }
                            });
                        }

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
            
        const data = <?= $conteudo ?>;
        const images = data.data;
        let conteudo = "<div class='estilo_instaa'>";

        for (let i = 0; i < 10; i++) {
            let feed = images[i];
            let titulo = feed.caption !== null ? feed.caption : "";
            let tipo = feed.media_type;

            if (tipo === "VIDEO") {
            } else if (tipo === "IMAGE" || tipo === "CAROUSEL_ALBUM") {
                conteudo += '<div class="img_instaa"><img title="' + titulo + '" alt="' + titulo + '" src="' + feed.media_url + '" onclick="window.open(\'' + feed.permalink + '\');"></div>';
            }
        }

        conteudo += "<a href='https://www.instagram.com/connectionusa_/'><div class='insta'><img src='home/img/insta.png' alt='instagram'></div></a></div>";
        document.querySelector(".finst").innerHTML = conteudo;
        document.querySelector(".fundo_insta").innerHTML = conteudo;

        });
        if (window.innerWidth > 1245) {
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

        }
    </script>
    <script type="text/javascript" src="/home/js/javas.js" defer=""></script>


</body>

</html>