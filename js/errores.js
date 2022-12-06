function getPanelError(titulo, mensaje) {
    let div = document.createElement('div');
    div.className='c-panel c-panel--error animZoom';
    let h2 = document.createElement('h2');
    h2.innerText=titulo;

    let p = document.createElement('p');
    p.innerHTML=mensaje;

    let btnX = creaBotonX();

    div.append(btnX,h2,p);
    return div;
}

function muestraPanelError(titulo, error) {
    let div = getPanelError(titulo,error);
    document.body.appendChild(div);
    setTimeout(function () {
        document.body.removeChild(div);
    },3000);
}