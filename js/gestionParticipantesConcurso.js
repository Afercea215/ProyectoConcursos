window.onload=function () {
    //escogerParticipantes
    let btnAsignaParticip = document.getElementById('btnAsignaParticip');
    if (btnAsignaParticip!=undefined) {
        btnAsignaParticip.onclick=async function () {
            let datos = await getDatos('participante');
            let divModal = document.createElement('div');
            divModal.className='c-form c-form--asignacion animZoom';

            //caja todos los participantes
            let selectUsuarios = document.createElement('select')
            selectUsuarios.setAttribute('multiple',"");
            let selectParticipantes = document.createElement('select')
            selectParticipantes.setAttribute('multiple',"");
            
            for (let i = 0; i < datos.length; i++) {
                let option = document.createElement('option')
                option.setAttribute('value',datos[i]['id'])
                option.innerHTML=datos[i]['nombre'];

                selectUsuarios.appendChild(option);
            }
            divModal.appendChild(selectUsuarios);

            //caja botones
            let cajaBtn = document.createElement('div');

                let pasaDere=document.createElement("span")
                pasaDere.innerHTML='>'
                pasaDere.className='c-boton c-boton--secundario'
                pasaDere.onclick=function () {pasaOpciones(selectUsuarios,selectParticipantes)};

                let pasaIzq=document.createElement("span")
                pasaIzq.innerHTML='<'
                pasaIzq.className='c-boton c-boton--secundario'
                pasaIzq.onclick=function () {pasaOpciones(selectParticipantes, selectUsuarios)};
                
                let pasaTodoDere=document.createElement("span")
                pasaTodoDere.innerHTML='>>'
                pasaTodoDere.className='c-boton c-boton--secundario'
                pasaTodoDere.onclick=function () {pasaTodasOpciones(selectUsuarios, selectParticipantes)};

                let pasaTodoIzq=document.createElement("span")
                pasaTodoIzq.innerHTML='<<'
                pasaTodoIzq.className='c-boton c-boton--secundario'
                pasaTodoIzq.onclick=function () {pasaTodasOpciones(selectParticipantes,selectUsuarios)};
        
                selectParticipantes.ondblclick=function() {ordenaSelect(this)}
                selectUsuarios.ondblclick=function() {ordenaSelect(this)}
            
            cajaBtn.append(pasaDere,pasaIzq,pasaTodoDere,pasaTodoIzq);

            let btnx = creaBotonX();
            btnx.onclick=function() {
                document.body.removeChild(this.parentElement);
                document.body.removeChild(document.getElementsByClassName('bgModal')[0]);
            }

            let btnGuardar = document.createElement('span');
            btnGuardar.setAttribute('id','btnGuardar');
            btnGuardar.innerHTML='Guardar';
            btnGuardar.className='c-boton c-boton--secundario'
            btnGuardar.onclick=function () {
                let select = document.getElementById('selectParticipantes');
                let options = selectParticipantes.querySelectorAll('option');

                for (let i = 0; i < options.length; i++) {
                    options[i].selected=true;
                    select.appendChild(options[i]);                    
                }

                document.body.removeChild(this.parentElement);
                document.body.removeChild(document.getElementsByClassName('bgModal')[0]);
            }

            //caja participantes
            divModal.append(selectUsuarios, cajaBtn, selectParticipantes ,btnx , btnGuardar);

            let bgModal = document.createElement('div');
            bgModal.className='bgModal';

            document.body.append(divModal,bgModal);
        }
    }


    //escoger jueves
    let btnAsignaJueces = document.getElementById('btnAsignaJueces');
    if (btnAsignaJueces!=undefined && selectParticipantes!=undefined) {
        btnAsignaJueces.onclick=async function () {
            let options = document.getElementById('selectParticipantes').querySelectorAll('option');
            if (options.length!=0) {
                
                let divModal = document.createElement('div');
                divModal.className='c-form c-form--asignacion animZoom';
    
                //caja todos los participantes
                let selectUsuarios = document.createElement('select')
                selectUsuarios.setAttribute('multiple',"");
                let selectJueces = document.createElement('select')
                selectJueces.setAttribute('multiple',"");
                
                for (let i = 0; i < options.length; i++) {
                    let option = document.createElement('option')
                    option.setAttribute('value',options[i].value)
                    option.innerHTML=options[i].innerHTML;
    
                    selectUsuarios.appendChild(option);
                }
                divModal.appendChild(selectUsuarios);
    
                //caja botones
                let cajaBtn = document.createElement('div');
    
                    let pasaDere=document.createElement("span")
                    pasaDere.innerHTML='>'
                    pasaDere.className='c-boton c-boton--secundario'
                    pasaDere.onclick=function () {pasaOpciones(selectUsuarios,selectJueces)};
    
                    let pasaIzq=document.createElement("span")
                    pasaIzq.innerHTML='<'
                    pasaIzq.className='c-boton c-boton--secundario'
                    pasaIzq.onclick=function () {pasaOpciones(selectJueces, selectUsuarios)};
                    
                    let pasaTodoDere=document.createElement("span")
                    pasaTodoDere.innerHTML='>>'
                    pasaTodoDere.className='c-boton c-boton--secundario'
                    pasaTodoDere.onclick=function () {pasaTodasOpciones(selectUsuarios, selectJueces)};
    
                    let pasaTodoIzq=document.createElement("span")
                    pasaTodoIzq.innerHTML='<<'
                    pasaTodoIzq.className='c-boton c-boton--secundario'
                    pasaTodoIzq.onclick=function () {pasaTodasOpciones(selectJueces,selectUsuarios)};
            
                    selectJueces.ondblclick=function() {ordenaSelect(this)}
                    selectUsuarios.ondblclick=function() {ordenaSelect(this)}
                
                cajaBtn.append(pasaDere,pasaIzq,pasaTodoDere,pasaTodoIzq);
    
                let btnx = creaBotonX();
                btnx.onclick=function() {
                    document.body.removeChild(this.parentElement);
                    document.body.removeChild(document.getElementsByClassName('bgModal')[0]);
                }
    
                let btnGuardar = document.createElement('span');
                btnGuardar.innerHTML='Guardar';
                btnGuardar.className='c-boton c-boton--secundario'
                btnGuardar.onclick=function () {
                    let select = document.getElementById('selectJueces');
                    let options = selectJueces.querySelectorAll('option');
    
                    for (let i = 0; i < options.length; i++) {
                        options[i].selected=true;
                        select.appendChild(options[i]);                    
                    }

                    document.body.removeChild(this.parentElement);
                    document.body.removeChild(document.getElementsByClassName('bgModal')[0]);
                }
    
                //caja participantes
                divModal.append(selectUsuarios, cajaBtn, selectJueces ,btnx , btnGuardar);
    
                let bgModal = document.createElement('div');
                bgModal.className='bgModal';
    
                document.body.append(divModal,bgModal);
            }else{
                alert("Debe ingresar participantes primero");
            }
        }
    }

    //escribe premio de modos
    let selecionaModo = document.getElementById('selecionaModo');
    if (selecionaModo!=undefined) {
        let options = selecionaModo.querySelectorAll('option');
        for (let i = 0; i < options.length; i++) {
            options[i].onclick=function () {
                
                let label = document.createElement('label');
                label.innerHTML='Premio del modo '+options[i].innerHTML;
                let input = document.createElement('input');
                input.setAttribute('name','premio[]');
                selecionaModo.parentElement.append(label,input);
            }
        }
    }
}

function pasaOpciones(select1, select2) {        
    while (select1.selectedIndex>-1) {
        var option=select1.options[select1.selectedIndex];
        select2.appendChild(option);
        option.selected=false;
    }
}

function ordenaSelect(select) {
    let opciones = select.options;
    let lista=[];
    for (let i = 0; i < opciones.length; i++) {
        lista.push(opciones[i]);
    }

    lista.sort(function(a,b) {
        return a.innerHTML.localeCompare(b.innerHTML);
    })

    lista.forEach(element => {
        select.appendChild(element);
    });

    select.options=opciones;
}

function pasaTodasOpciones(select1, select2) {
    for (let i = 0; i < select1.options.length; i++) {
        var option=select1.options[i];
        select2.appendChild(option);
        option.selected=false;
        i--;
    }
}