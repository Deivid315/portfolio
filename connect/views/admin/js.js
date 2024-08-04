

document.addEventListener('DOMContentLoaded', function () {

    const url = window.location.href;
    const regex = /[?&]Sucesso=([^&#]*)/;
    const regexnot = /[?&]Erro=([^&#]*)/;
    const regexnull = /[?&]nulo=([^&#]*)/;
    const regexinco = /[?&]bda=([^&#]*)/;
    const regexnp = /[?&]incorrect=([^&#]*)/;

    const match = regex.exec(url);
    const matchnot = regexnot.exec(url);
    const matchnull = regexnull.exec(url);
    const matchinco = regexinco.exec(url);
    const matchnp = regexnp.exec(url);

    const sucesso = match && decodeURIComponent(match[1].replace(/\+/g, ' '));
    const falha = matchnot && decodeURIComponent(matchnot[1].replace(/\+/g, ' '));
    const nulo = matchnull && decodeURIComponent(matchnull[1].replace(/\+/g, ' '));
    const bd = matchinco && decodeURIComponent(matchinco[1].replace(/\+/g, ' '));
    const np = matchnp && decodeURIComponent(matchnp[1].replace(/\+/g, ' '));

    const urlParams = new URLSearchParams(window.location.search);
    if (sucesso) {
        alert("A chave Token foi alterada com sucesso no BANCO DE DADOS = true")
        urlParams.delete('Sucesso');
    } else if (falha) {
        alert("Ocorreu algum erro com o servidor e a alteração não foi salva")
        urlParams.delete('Erro');
    } else if (nulo) {
        alert("Chave token inválida!")
        urlParams.delete('nulo');
    } else if (bd) {
        alert("O(s) campo(s) foi(foram) alterado(s) com sucesso!")
        urlParams.delete('bda');
    } else if (np) {
        alert("Nenhuma informação foi passada pela url ou foi passada de maneira incorreta!")
        urlParams.delete('incorrect');
    }

    const urla = new URLSearchParams(window.location.search);
    if (urla.has('nsl')) {
        let alertMessage = "Nenhum dado foi salvo pois o(s) seguinte(s) campo(s) está(ão) vazio(s) ou excede(m) o limite de caracteres:\n";

        const params = Object.fromEntries(urla.entries());

        for (const key in params) {
            if (key !== 'nsl') {
                alertMessage += `${key}: ${params[key]}\n`;
            }
        }

        alert(alertMessage);
        urlParams.delete('nsl');
    }

    const newUrl = window.location.pathname + '?' + urlParams.toString();
    window.history.replaceState({}, document.title, newUrl);

    $("#es").click(function () {
        $("#instagram").css("opacity", "0");
        $("body").css("background-color", "white")
        $("nav").css("background-color", "#000080")
        $("h1").css("color", "black");
        $("ul li:not(:last-child) a").css("color", "white");
        setTimeout(() => {
            $("#instagram").css("display", "none")
            $("#escolas").css("display", "flex")
            setTimeout(() => {
                $("#escolas").css("opacity", "1")

            }, 100);
        }, 500);
    })

    $("#in").click(function () {
        $("#escolas").css("opacity", "0");
        $("body").css("background-color", "#000080")
        $("nav").css("background-color", "white")
        $("h1").css("color", "white");
        $("ul li:not(:last-child) a").css("color", "black");
        setTimeout(() => {
            $("#escolas").css("display", "none")
            $("#instagram").css("display", "flex")
            setTimeout(() => {
                $("#instagram").css("opacity", "1")

            }, 100);
        }, 500);
    })
    var ind;

    $(".al_es, #alter h1").css("color", "black");
    $(".al_es, #alter h1").css("font-size", "28px");
    $("#escolas form").css("display", "flex");
    $("#escolas form").css("flex-direction", "column");
    $("#escolas form").css("align-items", "center");

    $("#estate span").click(function () {
        $("#estate span").css("background-color", "white");
        $(this).css("background-color", "yellow");
        $("#s_cs span").empty();
        $("#selecao").css("display", "none")
        $("#school_city").empty();
        $("#s_cs").css("display", "flex")
        $("#school_city").css("display", "flex")
        esc = $(this).data("index");
        tt = $(this).text();
        $("#s_cs span").append(tt);
        
        $.ajax({
            type: "POST",
            url: "../../controllers/control_mostre.php",
            data: { esco: esc },
            dataType: "json",
            success: function (response) {

                var escolas_ = response.escolas;
                var ids = response.id;
                
                for (let i = 0; i < escolas_.length; i++) {
                    var escolas = escolas_[i];
                    var id_ = ids[i];
                    var kin = "<span data-index=" + id_ + " data-est=" + esc + ">" + escolas + "</span>";
                    $("#school_city").append(kin);
                    
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText + " + " + status  + " + " + error);
            }
        });
    });

    $(document).on("click", "#school_city span", function () {

        $("#school_city span").css("border", "none")
        $("#school_city span").css("background-color", "#000080")
        $(this).css("background-color", "black")
        $(this).css("border", "2px solid yellow")
        $("#selecao").css("display", "block")
        ind = $(this).data("index");
        es_ = $(this).data("est");
        $(".al").empty();

        $(".titulo_estado h1").empty();
        $(".titulo_escolas_d h1").empty();
        $(".respl").empty();
        $(".al_es").empty();
        $(".respm").empty();
        $(".3m").empty();
        $(".6m").empty();
        $(".9m").empty();
        $(".12m").empty();
        $(".3c").empty();
        $(".6c").empty();
        $(".9c").empty();
        $(".12c").empty();

        $.ajax({
            type: "POST",
            url: "../../controllers/control_mostre.php",
            data: { det: ind,
                es: es_
             },
            dataType: "json",
            success: function (response) {

                $(".al_es").append(response.nome);
                $(".titulo_estado h1").append(response.nome_estado);
                $(".titulo_escolas_d h1").append(response.nome);
                $(".respl").append(response.cidade);
                $(".respm").append(response.matricula);
                $(".3m").append(response.mv_3);
                $(".6m").append(response.mv_6);
                $(".9m").append(response.mv_9);
                $(".12m").append(response.mv_12);
                $(".3c").append(response.mc_3);
                $(".6c").append(response.mc_6);
                $(".9c").append(response.mc_9);
                $(".12c").append(response.mc_12);

            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText + " + " + status  + " + " + error);
            }
        });
    })

    $(document).ready(function () {
        $('input[type="checkbox"]').change(function () {
            $(".al").empty();
            // Verificar se pelo menos um checkbox está marcado
            var peloMenosUmSelecionado = $('input[type="checkbox"]:checked').length > 0;

            // Habilitar ou desabilitar o botão com base na condição
            $('#button').prop('disabled', !peloMenosUmSelecionado);
        });
        $('#button').click(function () {
            $("#alter").css("display", "inline-block")
            $(".al").empty();
            $("#ind").remove();
            var selectedIds = [];
            $('input[type="checkbox"]:checked').each(function () {
                selectedIds.push($(this).attr('id'));
                var atual = ($(this).attr("id"))
                var at;
                if (atual === "cidade") {
                    at = "Cidades:"
                } else if (atual === "matricula") {
                    at = 'Matrícula:<br><span class="cc" style ="color: red; width: 60%; min-width: 300px; font-size: 15px">*para poder adicionar dois tipos de matrícula insira o primeiro tipo e ao final dê um espaço e digite o camando: &lt;br&gt, dê mais um espaço e insira o segundo tipo de matrícula. Ao salvar, automaticamente isso permitirá a criação de mais um campo fazendo com que haja dois tipos de matrícula um embaixo do outro, ex: "visto estudante : $100 &lt;br&gt; troca de status : $200" caso não queira adicionar dois tipos basta ignorar o &lt;br&gt e não digitá-lo.</span>'
                } else if (atual === "mv_3") {
                    at = "Valores do 1º mês:"
                } else if (atual === "mv_6") {
                    at = "Valores do 2º mês:"
                } else if (atual === "mv_9") {
                    at = "Valores do 3º mês:"
                } else if (atual === "mv_12") {
                    at = "Valores do 12º mês:"
                } else if (atual === "mc_3") {
                    at = "Comprovação do 3º mês + dependente:"
                } else if (atual === "mc_6") {
                    at = "Comprovação do 6º mês + dependente:"
                } else if (atual === "mc_9") {
                    at = "Comprovação do 9º mês + dependente:"
                } else if (atual === "mc_12") {
                    at = "Comprovação do 12º mês + dependente:"
                }

                var ins = '<br><br><label for="' + atual + '">' + at + '</label><br><textarea name="' + atual + '" title="' + atual + '" class="text" cols="40" rows="3" autocomplete="off"></textarea>';
                $(".al").append(ins);
            });

            var acresc = $("<input>", {
                type: "text",
                name: "escola",
                id: "ind",
                value: ind
            })
            var acresc2 = $("<input>", {
                type: "text",
                name: "estado",
                id: "ind2",
                value: es_
            })

            $(".al").append(acresc);
            $(".al").append(acresc2);
            $("#ind").css("visibility", "hidden")
            $("#ind2").css("visibility", "hidden")

            var bb = $("<button>", {
                type: "submit",
                text: "alterar",
                id: "sub_bt",
                disabled: true
            })

            $(".al").append(bb)


            function verificarPreenchimento() {
                var todosPreenchidos = true;
                $('textarea.text').each(function () {
                    var nome = $(this).attr('name');
                    var comprimentoMaximo = (nome === 'cidade' || nome === 'matricula') ? 200 : 40;
                    if ($(this).val().trim().length < 3 || $(this).val().trim().length > comprimentoMaximo) {
                        todosPreenchidos = false;
                        return false;
                    }
                });
                $('#sub_bt').prop('disabled', !todosPreenchidos);
            }
            
            $('textarea.text').on('input', verificarPreenchimento);

        });

    });

})