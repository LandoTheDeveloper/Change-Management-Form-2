// Toggle page between light and dark mode
const themeToggle = document.getElementById('theme-toggle');
const body = document.body;

// Check if there's a previously saved theme preference
const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
    body.classList.add(savedTheme);
    if(body.classList.contains('light-mode')){
        themeToggle.checked = false;
    } else {
        themeToggle.checked = true;
    }

}

themeToggle.addEventListener('change', function() {
    if (this.checked) {
        console.log("Dark mode.");
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark-mode');
    } else {
        console.log("Light Mode.");
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        localStorage.setItem('theme', 'light-mode');
    }
});