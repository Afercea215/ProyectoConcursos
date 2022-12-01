function Tabla(nombreColumnas, datos, nombreColumBd, tipoDatos, subidaMasiva = false) {
    this.tabla=document.createElement("table");
    this.tHead=this.creaTHead(nombreColumnas);
    this.tBody=document.createElement("tbody");  
    this.tabla.appendChild(this.tHead);
    this.tabla.appendChild(this.tBody);
    this.datos=datos;
    this.indice=1;
    this.tamañoPag=5;
    
    this.divPaginas = this.creaBotonesPag();
    this.orden={variable:0,creciente:true};
    
    this.nombreColumBd=nombreColumBd;
    this.edita=false;
    
    this.tipoDato=tipoDatos;
    this.tabla.className="c-tabla";
    this.pintar() ;
    this.subidaMasiva=subidaMasiva;
    this.btnNuevo=this.creaBotonNuevo();
}

Tabla.prototype.creaBotonesPag=function () {
    let div = document.createElement("div");
    div.className="c-paginacion";

    let btnPrincip = document.createElement('input');
    btnPrincip.setAttribute('type','button');
    btnPrincip.setAttribute('id','pagActual');
    btnPrincip.value=1;
    btnPrincip.className="c-paginacion__actual";

    let maxPag=Math.trunc(this.datos.length/this.tamañoPag);
    
    let btnAvanza = document.createElement('input');
    btnAvanza.setAttribute('type','button');
    btnAvanza.setAttribute('id','btnAvanza');
    btnAvanza.value=">";
    btnAvanza.className="c-paginacion__noactual";
    btnAvanza.onclick=this.cambiaPagina(this);
    
    if (this.indice==maxPag) {
        btnAvanza.disabled=true;
    }else{
        btnAvanza.disabled=false;
    }
    
    let btnRetrocede = document.createElement('input');
    btnRetrocede.setAttribute('type','button');
    btnRetrocede.setAttribute('id','btnRetrocede');
    btnRetrocede.value="<";
    btnRetrocede.className="c-paginacion__noactual";
    btnRetrocede.onclick=this.cambiaPagina(this);
    
    if (this.indice==1) {
        btnRetrocede.disabled=true;
    }else{
        btnAvanza.disabled=false;
    }

    div.append(btnRetrocede,btnPrincip,btnAvanza);

    return div;
}

Tabla.prototype.cambiaPagina=function(obj){
    return function (ev) {
        let maxPag;

        if (obj.datos.length % obj.tamañoPag != 0) {
            maxPag = Math.trunc(obj.datos.length/obj.tamañoPag)+1;
        } else{
            maxPag = obj.datos.length/obj.tamañoPag;
        }

        if (this.value==">") {
            document.getElementById("btnRetrocede").disabled=false;
            obj.indice++;   
            if (obj.indice==maxPag) {
                this.disabled=true;
            }else{
                this.disabled=false;
            }
        }else if (this.value=="<") {
            obj.indice--;
            document.getElementById("btnAvanza").disabled=false;
            if (obj.indice==1) {
                this.disabled=true;
            }else{
                this.disabled=false;
            } 
        }
        document.getElementById("pagActual").value=obj.indice;
        
        obj.actualizaPagina();
    }
}

Tabla.prototype.actualizaPagina=function(obj=this){
    for (let i = 0; i < obj.tBody.rows.length; i++) {
        obj.tBody.rows[i].removeChild(obj.tBody.rows[i].cells[obj.tBody.rows[i].cells.length-1]);
    }

    let ultimaCelda = obj.tHead.rows[0].cells[obj.tHead.rows[0].cells.length-1];
    obj.tHead.rows[0].removeChild(ultimaCelda);
    
    obj.pintar();
}

