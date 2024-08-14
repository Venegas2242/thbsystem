let navToggleCount = 0;

function toggleNav() {
    navToggleCount++;
    const sidenav = document.getElementById("mySidenav");
    if (navToggleCount % 2 === 1) {
        if (window.innerWidth <= 450) { 
            sidenav.style.width = "70%"; // Expande el menú al 70% del ancho de la pantalla en dispositivos móviles
        } else {
            sidenav.style.width = "15rem"; // 250px to 15rem
        }
    } else {
        sidenav.style.width = "0";
    }
}

function toggleCatalogosDropdown() {
    const catalogosDropdown = document.getElementById("catalogosDropdown");
    catalogosDropdown.style.display = catalogosDropdown.style.display === "block" ? "none" : "block";
}

function toggleReportesDropdown() {
    const reportesDropdown = document.getElementById("reportesDropdown");
    reportesDropdown.style.display = reportesDropdown.style.display === "block" ? "none" : "block";
}

function toggleRequisicionesDropdown() {
    const requisicionesDropdown = document.getElementById("requisicionesDropdown");
    requisicionesDropdown.style.display = requisicionesDropdown.style.display === "block" ? "none" : "block";
}

function updateMenuButton() {
    const menuButton = document.querySelector('.menu-btn span');
    if (window.innerWidth <= 1000) {
        menuButton.innerHTML = "&#9776;";
    } else {
        menuButton.innerHTML = "&#9776; Menú";
    }
}

// Llama a updateMenuButton cuando la página se carga
window.onload = updateMenuButton;

// Llama a updateMenuButton cuando la ventana cambia de tamaño
window.onresize = updateMenuButton;
