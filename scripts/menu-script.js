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

function toggleDropdown() {
    const dropdownContainer = document.querySelector(".dropdown-container");
    if (dropdownContainer.style.display === "block") {
        dropdownContainer.style.display = "none";
    } else {
        dropdownContainer.style.display = "block";
    }
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
