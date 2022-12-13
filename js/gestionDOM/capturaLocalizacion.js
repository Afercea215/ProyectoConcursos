window.addEventListener('load',function () {
    let capturaLocalizacion = this.document.getElementById('capturaLocalizacion');
    if (capturaLocalizacion!=null) {
        
        let localx = this.document.getElementById('local-x');
        let localy = this.document.getElementById('local-y');
    
        function geoLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(imprimePosicion);
            }else{
                alert('Este dispositivo no es compatible con gps');
            }
        }
    
        function imprimePosicion(position) {
            localx.value=position.coords.latitude;
            localy.value=position.coords.longitude;
        }
    
        capturaLocalizacion.onclick=function () {
            geoLocation();
        }
    }
})