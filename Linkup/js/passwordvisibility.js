const passwordIcon = document.getElementById("passwordIcon");
const passwordInput = document.getElementById("password");

if (passwordIcon && passwordInput) {
  passwordIcon.addEventListener("click", function () {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      passwordIcon.src = "images/eye-open.png";
      passwordIcon.alt = "Masquer le mot de passe";
    } else {
      passwordInput.type = "password";
      passwordIcon.src = "images/eye-close.png";
      passwordIcon.alt = "Afficher le mot de passe";
    }
  });
}

// Pour la confirmation du mot de passe
const confirmIcon = document.getElementById("confirmPasswordIcon");
const confirmInput = document.getElementById("confirm_password");

if (confirmIcon && confirmInput) {
  confirmIcon.addEventListener("click", function () {
    if (confirmInput.type === "password") {
      confirmInput.type = "text";
      confirmIcon.src = "images/eye-open.png";
      confirmIcon.alt = "Masquer le mot de passe";
    } else {
      confirmInput.type = "password";
      confirmIcon.src = "images/eye-close.png";
      confirmIcon.alt = "Afficher le mot de passe";
    }
  });
}

const form = document.querySelector(".form");
if (form) {
  form.addEventListener("submit", function (e) {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirm_password").value;

    if (password !== confirmPassword) {
      e.preventDefault();
      alert("Les mots de passe ne correspondent pas.");
      return false;
    }

    if (password.length < 8) {
      e.preventDefault();
      alert("Le mot de passe doit contenir au moins 8 caractères.");
      return false;
    }
  });
}
