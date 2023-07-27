function toggleSubmenu() {
    var submenu = document.getElementById("accountSubmenu");
    submenu.style.display = submenu.style.display === "block" ? "none" : "block";
}
  
function openPasswordPopup() {
    var popup = document.getElementById("passwordPopup");
    popup.style.display = "block";
}
  
function closePasswordPopup() {
    var popup = document.getElementById("passwordPopup");
    popup.style.display = "none";
}