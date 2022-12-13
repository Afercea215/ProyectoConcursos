window.addEventListener('load',function () {
    let contador = this.document.getElementById('contador');
    if (contador!=null) {
      contador.style.color='red';
      contador.style.marginTop='1%';
      
      let fechaStr = contador.getAttribute('data-fecha');
      const [dateValues, timeValues] = fechaStr.split(' ');
      const [year, month, day] = dateValues.split('-');
      const [hours, minutes, seconds] = timeValues.split(':');
      const fecha = new Date(+year, +month - 1, +day, +hours, +minutes, +seconds);
      var countDownDate = new Date(fecha).getTime();
      
      // Update the count down every 1 second
      var x = setInterval(function() {
      
        var now = new Date().getTime();
          
        var distance = countDownDate - now;
          
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
          
        contador.innerHTML = 'Tiempo restante : '+days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";
          
        if (distance < 0) {
          clearInterval(x);
          contador.innerHTML = "Terminado";
        }
      }, 1000);
    }
  })