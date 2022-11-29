window.onload=function () {
    
    let mantenimiento = document.getElementById("mantenimiento");
    let submenu = document.getElementById("submenu");

    mantenimiento.onmouseover=function () {
        submenu.className="flex";
        mantenimiento.style.background="black";
    }
    mantenimiento.onmouseleave=function () {
        submenu.style.display="none";
    }
}