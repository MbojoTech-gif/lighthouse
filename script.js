//navigation bar.......................
// Get the navigation links container
const navLinks = document.getElementById("navLinks");

// Function to show the menu
function showMenu() {
    navLinks.style.right = "0";
}

// Function to hide the menu
function hideMenu() {
    navLinks.style.right = "-250px"; // Moves the menu off-screen
}

//scrolling in index.html................


document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll(".ministry-content");

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("show");
            } else {
                entry.target.classList.remove("show");
            }
        });
    }, {
        threshold: 0.3 // When 30% of the section is visible
    });

    sections.forEach(section => observer.observe(section));
});





document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    const signUpForm = document.getElementById("signUpForm");
    const toggleButton = document.getElementById("toggleFormButton");
    const formTitle = document.getElementById("formTitle");

    toggleButton.addEventListener("click", function() {
        if (loginForm.style.display !== "none") {
            loginForm.style.display = "none";
            signUpForm.style.display = "block";
            formTitle.innerText = "Sign Up";
            toggleButton.innerText = "Already have an account? Login";
        } else {
            loginForm.style.display = "block";
            signUpForm.style.display = "none";
            formTitle.innerText = "Login";
            toggleButton.innerText = "Don't have an account? Sign Up";
        }
    });
});



            //prayerband.html....................................
// Handle Login
function handleAuth() {
    let username = document.getElementById("username").value.trim();
    let password = document.getElementById("password").value.trim();
    let errorContainer = document.getElementById("auth-error");

    // Check if fields are empty
    if (!username || !password) {
        errorContainer.innerHTML = "⚠️ All fields are required!";
        errorContainer.style.display = "block";
        return;
    }

    // Simulate authentication (Replace with actual login logic)
    if (username === "admin" && password === "password") {
        // Hide login form and show dashboard
        document.getElementById("auth-container").classList.add("hidden");
        document.getElementById("dashboard").classList.remove("hidden");
        document.getElementById("user-email").innerText = username;
    } else {
        errorContainer.innerHTML = "❌ Invalid username or password!";
        errorContainer.style.display = "block";
    }
}

// Handle Registration
function handleRegister() {
    let fullname = document.getElementById("fullname").value.trim();
    let username = document.getElementById("username-register").value.trim();
    let email = document.getElementById("email").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let password = document.getElementById("password-register").value.trim();
    let confirmPassword = document.getElementById("confirm-password").value.trim();
    let errorContainer = document.getElementById("register-error");

    // Validate fields
    if (!fullname || !username || !email || !phone || !password || !confirmPassword) {
        errorContainer.innerHTML = "⚠️ All fields are required!";
        errorContainer.style.display = "block";
        return;
    }

    // Validate email format
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        errorContainer.innerHTML = "⚠️ Please enter a valid email address!";
        errorContainer.style.display = "block";
        return;
    }

    // Validate phone number
    let phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(phone)) {
        errorContainer.innerHTML = "⚠️ Phone number must be 10 digits!";
        errorContainer.style.display = "block";
        return;
    }

    // Validate password match
    if (password !== confirmPassword) {
        errorContainer.innerHTML = "⚠️ Passwords do not match!";
        errorContainer.style.display = "block";
        return;
    }

    // Registration success (Simulated)
    errorContainer.innerHTML = "✅ Registration successful!";
    errorContainer.style.color = "green";
}

// Toggle Login/Register Forms
function toggleAuth() {
    let loginForm = document.getElementById("login-form");
    let registerForm = document.getElementById("register-form");
    let authTitle = document.getElementById("auth-title");

    if (registerForm.classList.contains("hidden")) {
        registerForm.classList.remove("hidden");
        loginForm.classList.add("hidden");
        authTitle.innerText = "Register";
    } else {
        registerForm.classList.add("hidden");
        loginForm.classList.remove("hidden");
        authTitle.innerText = "Prayer Band Login";
    }
}

function toggleMusic() {
    let music = document.getElementById("bg-music");
    if (music.paused) {
        music.play();
    } else {
        music.pause();
    }
}



// Function to handle posting a comment
function postComment() {
    // Get the comment value from the textarea
    const commentText = document.getElementById('comment').value;

    // Check if the comment is not empty
    if (commentText.trim() === "") {
        alert("Please enter a comment!");
        return;
    }

    // Create a new div for the comment
    const commentBox = document.createElement("div");
    commentBox.classList.add("comment-box");

    // Add the comment author (you can modify this to pull from the logged-in user)
    const commentAuthor = document.createElement("div");
    commentAuthor.classList.add("author");
    commentAuthor.textContent = "Your Name"; // Replace with actual user's name if available

    // Add the comment text
    const commentContent = document.createElement("div");
    commentContent.classList.add("text");
    commentContent.textContent = commentText;

    // Append the author and content to the commentBox
    commentBox.appendChild(commentAuthor);
    commentBox.appendChild(commentContent);

    // Append the new commentBox to the comment-list container
    document.getElementById("comment-list").appendChild(commentBox);

    // Clear the textarea after posting the comment
    document.getElementById('comment').value = '';
}



// Form Validation
function validateForm() {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const voicePart = document.getElementById('voicePart').value.trim();

    if (name === "" || email === "" || voicePart === "") {
        alert("Please fill in all required fields.");
        return false;
    }
    return true;
}

function toggleAuth() {
    document.getElementById("login-form").classList.toggle("hidden");
    document.getElementById("register-form").classList.toggle("hidden");
    document.getElementById("auth-title").textContent = 
        document.getElementById("login-form").classList.contains("hidden") 
        ? "Prayer Band Registration" 
        : "Prayer Band Login";
}
