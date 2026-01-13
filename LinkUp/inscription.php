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
      <section class="auth">
        <h1 class="auth__title">S'inscrire</h1>
        <form class="form" method="POST" action="process_inscription.php">
          <div class="form__group">
            <label class="form__label" for="name">Nom</label>
            <input
              class="form__input"
              id="name"
              name="name"
              type="text"
              placeholder="Entrez votre nom complet"
              required
            />
          </div>
          
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
              minlength="8"
              required
            />
            <img
                src="images/eye-close.png"
                alt=""
                class="password-click-img"
                id="passwordIcon"/>
          </div>
          
          <label class="form__checkbox-wrapper">
            <input class="form__checkbox" type="checkbox" id="age" name="age" required />
            <span class="form__checkbox-label"></span>
            <span class="form__checkbox-tooltip">Les membres et les organisateurs Linkup doivent avoir au moins 18 ans.</span>
            J'ai 18 ans ou plus
          </label>

          <button class="form__submit" type="submit">S'inscrire</button>
        </form>
      </main>

    <p class="auth__footer">
          Vous avez un compte?
          <a class="auth__footer-link" href="./login.php">Se connecter</a>
        </p>
      </section>
    </main>
    <?php include 'header.php'; ?>
    <script src="js/script.js"></script>
    <script src="js/passwordvisibility.js"></script>
  </body>
</html>
