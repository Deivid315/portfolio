// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
// import './styles/app.css';


console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

document.addEventListener("DOMContentLoaded", () => {

    const menu = document.getElementById("nav_menu") as HTMLElement;

    window.addEventListener("scroll", () => {
        if (window.scrollY > 0) {
            menu.classList.add("efeito_menu");
        } else {
            menu.classList.remove("efeito_menu");
        }
    });

    let isVisible = true;
    const linha = document.getElementById("linha") as HTMLElement;

    linha.addEventListener("click", ()=>{
        const linha1 = document.querySelector<HTMLElement>(".l1");
        const linha2 = document.querySelector<HTMLElement>(".l2");
        const linha3 = document.querySelector<HTMLElement>(".l3");
        const span = document.querySelector<HTMLElement>("#linha span");
        const nav_menu = document.getElementById("nav_menu") as HTMLElement;

        if (isVisible) {
            linha1.style.transform = "rotate(45deg)";
            linha3.style.transform = "rotate(-45deg)";
            span.style.position = "absolute";
            span.style.background = "#ff6a9e";
            linha2.style.opacity = "0";
            linha.style.gap = "0";
            if(window.innerWidth < 700)
            {
                nav_menu.style.width = "100%";
                nav_menu.style.borderRadius = "0";
            }else{
                nav_menu.style.width = "50%";
            }
        } else {
            linha1.style.transform = "rotate(0deg)";
            linha3.style.transform = "rotate(0deg)";
            span.style.position = "relative";
            span.style.background = "white";
            linha2.style.opacity = "1";
            linha.style.gap = "8px";
            nav_menu.style.width = "0";
            nav_menu.style.borderRadius = "10% 0 0 10%";
        }
        isVisible = !isVisible;
    })
});
