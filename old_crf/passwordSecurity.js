// Check if the passwords match when creating an account
function checkPasswordMatch() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
                    
    if (password === confirmPassword) {
        return true;
    } else {
        alert('Passwords do not match.');
        return false;
    }
}
   
// Allow for the password to be visible
function togglePasswordVisibility(){
    var passwordInput = document.getElementById("password");
    var confirmPasswordInput = document.getElementById("confirm_password");
    var showPasswordCheckbox = document.getElementById("showPasswordCheckbox");

    if (showPasswordCheckbox.checked){
        passwordInput.type = "text";
        confirmPasswordInput.type = "text";
    } else{
        passwordInput.type = "password";
        confirmPasswordInput.type = "password";
    }
}
