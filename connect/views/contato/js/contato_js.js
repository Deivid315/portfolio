$(document).ready(function() {
    let t = document.querySelectorAll(".obs");
    setTimeout(() => {
        $("#contato").css("filter", "blur(20px)"),
        setTimeout(() => {
            $("#contato").css("filter", "blur(0)")
        },
        1000)
    },
    3e3);
    $('.envio').click(function() {
        var email = $('#email').val();
        var nome = $('#nome').val();
        var telefone = $('#telefone').val();
        var informacoes = $('#informacoes').val();

        var dados = {
            email: email,
            nome: nome,
            telefone: telefone,
            informacoes: informacoes
        };

        $.ajax({
            type: 'POST',
            url: 'views/contato/ns/process.php',
            data: dados,
            dataType: 'json',
            success: function(response) {
                if(response.sucesso) {
                    alert('E-mail enviado com sucesso!');
                         $('#email').val('');
                        $('#nome').val('');
                        $('#telefone').val('');
                        $('#informacoes').val('');
                } else if(response.falha) {
                    alert('Falha ao enviar o e-mail. Por favor, tente novamente mais tarde.');
                } else if(response.email_invalido) {
                    alert('Por favor, insira um endereço de e-mail válido.');
                } else if(response.campos_vazios) {
                    alert('Por favor, preencha todos os campos do formulário.');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Ocorreu um erro ao processar a sua solicitação. Por favor, tente novamente mais tarde.');
            }
        });
    });
    let a = new IntersectionObserver(a => {
        a.forEach(a => {
            if (a.isIntersecting) {
                let e = Array.from(t).indexOf(a.target),
                i = $(a.target);
                switch (e) {
                case 0:
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                    case 6:
                    case 7:
                    case 8:
                    i.css("filter", "blur(0)")
                }
            } else {
                let s = Array.from(t).indexOf(a.target),
                n = $(a.target);
                switch (s) {
                case 0:
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                    case 6:
                    case 7:
                    case 8:
                    n.css("filter", "blur(20px)")
                }
            }
        })
    });
    t.forEach(t => {
        a.observe(t)
    });
    var e = $("#efectdiv span");
    $(".menu_tam > li").hover(function() {
        var t = $(this).index(".menu_tam > li");
        $(this).stop().animate({
            marginTop: "0.4vw"
        },
        100),
        e.each(function(a) {
            a === t ? $(this).css("visibility", "visible") : $(this).css("visibility", "hidden")
        })
    },
    function() {
        $(this).stop().animate({
            marginTop: "0"
        },
        100),
        e.css("visibility", "hidden")
    });
    var i = 0;
    $(".all, .menu_tam_m a").click(function() {
        0 == i ? ($("#container").css("position", "relative"), $("body").addClass("body_alter"), $("#container").css({
    "overflow": "hidden", /* Ou auto, dependendo do comportamento desejado */
    "-webkit-overflow-scrolling": "touch"
}), $("#container").animate({
            width: "10vw",
            height: "70vh",
            top: "15vh",
            left: "90vw"
        },
        1e3), $(".intro").animate({
            height: "70vh"
        },
        1e3), $(".all span:nth-child(2)").animate({
            opacity: "0"
        },
        1e3), $(".all span:nth-child(1)").animate({
            top: "15px"
        },
        1e3), $(".all span:nth-child(3)").animate({
            top: "10.5px"
        },
        1e3), $(".all span:nth-child(1)").css("transform", "rotate(30deg)"), $(".all span:nth-child(3)").css("transform", "rotate(-30deg)"), $("#up_m").animate({
            left: "0"
        },
        1e3), setTimeout(() => {
            $(".menu_tam_m li").css("width", "210px")
        },
        1e3), i++) : (setTimeout(() => {
            $("#container").css("position", "static"),
            $("body").removeClass("body_alter"),
            $("#container").css("height", "auto")
        },
        1e3), $("#container").css({
    "overflow": "initial", /* Ou auto, dependendo do comportamento desejado */
    "-webkit-overflow-scrolling": "touch"
}), $("#container").animate({
            left: "0",
            width: "100%",
            top: "0"
        },
        1e3), $(".intro").animate({
            height: "100vh"
        },
        1e3), $(".all span:nth-child(2)").animate({
            opacity: "1"
        },
        1e3), $(".all span:nth-child(1)").animate({
            top: "7.5px"
        },
        1e3), $(".all span:nth-child(3)").animate({
            top: "19px"
        },
        1e3), $(".all span:nth-child(1)").css("transform", "rotate(0deg)"), $(".all span:nth-child(3)").css("transform", "rotate(0deg)"), $("#up_m").animate({
            left: "-80vw"
        },
        1e3), $(".menu_tam_m li").css("width", "0"), i--)
    }),
    $(".info_to").click(function() {
        $(this).find(".info_toggle").toggleClass("info_toggle_ani")
    })
});