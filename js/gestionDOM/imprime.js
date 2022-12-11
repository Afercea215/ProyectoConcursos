window.addEventListener('load',function () {
    let imprime = this.document.getElementById('imprime');
    let perfil = this.document.getElementById('perfil');
    if (imprime!=undefined) {
        imprime.onclick=function () {
            let ventanaInfo = window.open("datos:blank","imprime","popup");
            ventanaInfo.document.body.append(perfil);
            ventanaInfo.print();
        }
    }
})