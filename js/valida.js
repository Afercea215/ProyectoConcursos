HTMLFormElement.prototype.valida=function () {
    let valido = true;
    debugger;
    const regText = /^[A-Za-z]*$/;
    const regNum = /^[0-9]*$/;
    const regMail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    const regImg = /\.(gif|jpe?g|tiff?|png|webp|bmp)$/;
    const regCsv = /([a-zñA-ZÑ0-9\s_\\.\-\(\):])+(.csv)$/i;

    for (let i = 0; i < this.length; i++) {
        let input = form[i];
        let clases = input.classList;

        if (clases.contains('val_required')) {
            valido = input.value.length>1;
            if (!valido) {
                let text = input.previousElementSibling.innerHtml;
                input.className+=" errorInput";
                document.body.appendChild(getPanelError('Error', text+' debe estar rellenado'));
                return false;
            }
        }
        if (clases.contains('val_text')) {
            valido = input.value.test(regText)==0?true:false;
            if (!valido) {
                let text = input.previousElementSibling.innerHtml;
                input.className+=" errorInput";
                document.body.appendChild(getPanelError('Error', text+' solo debe ser texto'));
                return false;
            }
        }
        if (clases.contains('val_num')) {
            valido = input.value.test(regNum)==0?true:false;
            if (!valido) {
                let text = input.previousElementSibling.innerHtml;
                input.className+=" errorInput";
                document.body.appendChild(getPanelError('Error', text+' solo debe ser numerico'));
                return false;
            }
        }
        if (clases.contains('val_mail')) {
            valido = input.value.test(regMail)==0?true:false;
            if (!valido) {
                let text = input.previousElementSibling.innerHtml;
                input.className+=" errorInput";
                document.body.appendChild(getPanelError('Error', text+' solo debe ser un email'));
                return false;
            }
        }
        if (clases.contains('val_img')) {
            valido = input.value.test(regImg)==0?true:false;
            if (!valido) {
                input.className+=" errorInput";
                let text = input.previousElementSibling.innerHtml;
                document.body.appendChild(getPanelError('Error', text+' solo debe ser una imagen'));
                return false;
            }
        }
        if (clases.contains('val_csv')) {
            valido = input.value.test(regCsv)==0?true:false;
            if (!valido) {
                input.className+=" errorInput";
                let text = input.previousElementSibling.innerHtml;
                document.body.appendChild(getPanelError('Error', text+' solo debe ser un fichero CSV'));
                return false;
            }
        }
        
    }
    return true;
}

HTMLFormElement.onsubmit=function (ev) {
    ev.preventDefault;
    if (this.valida()) {
        this.submit;
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