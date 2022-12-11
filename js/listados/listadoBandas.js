    
    async function imprimeBanda(){
        let main = document.getElementById("cuerpo");
        let datos = await getBanda();
        let nombreColumnas=["id","Distancia","Rango Minimo","Rango Max"]; 
        let nombreColumnasDb=["Id","distancia","rangoMin","rangoMax"]; 
        let tablaConcursos=new Tabla(nombreColumnas,datos,nombreColumnasDb,"Banda");
        
        main.append(tablaConcursos.btnNuevo,tablaConcursos.tabla,tablaConcursos.divPaginas);
    }

    async function getBanda(tipo='banda'){
        return await getDatos(tipo);
    }
/* 
    function preparaDatos(datos){
        for (let i = 0; i < datos.length; i++) {
            datos[i]['imagen']="<img src='"+datos[i]['imagen']+"'>"
        }
        return datos;
    } */