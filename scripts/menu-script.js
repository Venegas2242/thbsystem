let navToggleCount = 0;

function toggleNav() {
    navToggleCount++;
    if (navToggleCount % 2 === 1) {
        document.getElementById("mySidenav").style.width = "15rem"; /* 250px to 15rem */
        document.querySelector('.content-wrapper').style.marginLeft = "15rem"; /* 250px to 15rem */
    } else {
        document.getElementById("mySidenav").style.width = "0";
        document.querySelector('.content-wrapper').style.marginLeft = "auto";
        document.querySelector('.content-wrapper').style.marginRight = "auto";
    }
}