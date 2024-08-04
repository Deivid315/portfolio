document.addEventListener("DOMContentLoaded", function () {
    var spans = document.querySelectorAll("#efectdiv span");
    var menuItems = document.querySelectorAll(".menu_tam > li");
    menuItems.forEach(function (menuItem) {
        menuItem.addEventListener("mouseenter", function () {
            var menuItemIndex = Array.from(menuItems).indexOf(menuItem);
            menuItem.style.marginTop = "0.4vw";
            spans.forEach(function (span, index) {
                if (index === menuItemIndex) {
                    span.style.visibility = "visible";
                } else {
                    span.style.visibility = "hidden";
                }
            });
        });
        menuItem.addEventListener("mouseleave", function () {
            menuItem.style.marginTop = "0";
            spans.forEach(function (span) {
                span.style.visibility = "hidden";
            });
        });
    });
    var windowWidth = window.innerWidth || document.documentElement.clientWidth;
    var st = !0;
    var intervalo1;
    var intervalo2;
    var intervalo3;
    function contagem1(vv) {
        var aqui = document.getElementById("" + vv + "");
        var valor = 0;
        clearInterval(intervalo1);
        intervalo1 = setInterval(function () {
            if (valor <= 99) {
                aqui.innerHTML = valor + "%";
                valor++;
            } else {
                clearInterval(intervalo1);
            }
        }, 50);
    }
    function contagem2(vv) {
        var aqui = document.getElementById("" + vv + "");
        var valor = 0;
        clearInterval(intervalo2);
        intervalo2 = setInterval(function () {
            if (valor <= 100) {
                aqui.innerHTML = valor + "%";
                valor++;
            } else {
                clearInterval(intervalo2);
            }
        }, 50);
    }
    function contagem3(vv) {
        var aqui = document.getElementById("" + vv + "");
        var valor = 0;
        clearInterval(intervalo3);
        intervalo3 = setInterval(function () {
            if (valor <= 100) {
                aqui.innerHTML = valor + "%";
                valor++;
            } else {
                clearInterval(intervalo3);
            }
        }, 50);
    }
    function pararContagem1() {
        clearInterval(intervalo1);
    }
    function pararContagem2() {
        clearInterval(intervalo2);
    }
    function pararContagem3() {
        clearInterval(intervalo3);
    }
    function ch(p, t, n) {
        var percentual = setInterval(function () {
            p++;
            if (st) {
                clearInterval(percentual);
            }
            if (p <= n) {
                t.html(p + "%");
            } else {
                clearInterval(percentual);
            }
        }, 50);
    }
    if (window.innerWidth > 1025) {
        document.querySelectorAll(".setas_m").forEach(function (element) {
            element.style.display = "none";
        });
        const all = document.querySelectorAll(".obs");
        const ob = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    const index = Array.from(all).indexOf(entry.target);
                    const targetElement = entry.target;
                    switch (index) {
                        case 0:
                            targetElement.style.right = "13vw";
                            break;
                        case 1:
                            targetElement.style.marginLeft = "14vw";
                            break;
                        case 2:
                            targetElement.style.marginLeft = "13vw";
                            break;
                        case 3:
                            targetElement.style.marginTop = "-5vw";
                            targetElement.style.opacity = "1";
                            break;
                        case 4:
                            targetElement.style.marginTop = "36vw";
                            targetElement.style.opacity = "1";
                            break;
                        case 5:
                            targetElement.style.strokeDashoffset = "1vw";
                            targetElement.classList.add("stroke_an");
                            break;
                        case 6:
                            targetElement.style.strokeDashoffset = "0";
                            targetElement.classList.add("stroke_an");
                            break;
                        case 7:
                            targetElement.style.strokeDashoffset = "0";
                            targetElement.classList.add("stroke_an");
                            break;
                        case 14:
                            contagem1("progress_1");
                            break;
                        case 15:
                            contagem2("progress_2");
                            break;
                        case 16:
                            contagem3("progress_3");
                            break;
                        case 17:
                            targetElement.style.width = "95vw";
                            break;
                        case 18:
                            targetElement.style.marginLeft = "15vw";
                            break;
                        case 19:
                            targetElement.style.right = "0";
                            targetElement.classList.add("pt_ani");
                            break;
                        case 20:
                            targetElement.style.width = "34vw";
                            targetElement.classList.add("sx_ani");
                            break;
                        case 21:
                            targetElement.style.width = "30vw";
                            targetElement.classList.add("sx_ani");
                            break;
                        case 22:
                            targetElement.style.width = "26vw";
                            targetElement.classList.add("sx_ani");
                            break;
                        case 23:
                            targetElement.style.width = "22vw";
                            targetElement.classList.add("sx_ani");
                            break;
                        default:
                    }
                } else {
                    const index = Array.from(all).indexOf(entry.target);
                    const targetElement = entry.target;
                    switch (index) {
                        case 0:
                            targetElement.style.right = "-30vw";
                            break;
                        case 1:
                            targetElement.style.marginLeft = "-30vw";
                            break;
                        case 2:
                            targetElement.style.marginLeft = "-70vw";
                            break;
                        case 3:
                            targetElement.style.marginTop = "0";
                            targetElement.style.opacity = "0";
                            break;
                        case 4:
                            targetElement.style.marginTop = "40vw";
                            targetElement.style.opacity = "0";
                            break;
                        case 5:
                        case 6:
                        case 7:
                            targetElement.style.strokeDashoffset = "23vw";
                            targetElement.classList.remove("stroke_an");
                            break;
                        case 14:
                            pararContagem1();
                            document.getElementById("progress_1").innerHTML = "0%";
                            break;
                        case 15:
                            pararContagem2();
                            document.getElementById("progress_2").innerHTML = "0%";
                            break;
                        case 16:
                            pararContagem3();
                            document.getElementById("progress_3").innerHTML = "0%";
                            break;
                        case 17:
                            targetElement.style.width = "0";
                            break;
                        case 18:
                            targetElement.style.marginLeft = "-19vw";
                            break;
                        case 19:
                            targetElement.style.right = "-55vw";
                            targetElement.classList.remove("pt_ani");
                            break;
                        case 20:
                        case 21:
                        case 22:
                        case 23:
                            targetElement.style.width = "1vw";
                            targetElement.classList.remove("sx_ani");
                            break;
                        default:
                    }
                }
            });
        });
        all.forEach((element) => {
            ob.observe(element);
        });
        var fraseElement = document.querySelector(".divfi2 p");
        var fraseTexto = fraseElement.innerHTML;
        fraseElement.innerHTML = fraseTexto.replace("Seu sucesso é", "Seu sucesso é");
    } else {
        var fraseElement = document.querySelector(".divfi2 p");
        var fraseTexto = fraseElement.innerHTML;
        fraseElement.innerHTML = fraseTexto.replace("Seu sucesso é", "Seu sucesso é<br>");
        const all = document.querySelectorAll(".obs");
        const ob = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                const index = Array.from(all).indexOf(entry.target);
                const targetElement = entry.target;
                if (entry.isIntersecting) {
                    switch (index) {
                        case 1:
                            targetElement.style.marginLeft = "0";
                            break;
                        case 2:
                            targetElement.style.marginLeft = "5%";
                            break;
                        case 3:
                            targetElement.style.marginTop = "-22px";
                            targetElement.style.opacity = "1";
                            break;
                        case 4:
                            targetElement.style.marginLeft = "0";
                            targetElement.style.filter = "blur(0px)";
                            break;
                        case 8:
                            targetElement.style.strokeDashoffset = "30";
                            targetElement.classList.add("cn_m");
                            break;
                        case 9:
                            contagem1("progress_1_m");
                            break;
                        case 10:
                        case 12:
                            targetElement.style.strokeDashoffset = "0";
                            targetElement.classList.add("cn_m");
                            break;
                        case 11:
                            contagem2("progress_2_m");
                            break;
                        case 13:
                            contagem3("progress_3_m");
                            break;
                        case 19:
                            targetElement.style.marginLeft = "0";
                            targetElement.classList.add("pt_ani_m");
                            break;
                        case 20:
                        case 21:
                        case 22:
                        case 23:
                            targetElement.style.marginLeft = "0";
                            targetElement.classList.add("sx_ani_m");
                            break;
                        default:
                    }
                } else {
                    switch (index) {
                        case 1:
                            targetElement.style.marginLeft = "-180vw";
                            break;
                        case 2:
                            targetElement.style.marginLeft = "90%";
                            break;
                        case 3:
                            targetElement.style.marginTop = "20px";
                            targetElement.style.opacity = "0";
                            break;
                        case 4:
                            targetElement.style.marginLeft = "190vw";
                            targetElement.style.filter = "blur(10px)";
                            break;
                        case 8:
                        case 10:
                        case 12:
                            targetElement.style.strokeDashoffset = "330";
                            targetElement.classList.remove("cn_m");
                            break;
                        case 9:
                            pararContagem1();
                            document.getElementById("progress_1_m").innerHTML = "0%";
                            break;
                        case 11:
                            pararContagem2();
                            document.getElementById("progress_2_m").innerHTML = "0%";
                            break;
                        case 13:
                            pararContagem3();
                            document.getElementById("progress_3_m").innerHTML = "0%";
                            break;
                        case 19:
                            targetElement.style.marginLeft = "150vw";
                            targetElement.classList.remove("pt_ani_m");
                            break;
                        case 20:
                            targetElement.style.marginLeft = "-130vw";
                            targetElement.classList.remove("sx_ani_m");
                            break;
                        case 21:
                            targetElement.style.marginLeft = "-120vw";
                            targetElement.classList.remove("sx_ani_m");
                            break;
                        case 22:
                            targetElement.style.marginLeft = "-110vw";
                            targetElement.classList.remove("sx_ani_m");
                            break;
                        case 23:
                            targetElement.style.marginLeft = "-100vw";
                            targetElement.classList.remove("sx_ani_m");
                            break;
                        default:
                    }
                }
            });
        });
        all.forEach((element) => {
            ob.observe(element);
        });
    }
    function opaci() {
        var index = 1;
        setTimeout(function () {
            document.querySelector('.slidee[data-index="' + 1 + '"]').style.opacity = "1";
            setInterval(function () {
                document.querySelector('.slidee[data-index="' + index + '"]').style.opacity = "0";
                index++;
                if (index > 5) {
                    index = 1;
                }
                setTimeout(function () {
                    document.querySelector('.slidee[data-index="' + index + '"]').style.opacity = "1";
                }, 1200);
            }, 5500);
        }, 4000);
    }
    opaci();
    var currentIndex = 0;
    var step = 100;
    function updateSlidePosition(index) {
        var marginLeft = index * -step + "vw";
        document.querySelector(".primeiro").style.marginLeft = marginLeft;
        var radios = document.querySelectorAll(".radio");
        radios.forEach(function (radio) {
            radio.style.backgroundColor = "initial";
        });
        radios[index].style.backgroundColor = "blue";
    }
    updateSlidePosition(currentIndex);
    var radioButtons = document.querySelectorAll(".radio");
    radioButtons.forEach(function (radio) {
        radio.addEventListener("click", function () {
            var index = parseInt(radio.getAttribute("data-index")) - 1;
            currentIndex = index;
            updateSlidePosition(currentIndex);
        });
    });
    document.querySelector(".esquerda").addEventListener("click", function () {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = 2;
        }
        updateSlidePosition(currentIndex);
    });
    document.querySelector(".direita").addEventListener("click", function () {
        if (currentIndex < 2) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateSlidePosition(currentIndex);
    });
    var isAnimating = !1;
    document.querySelector(".buttons").addEventListener("mouseenter", function () {
        document.querySelector(".blob-btn__inner").style.boxShadow = "0.31vw 0.31vw white";
    });
    document.querySelector(".buttons").addEventListener("mouseleave", function () {
        document.querySelector(".blob-btn__inner").style.boxShadow = "0.31vw 0.31vw #000080";
    });
    var servcs = document.querySelectorAll(".servc");
    servcs.forEach(function (servc) {
        servc.addEventListener("mouseenter", function () {
            this.querySelector(".imgservico").style.filter = "brightness(0.4)";
            this.querySelector("figcaption p").style.display = "block";
        });
        servc.addEventListener("mouseleave", function () {
            this.querySelector(".imgservico").style.filter = "none";
            this.querySelector("figcaption p").style.display = "none";
        });
    });
    var buttons = document.querySelectorAll(".infoheader button");
    var link = document.querySelector(".infoheader a:nth-child(1)");
    buttons.forEach(function (button) {
        button.addEventListener("mouseenter", function () {
            link.style.color = "black";
        });
    });
    buttons.forEach(function (button) {
        button.addEventListener("mouseleave", function () {
            link.style.color = "white";
        });
    });
    var n1 = 0,
        n2 = 0,
        n3 = 0,
        n4 = 0,
        n5 = 0,
        n6 = 0;
    var s1 = document.querySelector(".servinfo1");
    var s2 = document.querySelector(".servinfo2");
    var s3 = document.querySelector(".servinfo3");
    var s4 = document.querySelector(".servinfo4");
    var s5 = document.querySelector(".servinfo5");
    var s6 = document.querySelector(".servinfo6");
    document.addEventListener("click", function (event) {
        if (!event.target.closest(".servc")) {
            s1.classList.remove("expan111");
            s2.classList.remove("expan111");
            s3.classList.remove("expan111");
            s4.classList.remove("expan222");
            s5.classList.remove("expan222");
            s6.classList.remove("expan222");
        }
    });
    var servcs = document.querySelectorAll(".servc");
    servcs.forEach(function (servc) {
        servc.addEventListener("click", function () {
            var atual = this.getAttribute("data-target");
            switch (atual) {
                case "servinfo1":
                    n1++;
                    n2 = 0;
                    n3 = 0;
                    if (n1 === 2) {
                        s1.classList.remove("expan111");
                        n1 = 0;
                    } else {
                        s1.classList.add("expan111");
                        if (s2.classList.contains("expan111") || s3.classList.contains("expan111")) {
                            s2.classList.remove("expan111");
                            s3.classList.remove("expan111");
                        }
                    }
                    break;
                case "servinfo2":
                    n2++;
                    n1 = 0;
                    n3 = 0;
                    if (n2 === 2) {
                        s2.classList.remove("expan111");
                        n2 = 0;
                    } else {
                        s2.classList.add("expan111");
                        if (s1.classList.contains("expan111") || s3.classList.contains("expan111")) {
                            s1.classList.remove("expan111");
                            s3.classList.remove("expan111");
                        }
                    }
                    break;
                case "servinfo3":
                    n3++;
                    n1 = 0;
                    n2 = 0;
                    if (n3 === 2) {
                        s3.classList.remove("expan111");
                        n3 = 0;
                    } else {
                        s3.classList.add("expan111");
                        if (s1.classList.contains("expan111") || s2.classList.contains("expan111")) {
                            s1.classList.remove("expan111");
                            s2.classList.remove("expan111");
                        }
                    }
                    break;
                case "servinfo4":
                    n4++;
                    n5 = 0;
                    n6 = 0;
                    if (n4 === 2) {
                        s4.classList.remove("expan222");
                        n4 = 0;
                    } else {
                        s4.classList.add("expan222");
                        if (s5.classList.contains("expan222") || s6.classList.contains("expan222")) {
                            s5.classList.remove("expan222");
                            s6.classList.remove("expan222");
                        }
                    }
                    break;
                case "servinfo5":
                    n5++;
                    n4 = 0;
                    n6 = 0;
                    if (n5 === 2) {
                        s5.classList.remove("expan222");
                        n5 = 0;
                    } else {
                        s5.classList.add("expan222");
                        if (s4.classList.contains("expan222") || s6.classList.contains("expan222")) {
                            s4.classList.remove("expan222");
                            s6.classList.remove("expan222");
                        }
                    }
                    break;
                case "servinfo6":
                    n6++;
                    n4 = 0;
                    n5 = 0;
                    if (n6 === 2) {
                        s6.classList.remove("expan222");
                        n6 = 0;
                    } else {
                        s6.classList.add("expan222");
                        if (s4.classList.contains("expan222") || s5.classList.contains("expan222")) {
                            s4.classList.remove("expan222");
                            s5.classList.remove("expan222");
                        }
                    }
                    break;
                default:
                    break;
            }
        });
    });
    var a = 0;
    document.querySelectorAll("#link_servicos_m, #link_planejamento_m, #link_sobre_m").forEach(function (element) {
        element.addEventListener("click", function (event) {
            event.preventDefault();
            setTimeout(function () {
                var target = document.querySelector(element.hash);
                if (target) {
                    var targetPosition = target.getBoundingClientRect().top + window.scrollY - 130;
                    window.scrollTo({ top: targetPosition, behavior: "smooth" });
                }
            }, 1200);
        });
    });
    document.querySelectorAll("#link_servicos, #link_planejamento, #link_sobre").forEach(function (element) {
        element.addEventListener("click", function (event) {
            event.preventDefault();
            var target = document.querySelector(element.hash);
            if (target) {
                var targetPosition = target.getBoundingClientRect().top + window.scrollY - 130;
                window.scrollTo({ top: targetPosition, behavior: "smooth" });
            }
        });
    });
    var b = 0;
    document.querySelectorAll(".all, .menu_tam_m a").forEach(function (element) {
        element.addEventListener("click", function () {
            if (b == 0) {
                document.getElementById("container").style.position = "relative";
                document.body.classList.add("body_alter");
                document.getElementById("container").style.overflow = "hidden";
                const container = document.getElementById("container");
                if (container) {
                    const duration = 1000;
                    const startTime = performance.now();
                    const startWidth = parseFloat(window.getComputedStyle(container).width);
                    const startHeight = parseFloat(window.getComputedStyle(container).height);
                    const startTop = parseFloat(window.getComputedStyle(container).top);
                    const startLeft = parseFloat(window.getComputedStyle(container).left);
                    const targetWidth = 10;
                    const targetHeight = 70;
                    const targetTop = 15;
                    const targetLeft = 90;
                    function animate(currentTime) {
                        const elapsedTime = currentTime - startTime;
                        const progress = Math.min(elapsedTime / duration, 1);
                        container.style.width = `${startWidth + (targetWidth - startWidth) * progress}vw`;
                        container.style.height = `${startHeight + (targetHeight - startHeight) * progress}vh`;
                        container.style.top = `${startTop + (targetTop - startTop) * progress}vh`;
                        container.style.left = `${startLeft + (targetLeft - startLeft) * progress}vw`;
                        if (progress < 1) {
                            requestAnimationFrame(animate);
                        }
                    }
                    requestAnimationFrame(animate);
                }
                animateCSS(".intro", { height: "70vh" }, 1000);
                animateCSS(".all span:nth-child(2)", { opacity: "0" }, 1000);
                animateCSS(".all span:nth-child(1)", { top: "15px" }, 1000);
                animateCSS(".all span:nth-child(3)", { top: "10.5px" }, 1000);
                document.querySelector(".all span:nth-child(1)").style.transform = "rotate(30deg)";
                document.querySelector(".all span:nth-child(3)").style.transform = "rotate(-30deg)";
                animateCSS("#up_m", { left: "0" }, 1000);
                setTimeout(function () {
                    document.querySelectorAll(".menu_tam_m li").forEach(function (li) {
                        li.style.width = "210px";
                    });
                }, 1000);
                b++;
            } else {
                setTimeout(function () {
                    document.getElementById("container").style.position = "static";
                    document.body.classList.remove("body_alter");
                    document.getElementById("container").style.height = "auto";
                }, 1000);
                animateCSS("#container", { left: "0", width: "100%", top: "0" }, 1000);
                animateCSS(".intro", { height: "100vh" }, 1000);
                animateCSS(".all span:nth-child(2)", { opacity: "1" }, 1000);
                animateCSS(".all span:nth-child(1)", { top: "7.5px" }, 1000);
                animateCSS(".all span:nth-child(3)", { top: "19px" }, 1000);
                document.querySelector(".all span:nth-child(1)").style.transform = "rotate(0deg)";
                document.querySelector(".all span:nth-child(3)").style.transform = "rotate(0deg)";
                animateCSS("#up_m", { left: "-80vw" }, 1000);
                document.querySelectorAll(".menu_tam_m li").forEach(function (li) {
                    li.style.width = "0";
                });
                b--;
            }
        });
    });
    function animateCSS(element, properties, duration) {
        let el = document.querySelector(element);
        let originalTransition = el.style.transition;
        el.style.transition = Object.keys(properties)
            .map((prop) => `${prop} ${duration}ms`)
            .join(", ");
        Object.keys(properties).forEach(function (prop) {
            el.style[prop] = properties[prop];
        });
        setTimeout(function () {
            el.style.transition = originalTransition;
        }, duration);
    }
    var servicos = [
        document.querySelector(".serv_m_1"),
        document.querySelector(".serv_m_2"),
        document.querySelector(".serv_m_3"),
        document.querySelector(".serv_m_4"),
        document.querySelector(".serv_m_5"),
        document.querySelector(".serv_m_6"),
    ];
    var servStatus = [1, 1, 1, 1, 1, 1];
    function adiciona(index) {
        servicos[index].classList.add("s_m_ex");
        servicos[index].style.maxHeight = "540px";
        servicos[index].style.height = "auto";
        servicos[index].querySelector(".circ_m").style.display = "none";
        servicos[index].querySelector(".serv_text_m").style.display = "flex";
        servicos[index].querySelector(".serv_title_m").classList.add("serv_title_m_ex");
        servicos[index].querySelector(".serv_img_m").style.display = "none";
        servicos[index].querySelector(".serv_set_m").classList.add("serv_set_m_ex");
    }
    function remove(index) {
        servicos[index].style.maxHeight = "130px";
        servicos[index].style.height = "130px";
        servicos[index].classList.remove("s_m_ex");
        servicos[index].querySelector(".circ_m").style.display = "block";
        servicos[index].querySelector(".serv_text_m").style.display = "none";
        servicos[index].querySelector(".serv_title_m").classList.remove("serv_title_m_ex");
        servicos[index].querySelector(".serv_img_m").style.display = "block";
        servicos[index].querySelector(".serv_set_m").classList.remove("serv_set_m_ex");
    }
    document.querySelectorAll(".s_m").forEach(function (element) {
        element.addEventListener("click", function () {
            var atual_m = parseInt(this.getAttribute("data-index"));
            for (var i = 0; i < servStatus.length; i++) {
                if (atual_m - 1 === i) {
                    if (servStatus[i] === 1) {
                        for (var j = 0; j < servStatus.length; j++) {
                            if (i !== j) {
                                remove(j);
                                servStatus[j] = 1;
                            }
                        }
                        adiciona(i);
                        servStatus[i] = 0;
                    } else {
                        remove(i);
                        servStatus[i] = 1;
                    }
                }
            }
        });
    });
    access("");
    function access(token) {
        const url = "https://graph.instagram.com/me/media?access_token=" + token + "&fields=media_url,media_type,caption,permalink";
        fetch(url)
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                let images = data.data;
                let conteudo = "<div class='estilo_instaa'>";
                for (let i = 0; i < 10; i++) {
                    let feed = images[i];
                    let titulo = feed.caption !== null ? feed.caption : "";
                    let tipo = feed.media_type;
                    if (tipo === "VIDEO") {
                    } else if (tipo === "IMAGE" || tipo === "CAROUSEL_ALBUM") {
                        conteudo += '<div class="img_instaa"><img title="' + titulo + '" alt="' + titulo + '" src="' + feed.media_url + '" onclick="window.open(\'' + feed.permalink + "');\"></div>";
                    }
                }
                conteudo += "<a href='https://www.instagram.com/connectionusa_/'><div class='insta'><img src='views/home/img/insta.png' alt='instagram'></div></a></div>";
                document.querySelector(".finst").innerHTML = conteudo;
                document.querySelector(".fundo_insta").innerHTML = conteudo;
            })
            .catch(function (error) {
                console.error("Erro ao acessar API do Instagram:", error);
            });
    }
});
