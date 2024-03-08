document.getElementById("signupForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var passwordConfirmation = document.getElementById("password_confirmation").value;

    // Basic form validation for name and email
    if (name.trim() === "") {
        showError("name", "Name is required");
        return;
    }

    if (email.trim() === "") {
        showError("email", "Email is required");
        return;
    }

    // Email validation
    if (!/\S+@\S+\.\S+/.test(email)) {
        showError("email", "Valid email is required");
        return;
    }

    // Password validation
    if (password.trim().length < 8) {
        showError("password", "Password must be at least 8 characters");
        return;
    }

    if (!/\d/.test(password)) {
        showError("password", "Password must contain at least one number");
        return;
    }

    if (!/[a-zA-Z]/.test(password)) {
        showError("password", "Password must contain at least one letter");
        return;
    }

    // Password confirmation validation
    if (password !== passwordConfirmation) {
        showError("password_confirmation", "Passwords must match");
        return;
    }

    // Perform AJAX request to check email availability
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (!response.available) {
                    showError("email", "Email is already taken. Please choose a different email.");
                    return;
                } else {
                    // If email is available, submit the form
                    document.getElementById("signupForm").submit();
                }
            } else {
                showError("email", "Error: Unable to check email availability.");
            }
        }
    };
    xhr.open("GET", "validate-email.php?email=" + encodeURIComponent(email), true);
    xhr.send();
});

// Function to show error message
function showError(fieldId, errorMessage) {
var field = document.getElementById(fieldId);

// Check if error message already exists for the field
var existingError = document.querySelector(`#${fieldId}-error`);
if (existingError) {
    existingError.textContent = errorMessage;
} else {
    // Create error message element
    var errorField = document.createElement("div");
    errorField.id = `${fieldId}-error`;
    errorField.className = "error-message";
    errorField.textContent = errorMessage;
    errorField.style.color = "red";
    errorField.style.fontSize = "12px";
    errorField.style.marginTop = "5px";
    field.parentNode.appendChild(errorField);
}
}

// Function to hide error message
function hideError(fieldId) {
var errorField = document.getElementById(`${fieldId}-error`);
if (errorField) {
    errorField.remove();
}
}

// Add event listeners for form fields
document.getElementById("name").addEventListener("input", function() {
hideError("name");
});

document.getElementById("email").addEventListener("input", function() {
hideError("email");
});

document.getElementById("password").addEventListener("input", function() {
hideError("password");
});

document.getElementById("password_confirmation").addEventListener("input", function() {
hideError("password_confirmation");
});

// Add event listener for email field focus
document.getElementById("email").addEventListener("focus", function() {
hideError("email");
});
