function getPanelError(titulo, mensaje) {
    let div = document.createElement('div');
    div.className('c-panel c-panel');

    let h2 = document.createElement('h2');
    h2.innerText=titulo;

    let p = document.createElement('p');
    p.innerHTML=mensaje;

    let btnX = creaBotonX();

    div.append(btnX,h2,p);
}