Tabla.prototype.creaTHead=function(nombreColum,obj=this){
    let tHead = document.createElement("thead");
    let tr = document.createElement("tr");

    for (let i = 0; i < nombreColum.length; i++) {
        let th = document.createElement("th");
        th.innerHTML=nombreColum[i];
        tr.appendChild(th);  
    }
    
    tHead.addEventListener('click',function (ev) {
        obj.orden['variable']=ev.target.cellIndex;
        obj.indice=1;
        document.getElementById('pagActual').value=obj.indice;
        document.getElementById('btnRetrocede').disabled=true;
        document.getElementById('btnAvanza').disabled=false;
        obj.actualizaPagina();
        obj.ordenar();
        //obj.pintar();
    })

    tHead.appendChild(tr);
    return tHead;
}

function creaTBody(datos){
    let tBody = document.createElement("tbody");
    return tBody;
}

Tabla.prototype.ordenar=function() {
    let numColum = this.orden['variable'];
    let orden = (this.orden['creciente'])?1:-1; 
    let array=[];
    /////////////////
/*     for (let i = 0; i < this.datos.length; i++) {
        this.datos.sort(function (a,b) {
            ;
            return (a[this.nombreColumBd[numColum]]).localeCompare(b.cells[numColum].innerHTML) * orden;
        });        
    } */
    for (let i = 0; i < this.tBody.rows.length; i++) {
        array.push(this.tBody.rows[i]);        
    }
    array.sort(function (a,b) {
        return (a.cells[numColum].innerHTML).localeCompare(b.cells[numColum].innerHTML) * orden;
    });
    array.forEach(element => {
        this.tBody.appendChild(element);
    });
    this.orden.creciente=!(this.orden.creciente);
}

Tabla.prototype.pintar=function() {
    //si ha mas columnas que datos boroo la ultima
    /////////////
    //Object.keys(this.datos[0]).length >  this.tHead.rows[0].cells.length
    this.tBody.innerHTML="";
    let primeraFila=this.indice*this.tamañoPag-this.tamañoPag;
    let ultimaFila=this.indice*this.tamañoPag;
    if (ultimaFila>this.datos.length) {
        ultimaFila=this.datos.length;
    }

    for (let i = primeraFila; i < ultimaFila; i++) {
        let tr = document.createElement("tr");

        let claves = Object.keys(this.datos[i]);
        for (let j = 0; j < claves.length; j++) {
            let td = document.createElement("td");
            td.innerHTML=this.datos[i][claves[j]];
            tr.appendChild(td);  
        }
        this.tBody.appendChild(tr);
    }
    this.añadeFunciones();
}

Tabla.prototype.añadeFila=function(datos){

    let tr = document.createElement("tr");
    for (let i = 0; i < datos.length; i++) {
        let td = document.createElement("td");
        td.innerHTML=datos[i];
        tr.appendChild(td);
    }
    this.tBody.appendChild(tr);

}

Tabla.prototype.añadeFunciones=function () {
    if (!this.edita) {
        let th = document.createElement("th");
        th.innerHTML="";
        this.tabla.querySelector("tr").appendChild(th);
    }

    let trs = this.tBody.getElementsByTagName("tr");

    for (let i = 0; i < trs.length; i++) {

        let td = document.createElement("td");
        td.className="editor";

       /* ;
        let ultimaCelda = trs[i].lastElementChild;
        if (ultimaCelda) {
            
        }
 */
        let spanBorra = document.createElement("span");
        let imgPapelera = document.createElement("img");
        imgPapelera.setAttribute("src","../img/logoPapelera.png");
        imgPapelera.style.width="30px";
        spanBorra.id=this.datos[i]['id'];
        spanBorra.onclick=borraFila(spanBorra.id, this.tipoDato, trs[i]);
        
        spanBorra.appendChild(imgPapelera);

        let spanEdita = document.createElement("span");
        let imgLapiz = document.createElement("img");
        imgLapiz.setAttribute("src","../img/iconoLapiz.png");
        imgLapiz.style.width="30px";
        spanEdita.id=this.datos[i]['id'];
        spanEdita.onclick=editaFila(this.tipoDato, trs[i], this.nombreColumBd, this);
        
        spanEdita.appendChild(imgLapiz);

        td.appendChild(spanEdita);
        td.appendChild(spanBorra);
        
        trs[i].appendChild(td);
    }

    this.edita=true;
}

