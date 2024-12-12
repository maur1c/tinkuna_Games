// carrito.js
document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('carrito-overlay'); // El overlay
    const overlayBg = document.getElementById('overlay-bg'); // La capa de fondo oscurecido
    const abrirOverlay = document.getElementById('abrir-overlay'); // Botón para abrir el overlay
    const cerrarOverlay = document.getElementById('cerrar-overlay'); // Botón para cerrar el overlay

    // Mostrar el overlay y el fondo oscuro
    abrirOverlay.addEventListener('click', (e) => {
        e.preventDefault(); // Evitar que el enlace redirija
        overlay.classList.remove('hidden');  // El overlay aparece
        overlay.classList.add('mostrar');    // Asegura que el overlay se muestre
        overlayBg.classList.add('mostrar'); // Mostrar fondo oscuro
    });

    // Ocultar el overlay y el fondo oscuro
    cerrarOverlay.addEventListener('click', () => {
        overlay.classList.add('hidden');     // El overlay se oculta
        overlay.classList.remove('mostrar'); // Asegura que el overlay vuelva a estar oculto
        overlayBg.classList.remove('mostrar'); // Ocultar fondo oscuro
    });
});
