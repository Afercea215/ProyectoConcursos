window.addEventListener('load',function () {
    let descarga = this.document.getElementById('descarga');
    let perfil = this.document.getElementById('perfil');
    descarga.onclick=function () {
        console.log("sdsa");
        html2pdf()
            .from(perfil)
            .save();
    }
})