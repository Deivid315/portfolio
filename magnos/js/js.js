var balls = document.querySelector(".balls")
var quant = document.querySelectorAll(".slides .image")
var atual = 0
var imagem = document.getElementById("atual")

var next = document.getElementById("next")
var voltar = document.getElementById("voltar")
var rolar = true

/* function _0x168a(){var _0x3faa52=['451155tHQMWo','240JeKIqr','265599nAmvEb','16048076efTfWv','8kLVgbr','getElementById','82402cxdWqD','4025238wpGJfu','.slides\x20.image','querySelectorAll','1535EiUAAD','atual','21CiUJui','.balls','next','3437728CKmzmI','7956NrhMXv'];_0x168a=function(){return _0x3faa52;};return _0x168a();}var _0x3f86b9=_0xed52;function _0xed52(_0x56be4c,_0x37c0a2){var _0x168a15=_0x168a();return _0xed52=function(_0xed5236,_0x57236e){_0xed5236=_0xed5236-0x65;var _0x1aa10a=_0x168a15[_0xed5236];return _0x1aa10a;},_0xed52(_0x56be4c,_0x37c0a2);}(function(_0xcfe625,_0x250f13){var _0x450125=_0xed52,_0x3e5e7e=_0xcfe625();while(!![]){try{var _0x34ec51=-parseInt(_0x450125(0x6d))/0x1+-parseInt(_0x450125(0x73))/0x2*(parseInt(_0x450125(0x68))/0x3)+-parseInt(_0x450125(0x6c))/0x4*(parseInt(_0x450125(0x66))/0x5)+parseInt(_0x450125(0x74))/0x6+-parseInt(_0x450125(0x6b))/0x7*(-parseInt(_0x450125(0x71))/0x8)+parseInt(_0x450125(0x6f))/0x9*(-parseInt(_0x450125(0x6e))/0xa)+parseInt(_0x450125(0x70))/0xb;if(_0x34ec51===_0x250f13)break;else _0x3e5e7e['push'](_0x3e5e7e['shift']());}catch(_0x2ab9fd){_0x3e5e7e['push'](_0x3e5e7e['shift']());}}}(_0x168a,0x8950c));var balls=document['querySelector'](_0x3f86b9(0x69)),quant=document[_0x3f86b9(0x65)](_0x3f86b9(0x75)),atual=0x0,imagem=document[_0x3f86b9(0x72)](_0x3f86b9(0x67)),next=document[_0x3f86b9(0x72)](_0x3f86b9(0x6a)),voltar=document[_0x3f86b9(0x72)]('voltar'),rolar=!![];
 */

for (let i = 0; i < quant.length; i++) {
    var div = document.createElement("div")
    div.id = i
    balls.appendChild(div)
}

document.getElementById("0").classList.add("imgatual")
var pos = document.querySelectorAll(".balls div")


for (let i = 0; i < pos.length; i++) {
    pos[i].addEventListener("click", () => {
        atual = pos[i].id
        rolar = false
        slide()
    })
}

voltar.addEventListener("click", () => {
    atual--
    rolar = false
    slide()
})
next.addEventListener("click", () => {
    atual++
    rolar = false
    slide()
})

function slide() {
    if (atual >= quant.length) {
        atual = 0
    } else if (atual < 0) {
        atual = quant.length - 1
    }

    document.querySelector(".imgatual").classList.remove("imgatual")

    var largura = window.screen.width;
    if (largura < 800) {
        imagem.style.marginLeft = -100 * atual + "vw"
    } else {
        imagem.style.marginLeft = -75 * atual + "vw"
    }

    document.getElementById(atual).classList.add("imgatual")

}
slide()

setInterval(() => {
    if (rolar) {
        atual++

        slide()
    } else {
        rolar = true
    }
}, 7000)

