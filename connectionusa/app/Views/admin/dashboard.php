<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="cache-control" content="max-age=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT">
    <meta http-equiv="pragma" content="no-cache">
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="../dashboard/style.css">


</head>

<body>

    <?php echo isset($alert) && is_string($alert) ? '<script>alert("' . esc($alert) . '")</script>' : null; ?>

    <nav>
        <ul>
            <li id="in"><a href="#">Instagram</a></li>
            <li id="es"><a href="#">Escolas</a></li>
            <li id="es"><a href="/logout" style="color: red;">Sair</a></li>
        </ul>
    </nav>

    <h1>Bem vindo admin</h1>

    <div id="instagram">
        <h2>Instagram</h2>
        <p class="pp">Para que na página principal o Instagram continue a funcionar é necessário
            um token de acesso, todavia esse token dura apenas 60 dias, portanto cabe ao
            admin acessar essa página a cada período para atualizar o token, do contrário
            o instagram desaparecerá da página principal.
        </p>

        <?= validation_list_errors() ?>

        <?= form_open() ?>

        <?php if (isset($msg) && isset($cor)): ?>
            <div class='msg' style='background-color: <?= esc($cor) ?>; color: white;'>
                <?= esc($msg) ?>
            </div>
        <?php endif; ?>
        <?= csrf_field() ?>

        <label for="texttoken">Chave Token</label>
        <textarea required name="token" id="texttoken" cols="60" rows="5" autocomplete="off"><?= set_value('token') ?></textarea>
        <input type="submit" value="Enviar">

        <?= form_close() ?>

        <div id="atual">
            <h2>A chave token atual é:</h2>
            <p>
                <?= esc($token) ?>
            </p>
        </div>
    </div>

    <div id="escolas">

        <h2>Estados</h2>
        <p>Escolha o estado que deseja editar:</p>
        <div id="estate">
            <span data-index="ca">Califórnia</span>
            <span data-index="cn">Connecticut</span>
            <span data-index="co">Colorado</span>
            <span data-index="dc">D.C.</span>
            <span data-index="fl">Flórida</span>
            <span data-index="ge">Geórgia</span>
            <span data-index="hi">Havaí</span>
            <span data-index="il">Illinóis</span>
            <span data-index="ind">Indiana</span>
            <span data-index="md">Maryland</span>
            <span data-index="ms">Massassuchets</span>
            <span data-index="nj">New Jersey</span>
            <span data-index="ny">Nova York</span>
            <span data-index="sc">South Califórnia</span>
            <span data-index="tx">Texas</span>
            <span data-index="ut">Utah</span>
            <span data-index="va">Virgínia</span>
            <span data-index="wa">Washington</span>
        </div>
        <div id="s_cs">
            <h2>Estado selecionado: <span></span></h2>
            <p>Escolha a escola que deseja editar:</p>
            <div id="school_city">
            </div>

        </div>

        <div id="selecao">

            <div class="titulo_estado">
                <h1></h1>
            </div>

            <div class="titulo_escolas_d">
                <h1></h1>
            </div>
            <div class="primeiro">
                <span class="pergun l_pri loc">Cidades:</span>
                <span class="resp prime respl"></span>
            </div>
            <div class="primeiro">
                <span class="pergun mat">Matrícula:</span>
                <span class="resp respm"></span>
            </div>
            <div class="primeiro">
                <span class="pergun val">Valores:</span>
                <div class="varl">
                    <span class="3m"></span><br>
                    <span class="6m"></span><br>
                    <span class="9m"></span><br>
                    <span class="12m"></span><br>
                </div>
            </div>
            <div class="primeiro com">
                <span class="pergun">Comprovação Financeira:</span>
                <div class="comp ult">
                    <span class="3c"></span><br>
                    <span class="6c"></span><br>
                    <span class="9c"></span><br>
                    <span class="12c"></span><br>
                </div>

            </div>
            <fieldset>
                <legend>Selecione o que você quer editar:</legend>

                <div>
                    <input type="checkbox" id="cidade" name="cidade">
                    <label for="cidade">Cidades</label>
                </div>

                <div>
                    <input type="checkbox" id="matricula" name="matricula">
                    <label for="matricula">Matrícula</label>
                </div>
                <div>
                    <input type="checkbox" id="mv_3" name="mv_3">
                    <label for="mv_3">Valores do 1º mês</label>
                </div>
                <div>
                    <input type="checkbox" id="mv_6" name="mv_6">
                    <label for="mv_6">Valores do 2º mês</label>
                </div>
                <div>
                    <input type="checkbox" id="mv_9" name="mv_9">
                    <label for="mv_9">Valores do 3º mês</label>
                </div>
                <div>
                    <input type="checkbox" id="mv_12" name="mv_12">
                    <label for="mv_12">Valores do 4º mês</label>
                </div>
                <div>
                    <input type="checkbox" id="mc_3" name="mc_3">
                    <label for="mc_3">Comprovação do 3º mês + dependente</label>
                </div>
                <div>
                    <input type="checkbox" id="mc_6" name="mc_6">
                    <label for="mc_6">Comprovação do 6º mês + dependente</label>
                </div>
                <div>
                    <input type="checkbox" id="mc_9" name="mc_9">
                    <label for="mc_9">Comprovação do 9º mês + dependente</label>
                </div>
                <div>
                    <input type="checkbox" id="mc_12" name="mc_12">
                    <label for="mc_12">Comprovação do 12º mês + dependente</label>
                </div>

                <input type="button" value="Enviar" id="button" disabled>
            </fieldset>

            <div id="alter">
                <h1>Altere as infomações selecionadas: <span class="al_es"></span></h1>

                <?= form_open('http://localhost:8080/detalhes/atualize', 'class="al" id="form_altere"') ?>

                <?= form_close() ?>

            </div>

        </div>

    </div>

    <script src='../dashboard/jquery-3.7.1.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // const url = window.location.href;
            // const regex = /[?&]Sucesso=([^&#]*)/;
            // const regexnot = /[?&]Erro=([^&#]*)/;
            // const regexnull = /[?&]nulo=([^&#]*)/;
            // const regexinco = /[?&]bda=([^&#]*)/;
            // const regexnp = /[?&]incorrect=([^&#]*)/;

            // const match = regex.exec(url);
            // const matchnot = regexnot.exec(url);
            // const matchnull = regexnull.exec(url);
            // const matchinco = regexinco.exec(url);
            // const matchnp = regexnp.exec(url);

            // const sucesso = match && decodeURIComponent(match[1].replace(/\+/g, ' '));
            // const falha = matchnot && decodeURIComponent(matchnot[1].replace(/\+/g, ' '));
            // const nulo = matchnull && decodeURIComponent(matchnull[1].replace(/\+/g, ' '));
            // const bd = matchinco && decodeURIComponent(matchinco[1].replace(/\+/g, ' '));
            // const np = matchnp && decodeURIComponent(matchnp[1].replace(/\+/g, ' '));

            // const urlParams = new URLSearchParams(window.location.search);
            // if (sucesso) {
            //     alert("A chave Token foi alterada com sucesso no BANCO DE DADOS = true")
            //     urlParams.delete('Sucesso');
            // } else if (falha) {
            //     alert("Ocorreu algum erro com o servidor e a alteração não foi salva")
            //     urlParams.delete('Erro');
            // } else if (nulo) {
            //     alert("Chave token inválida!")
            //     urlParams.delete('nulo');
            // } else if (bd) {
            //     alert("O(s) campo(s) foi(foram) alterado(s) com sucesso!")
            //     urlParams.delete('bda');
            // } else if (np) {
            //     alert("Nenhuma informação foi passada pela url ou foi passada de maneira incorreta!")
            //     urlParams.delete('incorrect');
            // }

            // const urla = new URLSearchParams(window.location.search);
            // if (urla.has('nsl')) {
            //     let alertMessage = "Nenhum dado foi salvo pois o(s) seguinte(s) campo(s) está(ão) vazio(s) ou excede(m) o limite de caracteres:\n";

            //     const params = Object.fromEntries(urla.entries());

            //     for (const key in params) {
            //         if (key !== 'nsl') {
            //             alertMessage += `${key}: ${params[key]}\n`;
            //         }
            //     }

            //     alert(alertMessage);
            //     urlParams.delete('nsl');
            // }

            // const newUrl = window.location.pathname + '?' + urlParams.toString();
            // window.history.replaceState({}, document.title, newUrl);

            $("#es").click(function() {
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

            $("#in").click(function() {
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

            const csrfTokenName = '<?= csrf_token() ?>';
            let csrfTokenValue = '<?= csrf_hash() ?>';

            $("#estate span").click(function() {
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
                    url: "http://localhost:8080/detalhes/esc",
                    data: JSON.stringify({
                        esco: esc,
                        [csrfTokenName]: csrfTokenValue
                    }),
                    dataType: "json",
                    success: function(response) {
                        if (response.newCsrfToken) {
                            csrfTokenValue = response.newCsrfToken;
                        }

                        var escolas_ = response.data.escolas;
                        var ids = response.data.id;

                        for (let i = 0; i < escolas_.length; i++) {
                            var escolas = escolas_[i];
                            var id_ = ids[i];
                            var kin = "<span data-index=" + id_ + " data-est=" + esc + ">" + escolas + "</span>";
                            $("#school_city").append(kin);

                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr + " + " + status + " + " + error);
                    }
                });
            });

            $(document).on("click", "#school_city span", function() {

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
                    url: "http://localhost:8080/detalhes/esc",
                    data: JSON.stringify({
                        det: ind,
                        es: es_,
                        [csrfTokenName]: csrfTokenValue
                    }),
                    dataType: "json",
                    success: function(response) {
                        if (response.newCsrfToken) {
                            csrfTokenValue = response.newCsrfToken;
                        }

                        $(".al_es").append(response.data.nome);
                        $(".titulo_estado h1").append(response.data.nome_estado);
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
                        console.error(xhr.responseText + " + " + status + " + " + error);
                    }
                });
            })

            $(document).ready(function() {
                $('input[type="checkbox"]').change(function() {
                    $(".al").empty();

                    var peloMenosUmSelecionado = $('input[type="checkbox"]:checked').length > 0;

                    $('#button').prop('disabled', !peloMenosUmSelecionado);
                });
                $('#button').click(function() {
                    $("#alter").css("display", "inline-block")
                    $(".al").empty();
                    $("#ind").remove();
                    var selectedIds = [];
                    $('input[type="checkbox"]:checked').each(function() {
                        selectedIds.push($(this).attr('id'));
                        var atual = ($(this).attr("id"))
                        var at;
                        if (atual === "cidade") {
                            at = "Cidades:"
                            put = 'respl';
                        } else if (atual === "matricula") {
                            at = 'Matrícula:<br><span class="cc" style ="color: red; width: 60%; min-width: 300px; font-size: 15px">*para poder adicionar dois tipos de matrícula insira o primeiro tipo e ao final dê um espaço e digite o camando: &lt;br&gt, dê mais um espaço e insira o segundo tipo de matrícula. Ao salvar, automaticamente isso permitirá a criação de mais um campo fazendo com que haja dois tipos de matrícula um embaixo do outro, ex: "visto estudante : $100 &lt;br&gt; troca de status : $200" caso não queira adicionar dois tipos basta ignorar o &lt;br&gt e não digitá-lo.</span>'
                            put = 'respm';
                        } else if (atual === "mv_3") {
                            at = "Valores do 1º mês:"
                            put = '3m';
                        } else if (atual === "mv_6") {
                            at = "Valores do 2º mês:"
                            put = '6m';
                        } else if (atual === "mv_9") {
                            at = "Valores do 3º mês:"
                            put = '9m';
                        } else if (atual === "mv_12") {
                            at = "Valores do 4º mês:"
                            put = '12m';
                        } else if (atual === "mc_3") {
                            at = "Comprovação do 1º mês + dependente:"
                            put = '3c';
                        } else if (atual === "mc_6") {
                            at = "Comprovação do 2º mês + dependente:"
                            put = '6c';
                        } else if (atual === "mc_9") {
                            at = "Comprovação do 3º mês + dependente:"
                            put = '9c';
                        } else if (atual === "mc_12") {
                            at = "Comprovação do 4º mês + dependente:"
                            put = '12c';
                        }

                        var ins = '<br><br><label for="' + atual + '">' + at + '</label><br><textarea name="' + atual + '" title="' + atual + '" class="text" cols="40" rows="3" autocomplete="off">' + $('.' + put).text() + '</textarea>';
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
                        $('textarea.text').each(function() {
                            var nome = $(this).attr('name');

                            if (['mc_3', 'mc_6', 'mc_9', 'mc_12', 'mv_6', 'mv_9', 'mv_12'].includes(nome)) {

                                return true;
                            }

                            if ($(this).val().trim().length < 5 || $(this).val().trim().length > 200) {
                                todosPreenchidos = false;
                                return false; 
                            }
                        });
                        $('#sub_bt').prop('disabled', !todosPreenchidos);
                    }
                    verificarPreenchimento();
                    $('textarea.text').on('input', verificarPreenchimento);

                });

            });

            const form = document.getElementById('form_altere');

            form.addEventListener('submit', (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const data = {};

                formData.forEach((value, key) => {
                    data[key] = value;
                });

                fetch(form.action, {
                        method: 'POST',
                        body: JSON.stringify({
                            data: data,
                            [csrfTokenName]: csrfTokenValue
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Erro na resposta. Status: ${response.status}`);
                        }

                        const contentType = response.headers.get("content-type");
                        if (contentType && contentType.includes("application/json")) {
                            return response.json();
                        } else {
                            throw new Error("Resposta não está no formato JSON");
                        }

                    })
                    .then(data => {

                        if (data.newCsrfToken) {
                            csrfTokenValue = data.newCsrfToken;
                        }

                        if (data.errorMessages) {
                            alert(data.errorMessages);
                            return;
                        } else if (data.mensagem) {
                            alert(data.mensagem);

                            let index = data.estado;

                            $("#estate span").each(function() {
                if ($(this).data('index') === index) {
                    $(this).trigger('click');
                }
            });

                        }

                    })
                    .catch(error => {
                        console.error('erro no processamento: ', error);
                        alert('erro no envio');
                    });
            })

        })
    </script>
</body>

</html>