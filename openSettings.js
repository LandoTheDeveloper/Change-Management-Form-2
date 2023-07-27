function openSidebar() {
  document.getElementById("mySidebar").classList.add("show");
}

// Function to hide the sidebar
function closeSidebar() {
  document.getElementById("mySidebar").classList.remove("show");
}

// Function to toggle the sidebar visibility
function toggleSidebar() {
  var sidebar = document.getElementById("mySidebar");
  if (sidebar.classList.contains("show")) {
      closeSidebar();
  } else {
      openSidebar();
  }
}