Tabla.prototype.creaBotonNuevo=function(obj=this){
    let div = document.createElement('div');
    div.setAttribute('id','divNuevo');
    div.classNam='c-nuevo';

    let btn = document.createElement('span');
    btn.innerHTML="+ Nuevo";
    btn.setAttribute('id', 'btnNuevo');
    btn.className="c-boton g-marg-bottom--1";
    btn.onclick=imprimeFormularioNuevo(obj.nombreColumBd, obj.tipoDato);
    
    if (obj.subidaMasiva) {
        let btnMasiva = document.createElement('span');
        btnMasiva.innerHTML="+ Subida Masiva";
        btnMasiva.setAttribute('id', 'btnMasiva');
        btnMasiva.className="c-boton g-marg-bottom--1";
        btnMasiva.onclick=imprimeFormularioMasivo(obj.nombreColumBd, obj.tipoDato);
    
        div.append(btn,btnMasiva);
    }else{
        div.append(btn);
    }

    return div;
}

function imprimeFormularioMasivo(nombreColumnas, tipoDato){
    return function () {
        let form = creaFormMasivo(nombreColumnas);
        form.submit.onclick=async function (ev) { 
            ev.preventDefault();
                
            let form = this.parentNode.parentNode;
            const data = new FormData();
            //data.append('tipo',tipoDato);
    
            for (let i = 0; i < form.length-1; i++) {
                /* if (nombreColumnas[i]=='localizacion') {
                    data.append('X',form[i].value);
                    data.append('Y',form[i+1].value);
                    i++;
                } else { */
                data.append(nombreColumnas[i],form[i].value);
                //}
            }
            /////header{'Content-Type': 'application/x-www-form-urlencoded'}
            let info = await fetch("./api/altaMasiva.php?tipo="+tipoDato, {
                method: 'POST',
                body: data
             }).then(response => response)
             .then(function (response) {
                if (response.ok) {
                    console.log("ole!");      
                    if(response.status==400){
                        let div = getPanelError('Error','No se ha podido hacer el alta masiva');
                        document.body.append(div);
                    }
                }else{
                    let div = getPanelError('Error','No se ha encontrado el recurso');
                    document.body.append(div);
                }
             })
             document.body.removeChild(this.parentElement.parentElement);
             document.body.removeChild(document.getElementById("divVentana"));
    
            obj.datos = await updateDatos(tipoDato);
            obj.pintar();
        }
    /////////
        let divVentana= document.createElement("div");
        
        divVentana = document.createElement("div");
        divVentana.setAttribute("id","divVentana");
        divVentana.style.position="fixed";
        divVentana.style.top=0;
        divVentana.style.left=0;
        divVentana.style.zIndex=10;
        divVentana.style.opacity=0.35;
        divVentana.style.width="100%";
        divVentana.style.height="100%";
        divVentana.style.background="black";
        document.body.appendChild(divVentana);
        
        form.style.position="absolute";
        form.style.zIndex=100;
        var left =parseInt(window.innerWidth-form.width)/2+"px"; 
        var top =parseInt(window.innerHeight-form.height)/2+"px";
        form.style.top=top;
        form.style.left=left;
        document.body.appendChild(form);       
    }
}