$(".buton").click(function () {

    if ($(".buton").hasClass("add")) {

        //começa aqui
        setTimeout(function () {
            $(".nav").css("display", "none");
            $("#menu_p").css("display", "none");
        }, 1500);

        $(this).delay(100).animate({
            marginTop: "-1px"
        }, 850);

        setTimeout(function () {
            $(".buton").removeClass("add")
        }, 1100);

        $(".nav li:nth-child(7)").delay(142.7).animate({
            width: "0vw"
        }, 169);
        $(".nav li:nth-child(7) a").delay(142.7).animate({
            opacity: "0"
        }, 169);
        $(".nav li:nth-child(6)").delay(285.4).animate({
            width: "0vw"
        }, 169);
        $(".nav li:nth-child(6) a").delay(285.4).animate({
            opacity: "0"
        }, 169);
        $(".nav li:nth-child(5)").delay(428.1).animate({
            width: "0vw"
        }, 169);
        $(".nav li:nth-child(5) a").delay(428.1).animate({
            opacity: "0"
        }, 169);
        $(".nav li:nth-child(4)").delay(570.8).animate({
            width: "0vw"
        }, 169);
        $(".nav li:nth-child(4) a").delay(570.8).animate({
            opacity: "0"
        }, 169);
        $(".nav li:nth-child(3)").delay(713.5).animate({
            width: "0vw"
        }, 169);
        $(".nav li:nth-child(3) a").delay(713.5).animate({
            opacity: "0"
        }, 169);
        $(".nav li:nth-child(2)").delay(856.2).animate({
            width: "0vw"
        }, 169);
        $(".nav li:nth-child(2) a").delay(856.2).animate({
            opacity: "0"
        }, 169);
        $(".nav li:nth-child(1)").delay(998.9).animate({
            width: "0vw"
        }, 169);
        $(".nav li:nth-child(1) a").delay(998.9).animate({
            opacity: "0"
        }, 169);

    } else {

        $(".nav").css("display", "block");
        $("#menu_p").css("display", "block");

        $(".buton").addClass("add");

        $(this).delay(200).animate({
            marginTop: "244px"
        }, 650);
        $(".nav li:nth-child(1)").delay(142.7).animate({
            width: "80vw"
        }, 169);
        $(".nav li:nth-child(1) a").delay(142.7).animate({
            opacity: "1"
        }, 169);
        $(".nav li:nth-child(2)").delay(285.4).animate({
            width: "70vw"
        }, 169);
        $(".nav li:nth-child(2) a").delay(285.4).animate({
            opacity: "1"
        }, 169);
        $(".nav li:nth-child(3)").delay(428.1).animate({
            width: "60vw"
        }, 169);
        $(".nav li:nth-child(3) a").delay(428.1).animate({
            opacity: "1"
        }, 169);
        $(".nav li:nth-child(4)").delay(570.8).animate({
            width: "50vw"
        }, 169);
        $(".nav li:nth-child(4) a").delay(570.8).animate({
            opacity: "1"
        }, 169);
        $(".nav li:nth-child(5)").delay(713.5).animate({
            width: "40vw"
        }, 169);
        $(".nav li:nth-child(5) a").delay(713.5).animate({
            opacity: "1"
        }, 169);
        $(".nav li:nth-child(6)").delay(856.2).animate({
            width: "30vw"
        }, 169);
        $(".nav li:nth-child(6) a").delay(856.2).animate({
            opacity: "1"
        }, 169);
        $(".nav li:nth-child(7)").delay(998.9).animate({
            width: "20vw"
        }, 169);
        $(".nav li:nth-child(7) a").delay(998.9).animate({
            opacity: "1"
        }, 169);


    }

});

window.onscroll = function () {

    var largura = window.innerWidth;

    if (largura > 800) {

        const visor = window.pageYOffset;
        dado = document.querySelector("#menu_p");
        dado2 = document.querySelector("#sep");
        dado3 = document.querySelector(".cirone ~ span");

        var ele = 715;

        if (visor < ele) {
            dado.style.top = "730px";
            dado.style.position = "absolute";

            dado2.style.position = "absolute";
            dado2.style.top = "685px";
            dado2.style.width = "100vw";
            dado2.style.height = "70px";
            dado2.style.marginLeft = "0";

        } else {
            dado.style.position = "fixed";
            dado.style.top = "35px";

            dado2.style.position = "fixed";
            dado2.style.top = "0px";
            dado2.style.width = "100vw";
            dado2.style.height = "60px";
        }
    }
}

