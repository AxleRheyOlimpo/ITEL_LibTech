
function sendEmail() {
    const email = document.getElementById("emailInput").value;
    if (!email) {
        alert("Please enter your email.");
        return;
    }
    document.getElementById("forgotCard").style.display = "none";
    document.getElementById("emailCard").style.display = "block";
}

function resendEmail() {
    alert("A new reset email has been sent!");
}

function goToLogin() {
    alert("Redirect to login page (add your link).");
}
