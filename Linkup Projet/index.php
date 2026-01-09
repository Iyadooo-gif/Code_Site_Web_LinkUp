<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LinkUp - Découvrez et partagez des activités</title>
    <link rel="stylesheet" href="css/main2.css" />
  </head>
  <body>
    <?php include 'header.php'; ?>
    <!-- Hero Section -->
    <section id="hero" class="hero">
      <div class="hero__carousel" aria-hidden="true">
        <div class="hero__slide"></div>
        <div class="hero__slide"></div>
        <div class="hero__slide"></div>
      </div>
      <div class="hero__overlay"></div>
      <div class="hero__content">
        <h1 class="hero__title">Trouvez des activités près de chez vous</h1>
        <div class="hero__search" role="search">
          <input
            class="hero__input"
            type="text"
            placeholder="Rechercher une activité, lieu ou mot-clé..."
          />
          <button class="hero__button" type="button" aria-label="Search">
            Rechercher
          </button>
        </div>
      </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="section">
      <div class="section__container">
        <h2 class="section__title">Explorez les Activités par Catégorie</h2>
        <div class="categories">
          <article class="category" tabindex="0">
            <div class="category__icon" aria-hidden="true">🪂</div>
            <h3 class="category__title">Sport & Aventure</h3>
            <p class="category__description">
              Randonnées, vélo, sports nautiques et plus.
            </p>
          </article>
          <article class="category" tabindex="0">
            <div class="category__icon" aria-hidden="true">🎭​</div>
            <h3 class="category__title">Arts & Ateliers</h3>
            <p class="category__description">
              Peinture, poterie, ateliers créatifs locaux.
            </p>
          </article>
          <article class="category" tabindex="0">
            <div class="category__icon" aria-hidden="true">🍽️</div>
            <h3 class="category__title">Food & Drink</h3>
            <p class="category__description">
              Expériences culinaires et dégustations.
            </p>
          </article>
        </div>
      </div>
    </section>

    <!-- Popular Activities Section -->
    <section id="activities" class="section section--gray">
      <div class="section__container">
        <h2 class="section__title">Activités Populaires Près de Chez Vous</h2>
        <div class="activities">
          <article class="activity">
            <div class="activity__image activity__image--blue"></div>
            <div class="activity__content">
              <h3 class="activity__title">Balade en montagne</h3>
              <p class="activity__meta">2h · Facile · 12 personnes</p>
              <button class="activity__button" type="button">
                Voir détails
              </button>
            </div>
          </article>

          <article class="activity">
            <div class="activity__image activity__image--orange"></div>
            <div class="activity__content">
              <h3 class="activity__title">Atelier poterie</h3>
              <p class="activity__meta">3h · Tous niveaux · 8 personnes</p>
              <button class="activity__button" type="button">
                Voir détails
              </button>
            </div>
          </article>

          <article class="activity">
            <div class="activity__image activity__image--green"></div>
            <div class="activity__content">
              <h3 class="activity__title">Dégustation locale</h3>
              <p class="activity__meta">1.5h · 18 ans+ · 20 personnes</p>
              <button class="activity__button" type="button">
                Voir détails
              </button>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section id="contact" class="cta">
      <div class="cta__container">
        <h2 class="cta__title">Prêt ? Créez Votre Propre Activité !</h2>
        <p class="cta__description">
          Connectez-vous et partagez des expériences avec votre communauté
        </p>
        <button
          class="btn btn--secondary"
          type="button"
          onclick="window.location.href='create-activity.php'"
        >
          Créer une Activité
        </button>
      </div>
    </section>

    <?php include 'footer.php'; ?>
  </body>
</html>
