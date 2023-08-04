var radioButtons = document.querySelectorAll('input[name="acceptance"]');
const accepted = document.querySelector('#accepted');
const accepted_visibility = document.querySelector('#accepted_visibility');

const not_accepted = document.querySelector('#not_accepted');
const not_accepted_visibility = document.querySelector('#not_accepted_visibility');

// Hide all Client Acceptance Info
accepted_visibility.style.display = "none";
not_accepted_visibility.style.display = "none";

// If Accepted, run this code
accepted.addEventListener("click", () => {
    let selectedSize;
    for (const radioButton of radioButtons) {
        if (radioButton.checked) {
            selectedSize = radioButton.value;
            break;
        }
    }
    // Show 'accepted' and hide 'not accepted'
    accepted_visibility.style.display = "block";
    not_accepted_visibility.style.display = "none";
});

// If Not Accepted, run this code
not_accepted.addEventListener("click", () => {
    let selectedSize;
    for (const radioButton of radioButtons) {
        if (radioButton.checked) {
            selectedSize = radioButton.value;
            break;
        }
    }
    // Show 'not accepted' and hide 'accepted'
    not_accepted_visibility.style.display = "block";
    accepted_visibility.style.display = "none";
});