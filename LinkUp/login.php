<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <title>LinkUp - Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/password.css" />
  </head>
  <body>
    <?php include 'header.php'; ?>

    <main class="main">
      <section class="login">
        <h1 class="auth__title">Se connecter</h1>

        <form class="form" method="POST" action="process_login.php">
          <div class="form__group">
            <label class="form__label" for="email">Email</label>
            <input
              class="form__input"
              id="email"
              name="email"
              type="email"
              placeholder="Entrez votre email"
              required
            />
          </div>

          <div class="form__group">
            <label class="form__label" for="password">Password</label>
            <input
              class="form__input"
              id="password"
              name="password"
              type="password"
              placeholder="Entrez votre mot de passe"
              required
            />
              <img
                src="images/eye-close.png"
                alt=""
                class="password-click-img"
                id="passwordIcon"/>
          </div>

          <label class="form__checkbox-wrapper">
            Se souvenir de moi
            <input
              class="form__checkbox"
              type="checkbox"
              id="remember"
              name="remember"
            />
            <span class="form__checkbox-label"></span>
          </label>

          <a class="form__link" href="#">Mot de passe oublié?</a>

          <button class="form__submit" type="submit">Se connecter</button>
        </form>
        <p class="auth__footer">
          Créer votre compte?
          <a class="auth__footer-link" href="./inscription.php">S'inscrire</a>
        </p>
      </section>
    </main>
    <?php include 'footer.php'; ?>

    <script src="js/login.js"></script>
    <script src="js/passwordvisibility.js"></script>
  </body>
</html>
