const carrusel = document.querySelector('.imagenes-carrusel');
const botonesCarrusel = document.querySelectorAll('.boton-carrusel');
let indiceActual = 0;
const imagenes = document.querySelectorAll('.imagen-carrusel');
let enTransicion = false; 


function moverCarrusel() {
    if (enTransicion) return; 
    enTransicion = true; 

    if (indiceActual >= imagenes.length) {
        indiceActual = 0;
    }
    
    
    carrusel.style.transform = `translateX(-${indiceActual * 100}%)`;
    actualizarBotones();

    
    setTimeout(() => enTransicion = false, 500);
}


function actualizarBotones() {
    botonesCarrusel.forEach(boton => boton.style.backgroundColor = '#fff');
    botonesCarrusel[indiceActual].style.backgroundColor = '#ffd700';
}


botonesCarrusel.forEach(boton => {
    boton.addEventListener('click', () => {
        indiceActual = parseInt(boton.getAttribute('data-index'));
        moverCarrusel();
    });
});


setInterval(() => {
    indiceActual++;
    moverCarrusel();
}, 5000);

// Iniciar el carrusel
moverCarrusel();
