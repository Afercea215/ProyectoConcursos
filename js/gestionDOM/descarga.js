window.addEventListener('load',function () {
    let descarga = this.document.getElementById('descarga');
    if (descarga!=null) {
        let perfil = this.document.getElementById('perfil');
        descarga.onclick=function () {
            html2pdf()
                .from(perfil)
                .save();
        }
    }
})