function creaFormMasivo(){
    let form = document.createElement("form");
    
    //btn salir
    let btnX=creaBotonX();
    form.appendChild(btnX);

    form.className="c-form--masivo animZoom";

    let divTitulo = document.createElement("div");
    divTitulo.className="c-form__titulo";
    
    let h2 = document.createElement("h2");
    h2.innerHTML= "Importación Masiva";
    h2.style.marginBottom="4%";
    h2.style.marginTop="4%";

    divTitulo.appendChild(h2);
    divTitulo.appendChild(document.createElement("hr"));
    form.appendChild(divTitulo);

    let label = document.createElement('label');
    label.setAttribute('for','csv');

    let inputCsv = document.createElement('input');
    inputCsv.setAttribute('type','file');
    inputCsv.setAttribute('name','ficheroCSV');
    inputCsv.setAttribute('id','ficheroCSV');

    inputCsv.addEventListener('change', function() {
        let datos;    
        let textRaw;              
        var fr=new FileReader();
        
        fr.onload=function(){
            textRaw=fr.result;
            datos=csvToArray(textRaw,';');

            for (let i = 0; i < datos.length; i++) {
                let divFila = document.createElement('div');
                let keysObj = Object.keys(datos[i]);
                for (let j = 0; j < keysObj.length; j++) {
                    //si no es ID se añaden los campos
                    if (keysObj[j]!='id') {
                        let label = document.createElement('label');
                        label.setAttribute('for',keysObj[j]);
                        label.innerHTML=keysObj[j];
                        
                        let input = document.createElement('input');
                        
                        if (keysObj[j]=='admin') {
                            input.setAttribute('type', 'checkbox');
                            if (datos[i][keysObj[j]]=='1' || datos[i][keysObj[j]]=='admin') {
                                input.setAttribute('checked');
                            }
                        }else{
                            input.value=datos[i][keysObj[j]];
                        }
                        input.setAttribute('name',keysObj[j]+'[]');

                        divFila.append(label,input);
                    }
                }
                form.appendChild(divFila);
            }
        }
        fr.readAsText(this.files[0]);
        

    })


    form.append(label,inputCsv);

    div = document.createElement("div");
    let btn = document.createElement("button");
    btn.value="Crear";
    btn.name="submit";
    btn.innerHTML="Crear";
    btn.style.marginTop="7%";
    btn.classList="c-boton c-boton--secundario";

    div.append(document.createElement("hr"),btn);
    div.className="c-form__footer";
    form.appendChild(div);

    return form;
}

function subeFila() {
    let fila = this.parentElement.parentElement;
    let filaAnte = this.parentElement.parentElement.previousElementSibling;
    fila.parentElement.insertBefore(fila,filaAnte);
}

function bajaFila() {
    let fila = this.parentElement.parentElement;
    let filaAbajo = this.parentElement.parentElement.nextElementSibling;
    fila.parentElement.insertBefore(filaAbajo,fila);
}  

async function updateDatos(tipoDato){
    return await getDatos(tipoDato);
} 
    
function borraFila(id, tipoDato, fila) {
    
    return async function () {
        const data = new FormData();
        
        data.append("id",id);
        data.append("tipoDato",tipoDato);

        /////header{'Content-Type': 'application/x-www-form-urlencoded'}

        let info = await fetch("./api/elimina.php", {
            method: 'POST',
            body: data
         }).then(response => response)
         .then(function (response) {

            if (response.ok) {
                console.log("ole!");      
                if(response.status==400){
                    let div = getPanelError('Error','No se puede borrar la fila');
                    document.body.append(div);
                }else{
                    fila.parentElement.removeChild(fila);        
                }
            }else{
                let div = getPanelError('Error','No se ha encontrado el recurso');
                document.body.append(div);
            }
         })
    }
}

function editaFila(tipoDato, fila, nombreColumBd,obj) {
    return function () {
        let datos=[];
        for (let i = 0; i < fila.cells.length; i++) {
            datos[nombreColumBd[i]]=fila.cells[i].innerHTML; 
        }
        imprimeFormularioEdicion(nombreColumBd, datos, tipoDato,obj);
    }
}

