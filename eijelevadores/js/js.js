const frases = document.querySelectorAll('.frases h1');
const frasesp = document.querySelectorAll('.frases p');
const bolinhas = document.querySelectorAll('.bolinha');
let fraseAtual = 0;
let temporizador; // Variável para armazenar o temporizador

function typeWriter(elemento) {
  const textoArray = elemento.innerHTML.split('');
  elemento.innerHTML = '';
  textoArray.forEach((letra, i) => {
    setTimeout(() => elemento.innerHTML += letra, 60 * i);
  });
}



function mostrarFrase(indice) {
  frases.forEach((frase, i) => {

    if (i === indice) {
      frase.style.display = 'block';

      let titulo = document.querySelector('.animada' + i);

      function typeWriter(elemento) {
        const textoArray = elemento.innerHTML.split('');
        elemento.innerHTML = '';
        textoArray.forEach((letra, i) => {
          setTimeout(() => elemento.innerHTML += letra, 75 * i);
        });
      }
      typeWriter(titulo);


    } else {
      frase.style.display = 'none';
    }
  });


  frasesp.forEach((frase, i) => {

    if (i === indice) {
      frase.style.display = 'block';

      const paragrafo = document.querySelector('.animep' + i);
      function typeWriterr(elemento) {
        const textoArrayy = elemento.innerHTML.split('');
        elemento.innerHTML = '';
        textoArrayy.forEach((letra, i) => {
          setTimeout(() => elemento.innerHTML += letra, 40 * i);
        });
      }



      typeWriterr(paragrafo);


    } else {
      frase.style.display = 'none';
    }
  });


}

function avancarFrase() {
  fraseAtual = (fraseAtual + 1) % frases.length;
  mostrarFrase(fraseAtual);
}
let variavel = 0;
bolinhas.forEach((bolinha, i) => {
  
  bolinha.addEventListener('click', () => {
    // Quando uma bolinha é clicada, atualizamos o índice da frase e mostramos a frase correspondente
    fraseAtual = i;
    mostrarFrase(fraseAtual);

    // Limpamos o temporizador anterior e iniciamos um novo
    clearInterval(temporizador);
    temporizador = setInterval(avancarFrase, 7000);
  });
});

$(".bolinha").click(function(){
  variavel = variavel + 1;
})





// Iniciar o carrossel
mostrarFrase(fraseAtual);

// Iniciar o temporizador
temporizador = setInterval(avancarFrase, 7000);


window.addEventListener('scroll', function () {
  var menu = document.getElementById('menu');

  if (window.scrollY >= 870) { // Altere para a posição desejada (0px do topo)
    menu.classList.add('fixed');
  } else {
    menu.classList.remove('fixed');
  }
});


var alturaMinima = 600; // Altura mínima para ativar o efeito
var alturaMaxima = 1400; // Altura máxima para ativar o efeito
var linha1 = document.querySelector(".linha1");
var linha2 = document.querySelector(".linha2");
var visivel = false; // Variável para controlar a visibilidade do efeito
var ac = document.querySelector("#imginfor");
var elementos = document.getElementsByClassName("tt");
var um = elementos[0];
var dois = elementos[1];
var tres = elementos[2];
var quatro = elementos[3];

document.addEventListener("scroll", function () {
  var scrollTop = window.scrollY;
  var info = document.querySelector("#diferenciais h1");

  // Verifica se a rolagem está entre a altura mínima e a altura máxima
  if (scrollTop >= alturaMinima && scrollTop <= alturaMaxima) {
    if (!visivel) {
      linha1.style.left = "49vw";
      linha2.style.bottom = "40%";
      ac.classList.add("rota");
      visivel = true; // Marca o efeito como visível
      typeWriter(um);
      typeWriter(dois);
      typeWriter(tres);
      typeWriter(quatro);
    }
  } else if (visivel) {
    linha1.style.left = "0";
    linha2.style.bottom = "0";
    ac.classList.remove("rota");
    visivel = false; // Marca o efeito como invisível
  }
});

let con = document.getElementById("contat");
let c = $("#contat");
let con2 = document.getElementById("contat2");
let marginTopOriginal = parseFloat(c.css("margin-top"));

$(document).ready(function () {
  $("#contat").mouseenter(function () {
    con.style.backgroundColor = "#653567";
    con2.style.backgroundColor = "#7ED957";
    con.style.border = "4px solid white";
    $(".im1").css("display", "none");
    $(".im2").css("display", "block");
    c.animate({
      marginTop: (marginTopOriginal + 8) + "px" // Subir 10 pixels suavemente
    }, 200);


  });

  $("#contat").mouseleave(function () {
    con.style.backgroundColor = "#7ED957";
    con2.style.backgroundColor = "#653567";
    con.style.marginTop = "4vw";
    con.style.border = "none";
    $(".im1").css("display", "block");
    $(".im2").css("display", "none");

    c.animate({
      marginTop: marginTopOriginal + "px" // Voltar à posição original suavemente
    }, 200);

  });
});

