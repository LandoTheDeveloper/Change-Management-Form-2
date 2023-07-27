// Open the setting menu
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginRight = "250px";
  document.getElementById("mySidebar").classList.remove("sidebar-hidden");
}

// Close the setting menu
function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginRight = "0";
  document.getElementById("mySidebar").classList.add("sidebar-hidden");
}