function imprimeFormularioNuevo(nombreColumnas, tipoDato){
    return function () {
        let form = creaFormNuevo(nombreColumnas);
        form.submit.onclick=async function (ev) { 
            ev.preventDefault();
            const toBase64 = file => new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => resolve(reader.result);
                reader.onerror = error => reject(error);
            });
    
            let form = this.parentNode.parentNode;
            const data = new FormData();
    
            //data.append('tipo',tipoDato);
    
            for (let i = 0; i < form.length-1; i++) {
                if (form[i].type=='file'){
                    let img;
                    if (form[i].files.length>0) {
                        const file = form[i].files[0];
                        img = await toBase64(file);
                    }else{
                        let imgActual = document.getElementById("imgActual");
                        img=imgActual.src;
                    }
                    data.append(nombreColumnas[i],img);
                }else if (nombreColumnas[i]=='localizacion') {
                    data.append('X',form[i].value);
                    data.append('Y',form[i+1].value);
                    i++;
                } else {
                    data.append(nombreColumnas[i],form[i].value);
                }
            }
            /////header{'Content-Type': 'application/x-www-form-urlencoded'}
            let info = await fetch("./api/nuevo.php?tipo="+tipoDato, {
                method: 'POST',
                body: data
             }).then(response => response)
             .then(function (response) {
                if (response.ok) {
                    console.log("ole!");      
                    if(response.status==500){
                        let div = getPanelError('Error','No se ha podido crear el'+tipoDato);
                        document.body.append(div);
                    }
                }else{
                    let div = getPanelError('Error','No se ha encontrado el recurso');
                    document.body.append(div);
                }
             })
             document.body.removeChild(this.parentElement.parentElement);
             document.body.removeChild(document.getElementById("divVentana"));
    
             obj.datos = await updateDatos(tipoDato);
             obj.pintar();
        }
    /////////
        let divVentana= document.createElement("div");
        
        divVentana = document.createElement("div");
        divVentana.setAttribute("id","divVentana");
        divVentana.style.position="fixed";
        divVentana.style.top=0;
        divVentana.style.left=0;
        divVentana.style.zIndex=10;
        divVentana.style.opacity=0.35;
        divVentana.style.width="100%";
        divVentana.style.height="100%";
        divVentana.style.background="black";
        document.body.appendChild(divVentana);
        
        form.style.position="absolute";
        form.style.zIndex=100;
        var left =parseInt(window.innerWidth-form.width)/2+"px"; 
        var top =parseInt(window.innerHeight-form.height)/2+"px";
        form.style.top=top;
        form.style.left=left;
        document.body.appendChild(form);       
    }
}

function creaFormNuevo(nombreColumnas){
    let form = document.createElement("form");
    
    //btn salir
    let btnX=creaBotonX();
    form.appendChild(btnX);

    form.className="c-form--edicion animZoom";

    let divTitulo = document.createElement("div");
    divTitulo.className="c-form__titulo";
    
    let h2 = document.createElement("h2");
    h2.innerHTML= "Nuevo";
    h2.style.marginBottom="4%";
    h2.style.marginTop="4%";

    divTitulo.appendChild(h2);
    divTitulo.appendChild(document.createElement("hr"));
    form.appendChild(divTitulo);

    for (let i = 0; i < nombreColumnas.length; i++) {
        if (nombreColumnas[i]!='id') {
            
            let div = document.createElement("div");
            let label = document.createElement("label");
            label.innerHTML=capitalizeFirstLetter(nombreColumnas[i]);
            
            label.setAttribute("for",nombreColumnas[i]);
            let input = document.createElement("input");
            input.setAttribute("name",nombreColumnas[i]);
    
            let textImg;
            let img;
    
            //si es localizacion
            let x;
            let y;
            let labelX;
            let labely;
            if (nombreColumnas[i]=='localizacion') {
                labelX = document.createElement("label"); 
                labelX.setAttribute("for","x");
                labelX.innerHTML="X";
                x = document.createElement("input");
                x.setAttribute("name","x");
                x.setAttribute("type","number");
                
                labely = document.createElement("label"); 
                labely.setAttribute("for","y");
                labely.innerHTML="Y";
                y = document.createElement("input");
                y.setAttribute("type","number");
                y.setAttribute("name","y");
    
            }else if (nombreColumnas[i]=="imagen") {
                //si es imgaen creo la inmagen con el input fil
                input.setAttribute("type","file");
    
            }else if (nombreColumnas[i]=='admin') {
                input.setAttribute("type","checkbox");
            }else{
                input.setAttribute("type","text");
            }
    
            //compruebo si es id y lo descativo
            if (nombreColumnas[i]=='id') {
                input.disabled=true;
            }
    
            //dependiendo si hay img o localizacion no inserto una u otra
            if (img !== undefined) {
                div.className="c-form__componente--imagen";
                div.append(label,img,input);
            }else if (x !== undefined && y !== undefined) {
                div.className="c-form__componente";
                div.append(label,labelX,x,labely,y);
            }else{
                div.className="c-form__componente";
                div.append(label,input);
            }
            
            form.append(div);
        }
    }
    div = document.createElement("div");
    let btn = document.createElement("button");
    btn.value="Crear";
    btn.name="submit";
    btn.innerHTML="Crear";
    btn.style.marginTop="7%";
    btn.classList="c-boton c-boton--secundario";

    div.append(document.createElement("hr"),btn);
    div.className="c-form__footer";
    form.appendChild(div);

    return form;
}