const sobre = document.querySelector("#sobre p");
let animacaoIniciada = false;

document.addEventListener("scroll", function () {
  var scrollTop2 = window.scrollY;

  if (scrollTop2 >= 1350 && scrollTop2 <= 2050 && !animacaoIniciada) {
    animacaoIniciada = true;

    function typeWriter(elemento) {
      return new Promise((resolve) => {
        const textoArray = elemento.innerHTML.split('');
        elemento.innerHTML = '';
        let i = 0;

        function escreverProximaLetra() {
          if (i < textoArray.length) {
            elemento.innerHTML += textoArray[i];
            i++;
            setTimeout(escreverProximaLetra, 5);
          } else {
            resolve(); // Resolva a promessa quando a animação estiver concluída
          }
        }

        escreverProximaLetra();
      });
    }

    typeWriter(sobre).then(() => {
      animacaoIniciada = false; // Redefine a variável de controle após a conclusão da animação
    });
  }
});


$(document).ready(function () {
  var opcoes = $(".art");
  var quadrados = $(".princs");

  opcoes.click(function () {
    var index = opcoes.index(this);

    quadrados.removeClass("active");
    quadrados.eq(index).addClass("active").fadeIn(300);
  });
});


$(document).ready(function () {
  const carousel = $(".carousel");
  let currentIndex = 0;

  function moveCarousel() {
    currentIndex = (currentIndex + 1) % 4;
    const offset = -currentIndex * (18 + 9) + "vw";
    carousel.animate({ marginLeft: offset }, 1000, "linear");
  }

  setInterval(moveCarousel, 4000);
});


let cc = $("#contat11");
let con11 = document.getElementById("contat11");
let con22 = document.getElementById("contat22");
let marginTopOriginall = parseFloat(cc.css("margin-top"));

$(document).ready(function () {
  $("#contat11").mouseenter(function () {
    con11.style.backgroundColor = "#653567";
    con22.style.backgroundColor = "#7ED957";
    con11.style.border = "4px solid white";
    $(".im1").css("display", "none");
    $(".im2").css("display", "block");
    cc.animate({
      marginTop: (marginTopOriginall + 8) + "px" // Subir 10 pixels suavemente
    }, 200);


  });

  $("#contat11").mouseleave(function () {
    con11.style.backgroundColor = "#7ED957";
    con22.style.backgroundColor = "#653567";
    con11.style.marginTop = "4vw";
    con11.style.border = "none";
    $(".im1").css("display", "block");
    $(".im2").css("display", "none");

    cc.animate({
      marginTop: marginTopOriginall + "px" // Voltar à posição original suavemente
    }, 200);

  });
});



$(document).ready(function () {
  $(".pergunta").click(function () {
    // Encontre a resposta associada à pergunta clicada
    var resposta = $(this).next(".resposta");

    // Exiba ou oculte a resposta com uma animação de deslizamento
    resposta.slideToggle(function () {
      // Verifique se o display é 'block' após a animação
      if (resposta.css('display') === 'block') {
        // Altere o display para 'flex'
        resposta.css('display', 'flex');
      }
    });
  });
});

$(document).ready(function () {
  // Adicione um clique para todos os links internos que começam com #
  $("a[href^='#']").on('click', function (e) {
    e.preventDefault();

    var target = this.hash;
    var $target = $(target);

    // Animação de rolagem suave para o destino
    $('html, body').stop().animate({
      'scrollTop': $target.offset().top
    }, 900, 'swing', function () {
      window.location.hash = target;
    });
  });
});

let burger = document.getElementById('burger'),
  nav = document.getElementById('main-nav');
  let aa = document.getElementsByClassName("men");

burger.addEventListener('click', function (e) {
  this.classList.toggle('is-open');
  nav.classList.toggle('is-open');
});


const device = $(".device");

$("#burger").on("click", function () {
  if (device.css("position") === "static") {
    device.css("z-index", 100);
    device.css("position", "fixed");
  } else {
    device.css("z-index", -2);
    device.css("position", "static");
  }
});

$(".main-nav ul li a").on("click", function () {
  
    device.css("z-index", -2);
    device.css("position", "static");
    burger.classList.toggle('is-open');
    nav.classList.toggle('is-open');
  
});