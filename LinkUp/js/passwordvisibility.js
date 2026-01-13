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
