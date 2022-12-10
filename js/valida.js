
    
HTMLFormElement.prototype.valida=function () {
    let valido = true;
    
    const regText = new RegExp(/^[A-Za-z]*$/);
    const regNum = new RegExp(/^[0-9]*$/);
    const regMail = new RegExp(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/);
    const regImg = new RegExp(/\.(gif|jpe?g|tiff?|png|webp|bmp)$/);
    const regCsv = new RegExp(/([a-zñA-ZÑ0-9\s_\\.\-\(\):])+(.csv)$/i);
    
    for (let i = 0; i < this.length; i++) {
        let input = this[i];
        let clases = input.classList;

        if (clases.contains('val_required')) {
            valido = input.value.length>0;
            if (!valido) {
                let text = input.previousElementSibling.innerHtml;
                input.classList.add("errorInput");
                let div = getPanelError('Error', 'El campo debe estar rellenado');
                document.body.appendChild(div);
                return false;
            }else{
                input.classList.remove("errorInput");
            }
        }
        if (clases.contains('val_text')) {
            valido = regText.test(input.value)?true:false;
            if (!valido) {
                let text = input.previousElementSibling.innerHtml;
                input.classList.add("errorInput");
                document.body.appendChild(getPanelError('Error', 'El campo marcado solo debe ser texto'));
                return false;
            }else{
                input.classList.remove("errorInput");
            }
        }
        if (clases.contains('val_num')) {
            valido = regNum.test(input.value)?true:false;
            if (!valido) {
                let text = input.previousElementSibling.innerHtml;
                input.classList.add("errorInput");
                document.body.appendChild(getPanelError('Error', 'El campo marcado solo debe ser numerico'));
                return false;
            }else{
                input.classList.remove("errorInput");
            }
        }
        if (clases.contains('val_email')) {
            valido = regMail.test(input.value)?true:false;
            if (!valido) {
                let text = input.previousElementSibling.innerHtml;
                input.classList.add("errorInput");
                document.body.appendChild(getPanelError('Error', 'El campo marcado solo debe ser un email'));
                return false;
            }else{
                input.classList.remove("errorInput");
            }
        }
        if (clases.contains('val_img')) {
            valido = regImg.test(input.value)?true:false;
            if (!valido) {
                input.classList.add("errorInput");
                let text = input.previousElementSibling.innerHtml;
                document.body.appendChild(getPanelError('Error', 'El campo marcado solo debe ser una imagen'));
                return false;
            }else{
                input.classList.remove("errorInput");
            }
        }
        if (clases.contains('val_csv')) {
            valido = regCsv.test(input.value)?true:false;
            if (!valido) {
                input.classList.add("errorInput");
                let text = input.previousElementSibling.innerHtml;
                document.body.appendChild(getPanelError('Error', 'El campo marcado solo debe ser un fichero CSV'));
                return false;
            }else{
                input.classList.remove("errorInput");
            }
        }
        
    }
    return true;
}

    for (let i = 0; i < document.forms.length; i++) {
        document.forms[i].onsubmit=validaForm;
    }
    let btnIniciaSesion = document.getElementById("btnIniciaSesion");
    if (btnIniciaSesion!=null) {
        btnIniciaSesion.onclick = validaForm(btnIniciaSesion.form); 
    }
    
    let btnRegistro = document.getElementById("btnRegistro");
    if (btnRegistro!=null) {
        btnRegistro.onclick = validaForm(btnRegistro.form); 
    }
    
    function validaForm(form){
        return function (ev) {
            ev.preventDefault();
            let valido = form.valida();
            if (valido) {
                //HTMLFormElement.prototype.submit.call(form);
                form.submit();
            }
        }
    }


/* function validaForm() {
this.onsubmit
} */
//input.classlist.containts('clase val_presente)
/* function valida(valor, tipo){

if (tipo=='texto') {
    valor.
}

} */