function imprimeFormularioEdicion(nombreColumnas, datos, tipoDato,obj){
    let form = creaFormEdicion(nombreColumnas, datos);
    form.submit.onclick=async function (ev) { 
        ev.preventDefault();

        const toBase64 = file => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });

        let form = this.parentNode.parentNode;
        const data = new FormData();

        //data.append('tipo',tipoDato);

        for (let i = 0; i < form.length-1; i++) {
            if (form[i].type=='file'){
                let img;
                if (form[i].files.length>0) {
                    const file = form[i].files[0];
                    img = await toBase64(file);
                }else{
                    let imgActual = document.getElementById("imgActual");
                    img=imgActual.src;
                }
                data.append(nombreColumnas[i],img);
            }else if (nombreColumnas[i]=='localizacion') {
                data.append('X',form[i].value);
                data.append('Y',form[i+1].value);
                i++;
            } else {
                data.append(nombreColumnas[i],form[i].value);
            }
        }

        /////header{'Content-Type': 'application/x-www-form-urlencoded'}
        let actualizado=false;
        let info = await fetch("./api/edita.php?tipo="+tipoDato, {
            method: 'POST',
            body: data
         }).then(response => response)
         .then(function (response) {
            if (response.ok) {
                if(response.status==500){
                    console.log("ole!");      
                    let div = getPanelError('Error','No se puede actualizar el'+tipoDato);
                    document.body.append(div);
                }else if (response.status==200) {
                    
                }
            }else{
                let div = getPanelError('Error','No se ha encontrado el recurso');
                document.body.append(div);
            }
         })
         document.body.removeChild(this.parentElement.parentElement);
         document.body.removeChild(document.getElementById("divVentana"));
         debugger
         obj.datos = await updateDatos(tipoDato);
         obj.pintar();
    }
/////////
    let divVentana= document.createElement("div");
    
    divVentana = document.createElement("div");
    divVentana.setAttribute("id","divVentana");
    divVentana.style.position="fixed";
    divVentana.style.top=0;
    divVentana.style.left=0;
    divVentana.style.zIndex=10;
    divVentana.style.opacity=0.35;
    divVentana.style.width="100%";
    divVentana.style.height="100%";
    divVentana.style.background="black";
    document.body.appendChild(divVentana);
    
    form.style.position="absolute";
    form.style.zIndex=100;
    var left =parseInt(window.innerWidth-form.width)/2+"px"; 
    var top =parseInt(window.innerHeight-form.height)/2+"px";
    form.style.top=top;
    form.style.left=left;
    document.body.appendChild(form);
}

