

        $(document).ready(function() {

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
        0 == i ? ($("#container").css("position", "relative"), $("body").addClass("body_alter"), $("#container").css("overflow", "hidden"), $("#container").animate({
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
        1e3), $("#container").css("overflow-y", "scroll"), $("#container").animate({
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
    