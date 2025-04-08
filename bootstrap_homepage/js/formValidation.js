// Form validation for the registration form
function validateRegisterForm() {
    const form = document.querySelector('#register form');
    const inputs = form.querySelectorAll('input');
    let valid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            valid = false;
            alert(input.placeholder + " is required.");
        }
    });

    return valid; // Prevent form submission if any field is empty
}


// Handle the click on the "Login to Add to Cart" button
document.querySelectorAll('.login-to-cart').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        // Show the login modal
        $('#loginModal').modal('show');
    });
});

// Handle switching to the Register form
document.getElementById('showRegister').addEventListener('click', function() {
    // Hide login form and show register form
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('registerForm').style.display = 'block';
});

// Handle form submission logic here (you can handle it with AJAX or redirect after success)
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Logic for logging in
    console.log('Login submitted');
    // Close modal or handle logic after successful login
    $('#loginModal').modal('hide');
});

document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Logic for registering user
    console.log('Register submitted');
    // Close modal or handle logic after successful registration
    $('#loginModal').modal('hide');
});
