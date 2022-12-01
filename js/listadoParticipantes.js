    
    async function imprimeParticipantes(){
        let main = document.getElementById("cuerpo");
        let datos = await getParticipantes();
        let nombreColumnas=["id","Nombre","Identificador", "Administrador", "Correo", "Imagen", "Localizacion"]; 
        let nombreColumnasDb=["id","nombre","identificador", "admin", "correo", "imagen", "localizacion"]; 
        let tablaConcursos=new Tabla(nombreColumnas,datos,nombreColumnasDb,"Participante",true);
        
        main.append(tablaConcursos.btnNuevo,tablaConcursos.tabla,tablaConcursos.divPaginas);
    }

    async function getParticipantes(tipo='participante'){
        return await getDatos(tipo);
    }
/* 
    function preparaDatos(datos){
        for (let i = 0; i < datos.length; i++) {
            datos[i]['imagen']="<img src='"+datos[i]['imagen']+"'>"
        }
        return datos;
    } */