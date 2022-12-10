window.onload=function () {
    let btns = document.getElementsByClassName("btnSalir");

    if (btns.length>0) {
        btns[0].onclick=function () {
            document.getElementById('cuerpo').removeChild(this.parentNode);
            document.getElementById('cuerpo').removeChild(document.getElementsByClassName("bgModal")[0]);
        }
        
    }

}