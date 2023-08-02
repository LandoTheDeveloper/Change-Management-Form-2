// Toggle page between light and dark mode
const themeToggle = document.getElementById('theme-toggle');
const body = document.body;
const modal = document.getElementById("modal-content");
const openBtn = document.getElementById("openbtn");
const sidebar = document.getElementById("mySidebar");
const sidebarTxt = document.getElementById("sidebarTxt");

// Check if there's a previously saved theme preference
const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
    body.classList.add(savedTheme);
    modal.classList.add(savedTheme);
    openBtn.classList.add(savedTheme);
    sidebar.classList.add(savedTheme);
    sidebarTxt.classList.add(savedTheme);
    if(body.classList.contains('light-mode')){
        themeToggle.checked = false;
    } else {
        themeToggle.checked = true;
    }

}

themeToggle.addEventListener('change', function() {
    // Dark Mode
    if (this.checked) {
        console.log("Dark mode.");
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        modal.classList.remove('light-mode');
        modal.classList.add('dark-mode');
        openBtn.classList.remove('light-mode');
        openBtn.classList.add('dark-mode');
        sidebar.classList.remove('light-mode');
        sidebar.classList.add('dark-mode');
        sidebarTxt.classList.remove('light-mode');
        sidebarTxt.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark-mode');
        
    // Light Mode
    } else {
        console.log("Light Mode.");
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        modal.classList.remove('dark-mode');
        modal.classList.add('light-mode');
        openBtn.classList.remove('dark-mode');
        openBtn.classList.add('light-mode');
        sidebar.classList.remove('dark-mode');
        sidebar.classList.add('light-mode');
        sidebarTxt.classList.remove('dark-mode');
        sidebarTxt.classList.add('light-mode');
        localStorage.setItem('theme', 'light-mode');
    }
});
