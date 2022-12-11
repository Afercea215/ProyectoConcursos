window.addEventListener('load',function () {
  let desplegable = document.getElementById("desplegable");

  if (desplegable!=undefined) {
    desplegable.onclick=function () {
      document.getElementById("contenido-menu").classList.toggle("show");
    }
  }

  window.onclick = function(event) {
      if (!event.target.matches('.btnDesplegable')) {
        var dropdowns = document.getElementsByClassName("c-menu-desplegable__contenido");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
});
   