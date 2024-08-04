$(document).ready(function () {

    var spans = $("#efectdiv span");

    $(".menu_tam > li").hover(
        function () {
            var menuItemIndex = $(this).index(".menu_tam > li"); // Calcula o índice manualmente

            $(this).stop().animate({
                marginTop: "0.4vw"
            }, 100);

            spans.each(function (index) {
                if (index === menuItemIndex) {
                    $(this).css("visibility", "visible");
                } else {
                    $(this).css("visibility", "hidden");
                }            });
        },
        function () {
            $(this).stop().animate({
                marginTop: "0"
            }, 100);

            spans.css("visibility", "hidden");
        }
    );

    
    var b = 0;

    $(".all, .menu_tam_m a").click(function () {
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

            setTimeout(()=>{
                $(".menu_tam_m li").css("width", "210px")
            },1000)

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

    var elemento;
    $(".estado").click(function(){
        $("#mencao").css("display", "flex")
        $("body").css("overflow-y", "hidden")
        elemento = $(this).data("index");

        $.ajax({
            type: "POST",
            url: "../../controllers/control_mostre.php",
            data: { index: elemento },
            dataType: "json",
            success: function(response) {
                var titulo = response.retorno.pop();
                $(".titulo_escolas").append("<span>" + titulo + "</span>");
        
                if (response.retorno.length > 0 && response.id.length > 0) {
                    response.retorno.forEach(function(es, index) {
                        var id = response.id[index];
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
            url: "../../controllers/control_mostre.php",
            data: { det: outer,
                es: elemento
             },
            dataType: "json",
            success: function(response) {
                
                $(".titulo_escolas_d h1").append(response.nome);
                $(".respl").append(response.cidade);
                $(".respm").append(response.matricula);
                $(".3m").append(response.mv_3);
                $(".6m").append(response.mv_6);
                $(".12m").append(response.mv_12);
                $(".3c").append(response.mc_3);
                $(".6c").append(response.mc_6);
                $(".9c").append(response.mc_9);
                $(".12c").append(response.mc_12);
                
            },
            error: function(xhr, status, error) {
                console.error("Erro na requisição AJAX:" + error);
            }
        });
    });

    $(".feche2").click(function(){
        $("#detalhes").css("display", "none")
                
        $(".titulo_escolas_d h1").empty();
        $(".respl").empty();
        $(".respm").empty();
        $(".3m").empty();
        $(".6m").empty();
        $(".12m").empty();
        $(".3c").empty();
        $(".6c").empty();
        $(".9c").empty();
        $(".12c").empty();
    })
    
    $(".feche").click(function(){
        $("#mencao").hide();
        $("body").css("overflow-y", "scroll");
        $("#estado_lista").empty();
        $(".titulo_escolas").empty();
    });

})