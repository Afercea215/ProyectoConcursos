    
    async function imprimeModo(){
        let main = document.getElementById("cuerpo");
        let datos = await getModo();
        let nombreColumnas=["id","Nombre"]; 
        let nombreColumnasDb=["id","nombre"]; 
        let tablaConcursos=new Tabla(nombreColumnas,datos,nombreColumnasDb,"Modo");
        
        main.append(tablaConcursos.btnNuevo,tablaConcursos.tabla,tablaConcursos.divPaginas);
    }

    async function getModo(tipo='modo'){
        return await getDatos(tipo);
    }
/* 
    function preparaDatos(datos){
        for (let i = 0; i < datos.length; i++) {
            datos[i]['imagen']="<img src='"+datos[i]['imagen']+"'>"
        }
        return datos;
    } */