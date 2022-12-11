window.addEventListener("load", function () {
    const btnFoto = this.document.getElementById("btnFoto");
    //const foto = this.document.getElementById("foto");
    const video = this.document.getElementById("video");
    const input = this.document.getElementById("inpFile");
    video.style.borderRadius = "7%";
    // video.style.borderColor = "darkorange";
    const canvas = document.getElementById('canvas');
    canvas.style.borderRadius = "7%";
  
  
    const constraints = {
      audio: true,
      video: {
        width: 300, height: 200
      }
    };
  
  
    // Accedemos a la webcam
    async function init() {
      try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        handleSuccess(stream);
      } catch (e) {
        // errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
      }
    }
    // éxito
    function handleSuccess(stream) {
      window.stream = stream;
      video.srcObject = stream;
  
    }
    init();
  
    //   El código de captación de cámara dado por Silverio
    btnFoto.addEventListener("click", function (ev) {
      ev.preventDefault();
      video.style.display = "none";
      canvas.style.display = "block";
      //foto.style.display = "none";
      var ctx = canvas.getContext('2d');  
      ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
      /*let image_data_url = canvas.toDataURL('image/jpeg');
  
      console.log(image_data_url);
      localStorage.setItem('picture', image_data_url);
      input.files[0] = localStorage.getItem('picture'); */
      canvas.toBlob((blob)=>{
        const file= new File([blob],"imagen.png");
        const dT=new DataTransfer();
        dT.items.add(file);
        input.files=dT.files;
      })
  
    });
  
  })