function creaFormEdicion(nombreColumnas, datos){
    let form = document.createElement("form");
    
    //btn salir
    let btnX=creaBotonX();
    form.appendChild(btnX);

    form.className="c-form--edicion animZoom";

    let divTitulo = document.createElement("div");
    divTitulo.className="c-form__titulo";
    
    let h2 = document.createElement("h2");
    h2.innerHTML= "Edicion";
    h2.style.marginBottom="4%";
    h2.style.marginTop="4%";

    divTitulo.appendChild(h2);
    divTitulo.appendChild(document.createElement("hr"));
    form.appendChild(divTitulo);

    for (let i = 0; i < nombreColumnas.length; i++) {
        let div = document.createElement("div");
        let label = document.createElement("label");
        label.innerHTML=capitalizeFirstLetter(nombreColumnas[i]);
        
        label.setAttribute("for",nombreColumnas[i]);
        let input = document.createElement("input");
        input.setAttribute("name",nombreColumnas[i]);

        let textImg;
        let img;

        //si es localizacion
        let x;
        let y;
        let labelX;
        let labely;
        if (nombreColumnas[i]=='localizacion') {
            labelX = document.createElement("label"); 
            labelX.setAttribute("for","x");
            labelX.innerHTML="X";
            x = document.createElement("input");
            x.setAttribute("name","x");
            x.setAttribute("type","number");
            x.value=datos[nombreColumnas[i]].substring(3, datos[nombreColumnas[i]].indexOf("Y")-3);
            
            labely = document.createElement("label"); 
            labely.setAttribute("for","y");
            labely.innerHTML="Y";
            y = document.createElement("input");
            y.setAttribute("type","number");
            y.setAttribute("name","y");
            y.value=datos[nombreColumnas[i]].substring(datos[nombreColumnas[i]].indexOf("Y:")+3, datos[nombreColumnas[i]].length);

        }else if (nombreColumnas[i]=="imagen") {
            //si es imgaen creo la inmagen con el input fil
            textImg = document.createElement("p");
            textImg.innerHTML="Imagen Actual";

            let stringImg;
            if (datos[nombreColumnas[i]].indexOf("data")==-1) {
                stringImg=datos[nombreColumnas[i]].substring(datos[nombreColumnas[i]].indexOf("src=")+5,datos[nombreColumnas[i]].length-2);
            }else{
                stringImg = datos[nombreColumnas[i]].substring(datos[nombreColumnas[i]].indexOf("data"),datos[nombreColumnas[i]].length-2);
            }
            
            img = new Image();
            img.setAttribute("src",stringImg+"");
            img.setAttribute("id", "imgActual");
            input.setAttribute("type","file");

        }else if (nombreColumnas[i]=='admin') {
            input.setAttribute("type","checkbox");
            if (datos[nombreColumnas[i]]=='1') {
                input.checked=true;
            }

        }else{
            input.setAttribute("type","text");
            input.value=datos[nombreColumnas[i]];
        }

        //compruebo si es id y lo descativo
        if (nombreColumnas[i]=='id' || nombreColumnas[i]=='identificador') {
            input.disabled=true;
        }

        //dependiendo si hay img o localizacion no inserto una u otra
        if (img !== undefined) {
            div.className="c-form__componente--imagen";
            div.append(label,img,input);
        }else if (x !== undefined && y !== undefined) {
            div.className="c-form__componente";
            div.append(label,labelX,x,labely,y);
        }else{
            div.className="c-form__componente";
            div.append(label,input);
        }
        
        
        form.append(div);
    }
    div = document.createElement("div");
    let btn = document.createElement("button");
    btn.value="Guardar";
    btn.name="submit";
    btn.innerHTML="Guardar";
    btn.style.marginTop="7%";
    btn.classList="c-boton c-boton--secundario";

    div.append(document.createElement("hr"),btn);
    div.className="c-form__footer";
    form.appendChild(div);

    return form;
}


function capitalizeFirstLetter(string) {
    return string.substring(0,1).toUpperCase() + string.slice(1);
  }


function creaBotonX(){
    let btnX = document.createElement("span");
    let imgX = document.createElement("img");
    imgX.setAttribute("src","./img/x.webp");
    btnX.appendChild(imgX);
    btnX.onclick=function () {
        this.parentElement.parentElement.removeChild(this.parentElement);
        document.body.removeChild(document.getElementById("divVentana"));
    }
    return btnX;
}


function csvToArray(str, delimiter = ",") {
    // slice from start of text to the first \n index
    // use split to create an array from string by delimiter
    const headers = str.slice(0, str.indexOf("\n")).split(delimiter);
  
    // slice from \n index + 1 to the end of the text
    // use split to create an array of each csv value row
    const rows = str.slice(str.indexOf("\n") + 1).split("\n");
  
    // Map the rows
    // split values from each row into an array
    // use headers.reduce to create an object
    // object properties derived from headers:values
    // the object passed as an element of the array
    const arr = rows.map(function (row) {
      const values = row.split(delimiter);
      const el = headers.reduce(function (object, header, index) {
        object[header] = values[index];
        return object;
      }, {});
      return el;
    });
  
    // return the array
    return arr;
  }