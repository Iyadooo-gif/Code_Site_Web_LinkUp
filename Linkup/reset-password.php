<?php
require_once 'config.php';
$message = '';
$error = '';
$valid_token = false;
$token = null;

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $pdo->prepare("SELECT r.id_reset, u.id_user, u.email, u.prenom, u.nom 
                          FROM reset_mot_de_passe r 
                          JOIN utilisateur u ON r.email = u.email 
                          WHERE r.token = ? AND r.date_expiration > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    
    if ($user) {
        $valid_token = true;
    } else {
        $error = "Ce lien de réinitialisation est invalide ou a expiré.";
    }
} else {
    $error = "Token de réinitialisation manquant.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid_token) {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE utilisateur SET mot_de_passe = ? WHERE id_user = ?");
        $stmt->execute([$hashed_password, $user['id_user']]);
        $stmt = $pdo->prepare("DELETE FROM reset_mot_de_passe WHERE token = ?");
        $stmt->execute([$token]);
        $message = "Votre mot de passe a été réinitialisé avec succès !";
        $valid_token = false;
    }
}
?>
;?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <title>LinkUp - Réinitialiser le mot de passe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/password.css" />
  </head>
  <body>
    <?php include 'header.php'; ?>

    <main class="main">
      <section class="login">
        <h1 class="auth__title">Nouveau mot de passe</h1>

        <?php if ($message): ?>
          <div class="notification-item">
            <p class="notification-text"><?php echo htmlspecialchars($message); ?></p>
          </div>
          <a href="login.php" class="btn btn--secondary">Se connecter</a>
        <?php elseif ($error): ?>
          <div class="notification-item">
            <p class="notification-text"><?php echo htmlspecialchars($error); ?></p>
          </div>
          <a href="forgot-password.php" class="btn btn--secondary">Demander un nouveau lien</a>
        <?php endif; ?>

        <?php if ($valid_token): ?>
          <form class="form" method="POST" action="reset-password.php?token=<?php echo htmlspecialchars($token); ?>">
            <div class="form__group">
              <label class="form__label" for="password">Nouveau mot de passe</label>
              <input
                class="form__input"
                id="password"
                name="password"
                type="password"
                placeholder="Entrez votre nouveau mot de passe"
                minlength="8"
                required
              />
              <img
                src="images/eye-close.png"
                alt="Afficher le mot de passe"
                class="password-click-img"
                id="passwordIcon"/>
            </div>

            <div class="form__group">
            <label class="form__label" for="confirm_password">Confirmer le mot de passe</label>
              <input
                class="form__input"
                id="confirm_password"
                name="confirm_password"
                type="password"
                placeholder="Confirmez votre nouveau mot de passe"
                minlength="8"
                required
              />
              <img
                src="images/eye-close.png"
                alt="Afficher le mot de passe"
                class="password-click-img"
                id="confirmPasswordIcon"
              />
          </div>

            <button class="form__submit" type="submit">Réinitialiser le mot de passe</button>
          </form>
        <?php endif; ?>
        
        <p class="auth__footer">
          Retour à la page de
          <a class="auth__footer-link" href="./login.php">connexion</a>
        </p>
      </section>
    </main>
    
    <?php include 'footer.php'; ?>
    <script src="js/passwordvisibility.js?v=<?php echo time(); ?>"></script>
    <script src="js/script.js"></script>
    </body>
</html>
