async function getDatos(tipo){
    tipo = capitalizeFirstLetter(tipo)
    let response = await fetch('./api/get'+tipo+'s.php')
    // Exito
        .then(response => response.json())  // convertir a json
        .catch(err => console.log('Solicitud fallida', err));
    let data = await JSON.parse(JSON.stringify(response));
    
    for (let i = 0; i < data.length; i++) {
        if (data[i]['imagen']!==undefined) {
            data[i]['imagen']="<img src='"+data[i]['imagen']+"'>"
        }
    }
    return data;
}