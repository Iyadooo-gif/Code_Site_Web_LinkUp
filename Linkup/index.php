<?php require_once 'config.php'; 
$stmt = $pdo->prepare("
    SELECT id_activite, titre, date_heure, nb_place, image_couverture 
    FROM activite 
    ORDER BY date_heure DESC 
    LIMIT 3
");
$stmt->execute();
$activites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LinkUp - Découvrez et partagez des activités</title>
    <link rel="stylesheet" href="css/style.css" />
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
    <div class="activities">
    <?php if (empty($activites)): ?>
        <p>Aucune activité n'est disponible pour le moment.</p>
    <?php else: ?>
        <?php foreach ($activites as $act): ?>
            <article class="activity">
                <div class="activity__image" 
                      style="background-image: url('<?php echo !empty($act['image_couverture']) ? htmlspecialchars($act['image_couverture']) : 'images/default_activity.jpg'; ?>'); background-size: cover; background-position: center; height: 180px;">
                </div>
                
                <div class="activity__content">
                    <h3 class="activity__title"><?php echo htmlspecialchars($act['titre']); ?></h3>
                    
                    <p class="activity__meta">
                        <?php echo date('d/m/Y', strtotime($act['date_heure'])); ?> · 
                        <?php echo htmlspecialchars($act['nb_place']); ?> personnes max
                    </p>
                    
                    <button class="activity__button" type="button" 
                            onclick="window.location.href='activity-details.php?id=<?php echo $act['id_activite']; ?>'">
                        Voir détails
                    </button>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
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
