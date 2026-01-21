<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <title>LinkUp - Foire Aux Questions (FAQ)</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/faq.css" />
  </head>
  <body>
    <?php include 'header.php'; ?>

    <main class="main" id="cgu-main">
      <section class="login">
        <h1 class="auth__title">Foire Aux Questions</h1>

        <div class="cgu-content">
          <div class="faq-item">
            <h2 class="faq-question">Comment créer une activité ?</h2>
            <p class="faq-answer">
              Une fois connecté, cliquez sur le bouton "Créer une Activité" présent sur l'accueil ou dans votre profil. Remplissez le formulaire en 4 étapes et publiez !
            </p>
          </div>

          <div class="faq-item">
            <h2 class="faq-question">L'inscription aux activités est-elle gratuite ?</h2>
            <p class="faq-answer">
              Cela dépend de l'organisateur. Le prix est indiqué sur chaque fiche d'activité. Certaines sont totalement gratuites, d'autres peuvent demander une participation aux frais.
            </p>
          </div>

          <div class="faq-item">
            <h2 class="faq-question">Comment modifier mon profil ?</h2>
            <p class="faq-answer">
              Rendez-vous dans l'onglet "Préférences" via le menu utilisateur en haut à droite. Vous pourrez y modifier vos informations personnelles et vos paramètres de sécurité.
            </p>
          </div>

          <div class="faq-item">
            <h2 class="faq-question">Que faire si j'ai oublié mon mot de passe ?</h2>
            <p class="faq-answer">
              Sur la page de connexion, cliquez sur "Mot de passe oublié ?". Un lien de réinitialisation vous sera envoyé par email.
            </p>
          </div>

          <div class="faq-item">
            <h2 class="faq-question">Comment contacter un organisateur ?</h2>
            <p class="faq-answer">
              Vous pouvez voir le profil de l'organisateur en cliquant sur son nom dans les détails d'une activité. Les options de contact direct seront bientôt disponibles.
            </p>
          </div>
        </div>
      </section>
    </main>

    <?php include 'footer.php'; ?>
  </body>
</html>