debounce = function (func, wait, immediate) {
    var timeout;
    return function () {
        var context = this,
            args = arguments;
        var later = function () {
            timeout - null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
};

(function () {

    var number = 0;
    var target = $('#fig > div, #fig > span');
    var offset = $(window).height();
    var animationc = "animestart";
    var graph = $(".graph").offset().top;

    function animeScroll() {
        var documentTop = $(document).scrollTop();

        if (documentTop > graph - offset) {
            $(".graph").addClass("graphh");

        } else {
            $(".graph").removeClass("graphh");

        }

        target.each(function () {
            var itenTop = $(this).offset().top;
            if (documentTop > itenTop - offset) {

                $(this).addClass(animationc);
                $(this).removeClass("rotanime");

            } else {
                number = 0;
                $(this).removeClass(animationc);
                $(this).addClass("rotanime");

            };
        });

        var itenTop = $(".kk").offset().top;
        if (documentTop > itenTop - offset) {

            $(".kk").addClass("nntrans");

        } else {
            $(".kk").removeClass("nntrans");
        }

        var wid = $("#sobre_nos").offset().top;
        if (documentTop > wid - offset) {
            $("#sobre_nos").addClass("gir");
            $(".pp").css("color", "black");
        } else {
            $("#sobre_nos").removeClass("gir");
            $(".pp").css("color", "white")
        }

        var an = $("#tex").offset().top;
        if (documentTop > an - offset) {
            $("#tex").css("transform", "rotateX(0deg)");
        } else {
            $("#tex").css("transform", "rotateX(90deg)");
        }

        var tem = $(".p_text").offset().top;
        if (documentTop > tem - offset) {
            $(".p_text").css("transform", "rotateY(0deg)");
            $(".img_text img").css("transform", "rotateX(0deg)");
        } else {
            $(".p_text").css("transform", "rotateY(90deg)");
            $(".img_text img").css("transform", "rotateX(90deg)");
        }

        var teximg = $("#tt").offset().top;
        if (documentTop > teximg - offset) {
            $("#tt").css("marginLeft", "0");
        } else {
            $("#tt").css("marginLeft", "-900px");
        }

    };

    animeScroll();

    $(document).scroll(debounce(function () {
        animeScroll();
    }, 200));
}());

$(".pontoo:nth-child(1)").mouseenter(function () {

    $(".ponto:nth-child(1)").addClass("ponto1");
    $(".ponto:nth-child(1) p").delay(500).animate({
        opacity: "1"
    });
    $(".pontos:nth-child(1)").css("background", "rgb(52, 208, 255)");

});

$(".pontoo:nth-child(1)").mouseleave(function () {

    $(".ponto:nth-child(1)").removeClass("ponto1");
    $(".ponto:nth-child(1) p").delay(500).animate({
        opacity: "0"
    });
    $(".pontos:nth-child(1)").css("background", "linear-gradient(45deg, rgb(29, 240, 255) 0%, rgb(0, 195, 255) 30%,rgb(0, 84, 149)  100%)");

});

$(".pontoo:nth-child(2)").mouseenter(function () {

    $(".ponto:nth-child(2)").addClass("ponto1");
    $(".ponto:nth-child(2) p").delay(500).animate({
        opacity: "1"
    });
    $(".pontos:nth-child(2)").css("background", "rgb(52, 208, 255)");


});

$(".pontoo:nth-child(2)").mouseleave(function () {

    $(".ponto:nth-child(2)").removeClass("ponto1");
    $(".ponto:nth-child(2) p").delay(500).animate({
        opacity: "0"
    });
    $(".pontos:nth-child(2)").css("background", "linear-gradient(45deg, rgb(29, 240, 255) 0%, rgb(0, 195, 255) 30%,rgb(0, 84, 149)  100%)");

});

$(".pontoo:nth-child(3)").mouseenter(function () {

    $(".ponto:nth-child(3)").addClass("ponto1");
    $(".ponto:nth-child(3) p").delay(500).animate({
        opacity: "1"
    });
    $(".pontos:nth-child(3)").css("background", "rgb(52, 208, 255)");


});

$(".pontoo:nth-child(3)").mouseleave(function () {

    $(".ponto:nth-child(3)").removeClass("ponto1");
    $(".ponto:nth-child(3) p").delay(500).animate({
        opacity: "0"
    });
    $(".pontos:nth-child(3)").css("background", "linear-gradient(45deg, rgb(29, 240, 255) 0%, rgb(0, 195, 255) 30%,rgb(0, 84, 149)  100%)");


});

$(".pontoo:nth-child(4)").mouseenter(function () {

    $(".ponto:nth-child(4)").addClass("ponto1");
    $(".ponto:nth-child(4) p").delay(500).animate({
        opacity: "1"
    });
    $(".pontos:nth-child(4)").css("background", "rgb(52, 208, 255)");


});

$(".pontoo:nth-child(4)").mouseleave(function () {

    $(".ponto:nth-child(4)").removeClass("ponto1");
    $(".ponto:nth-child(4) p").delay(500).animate({
        opacity: "0"
    });
    $(".pontos:nth-child(4)").css("background", "linear-gradient(45deg, rgb(29, 240, 255) 0%, rgb(0, 195, 255) 30%,rgb(0, 84, 149)  100%)");


});

$(".pontoo:nth-child(5)").mouseenter(function () {

    $(".ponto:nth-child(5)").addClass("ponto1");
    $(".ponto:nth-child(5) p").delay(500).animate({
        opacity: "1"
    });
    $(".pontos:nth-child(5)").css("background", "rgb(52, 208, 255)");


});

$(".pontoo:nth-child(5)").mouseleave(function () {

    $(".ponto:nth-child(5)").removeClass("ponto1");
    $(".ponto:nth-child(5) p").delay(500).animate({
        opacity: "0"
    });
    $(".pontos:nth-child(5)").css("background", "linear-gradient(45deg, rgb(29, 240, 255) 0%, rgb(0, 195, 255) 30%,rgb(0, 84, 149)  100%)");


});

$(".pontoo:nth-child(6)").mouseenter(function () {

    $(".ponto:nth-child(6)").addClass("ponto1");
    $(".ponto:nth-child(6) p").delay(500).animate({
        opacity: "1"
    });
    $(".pontos:nth-child(6)").css("background", "rgb(52, 208, 255)");


});

$(".pontoo:nth-child(6)").mouseleave(function () {

    $(".ponto:nth-child(6)").removeClass("ponto1");
    $(".ponto:nth-child(6) p").delay(500).animate({
        opacity: "0"
    });
    $(".pontos:nth-child(6)").css("background", "linear-gradient(45deg, rgb(29, 240, 255) 0%, rgb(0, 195, 255) 30%,rgb(0, 84, 149)  100%)");


});

$(".resposta").slideUp();

$(".duvida1").click(function () {

    if ($(".resposta").hasClass("att")) {
        $(".resposta").removeClass("att");
        $(".resposta").slideUp();
    }
    $(".duvida1 > .resposta").addClass("att");
    $(".duvida1 > .resposta").slideDown();


});

$(".duvida2").click(function () {

    if ($(".resposta").hasClass("att")) {
        $(".resposta").removeClass("att");
        $(".resposta").slideUp();
    }
    $(".duvida2 > .resposta").addClass("att");
    $(".duvida2 > .resposta").slideDown();


});

$(".duvida3").click(function () {

    if ($(".resposta").hasClass("att")) {
        $(".resposta").removeClass("att");
        $(".resposta").slideUp();
    }
    $(".duvida3 > .resposta").addClass("att");
    $(".duvida3 > .resposta").slideDown();


});

$(".duvida4").click(function () {

    if ($(".resposta").hasClass("att")) {
        $(".resposta").removeClass("att");
        $(".resposta").slideUp();
    }
    $(".duvida4 > .resposta").addClass("att");
    $(".duvida4 > .resposta").slideDown();

});

$(".duvida5").click(function () {

    if ($(".resposta").hasClass("att")) {
        $(".resposta").removeClass("att");
        $(".resposta").slideUp();
    }
    $(".duvida5 > .resposta").addClass("att");
    $(".duvida5 > .resposta").slideDown();

});

$(".conttt").mouseenter(function(){
    $(this).css("background", "#00c8ff")
    $(".conttt > a").animate({
        marginLeft: "100px"
    })
    $(".conttt > a").css("color", "white")
    $(".tris").animate({
        marginLeft: "250px"
    })
    $(".tris").css("backgroundColor", "white")
})

$(".conttt").mouseleave(function(){
    $(this).css("background", "white")
    $(".conttt > a").animate({
        marginLeft: "30px"
    })
    $(".conttt > a").css("color", "black")
    $(".tris").animate({
        marginLeft: "180px"
    })
    $(".tris").css("backgroundColor", "#00d9ff")
})


$(".func").each(function(){
    $(this).mouseenter(function(){
        
    $(this).addClass("mud")
    })
    $(this).mouseleave(function(){
        $(this).removeClass("mud")
    })
})

$(function () {
    const token = "";
    const url = "https://graph.instagram.com/me/media?access_token=" + token + "&fields=media_url,media_type,caption,permalink";

    $.get(url).then(function (response) {
        let images = response.data;
        let conteudo = "<div class='estilo_insta'>";

        for (let i = 0; i < 5; i++) {
            let feed = images[i];
            let titulo = feed.caption !== null ? feed.caption : "";
            let tipo = feed.media_type;
            if (tipo === "VIDEO") {

                conteudo += '<div class="vid_insta"><video poster="img/capavideo.png" controls><source src = "' + feed.media_url + '" type = "video/mp4" onclick="window.open(\'' + feed.permalink + '\');"></video></div>';

            } else if (tipo === "IMAGE" || "CAROUSEL_ALBUM") {
                conteudo += '<div class="img_insta"><img title = "' + titulo + '" alt = "' + titulo + '" src = "' + feed.media_url + '" onclick="window.open(\'' + feed.permalink + '\');"></div>';
            }

        }

        conteudo += "<a href='https://www.instagram.com/magnossites/'><div class='insta'><img src='img/instagram.png'></div></a></div>";
        $("#insta").html(conteudo);
       
    })

})

var nulo = "<span><p>Preencha este campo</p></span>";
$('input').keyup(function(){

    var text = $(this).val();
    
    if(text != ""){
        $(this).css("border", "2px solid blue");
    }else{
        $(this).css("border", "2px solid  rgb(0, 179, 255)");
    }
});


/*
if ($("#nome") != "") {
    $("#nome").css("backgroundColor", "red")
} else {

    $("#nome").css("backgroundColor", "green")
}*/