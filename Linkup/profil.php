<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil - LinkUp</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <main>
      <section class="section">
        <div class="container">
          <!-- Profile Header -->
          <div class="profile__header">
            <div class="profile__avatar">
              <img
                src="images/avatar-placeholder.svg"
                alt="Jean Dupont"
                style="
                  width: 120px;
                  height: 120px;
                  border-radius: 50%;
                  object-fit: cover;
                "
              />
              <button class="profile__edit-avatar">Modifier</button>
            </div>

            <div class="profile__info">
              <h1 class="profile__title">Jean Dupont</h1>
              <p class="profile__bio">
                Passionné d'aventure et d'arts créatifs. Membre depuis 2023.
              </p>

              <div class="profile__stats">
                <div class="stat">
                  <span class="stat__number">15</span>
                  <span class="stat__label">Activités</span>
                </div>
                <div class="stat">
                  <span class="stat__number">8</span>
                  <span class="stat__label">Créées</span>
                </div>
                <div class="stat">
                  <span class="stat__number">4.8</span>
                  <span class="stat__label">Note</span>
                </div>
              </div>

              <div class="profile__actions">
                <button class="btn btn--secondary">Créer une Activité</button>
                <button class="btn btn--outline">Inviter des Amis</button>
              </div>
            </div>
          </div>

          <!-- Tabs Navigation -->
          <div class="profile__tabs">
            <button class="tab active" onclick="showTab('activities')">
              Activités Passées
            </button>
            <button class="tab" onclick="showTab('ongoing')">En Cours</button>
            <button class="tab" onclick="showTab('created')">Créées</button>
            <button class="tab" onclick="showTab('friends')">Amis</button>
          </div>

          <!-- Tab Contents -->

          <!-- Activities Tab -->
          <div id="activities" class="tab-content active">
            <div class="profile__section">
              <h2 class="profile__section-title">
                Activités Passées
                <span
                  style="
                    color: var(--text-gray);
                    font-size: 1rem;
                    font-weight: 400;
                  "
                  >12</span
                >
              </h2>
              <div class="activities-grid">
                <div class="activity-card">
                  <div
                    class="activity-card__image"
                    style="
                      background: linear-gradient(135deg, #e6f7ff, #cceeff);
                      position: relative;
                    "
                  >
                    <span class="activity-card__status completed"
                      >Terminée</span
                    >
                  </div>
                  <div class="activity-card__content">
                    <h3 class="activity-card__title">Atelier peinture</h3>
                    <p class="activity-card__meta">
                      15 déc 2024 • 14 participants
                    </p>
                    <button class="activity-card__button">Voir détails</button>
                  </div>
                </div>

                <div class="activity-card">
                  <div
                    class="activity-card__image"
                    style="
                      background: linear-gradient(135deg, #fff4e6, #ffe8cc);
                      position: relative;
                    "
                  >
                    <span class="activity-card__status completed"
                      >Terminée</span
                    >
                  </div>
                  <div class="activity-card__content">
                    <h3 class="activity-card__title">Randonnée en forêt</h3>
                    <p class="activity-card__meta">
                      10 déc 2024 • 8 participants
                    </p>
                    <button class="activity-card__button">Voir détails</button>
                  </div>
                </div>

                <div class="activity-card">
                  <div
                    class="activity-card__image"
                    style="
                      background: linear-gradient(135deg, #f0fff3, #d9ffe6);
                      position: relative;
                    "
                  >
                    <span class="activity-card__status completed"
                      >Terminée</span
                    >
                  </div>
                  <div class="activity-card__content">
                    <h3 class="activity-card__title">Yoga en plein air</h3>
                    <p class="activity-card__meta">
                      5 déc 2024 • 20 participants
                    </p>
                    <button class="activity-card__button">Voir détails</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Ongoing Tab -->
          <div id="ongoing" class="tab-content">
            <div class="profile__section">
              <h2 class="profile__section-title">
                En Cours
                <span
                  style="
                    color: var(--text-gray);
                    font-size: 1rem;
                    font-weight: 400;
                  "
                  >2</span
                >
              </h2>
              <div class="activities-grid">
                <div class="activity-card">
                  <div
                    class="activity-card__image"
                    style="
                      background: linear-gradient(135deg, #e6f7ff, #cceeff);
                      position: relative;
                    "
                  >
                    <span class="activity-card__status ongoing">En cours</span>
                  </div>
                  <div class="activity-card__content">
                    <h3 class="activity-card__title">Balade à vélo</h3>
                    <p class="activity-card__meta">
                      20 déc 2024 • 5 participants
                    </p>
                    <button class="activity-card__button">Voir détails</button>
                  </div>
                </div>

                <div class="activity-card">
                  <div
                    class="activity-card__image"
                    style="
                      background: linear-gradient(135deg, #fff4e6, #ffe8cc);
                      position: relative;
                    "
                  >
                    <span class="activity-card__status ongoing">En cours</span>
                  </div>
                  <div class="activity-card__content">
                    <h3 class="activity-card__title">Cours de danse</h3>
                    <p class="activity-card__meta">
                      22 déc 2024 • 12 participants
                    </p>
                    <button class="activity-card__button">Voir détails</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Created Tab -->
          <div id="created" class="tab-content">
            <div class="profile__section">
              <h2 class="profile__section-title">
                Activités Créées
                <span
                  style="
                    color: var(--text-gray);
                    font-size: 1rem;
                    font-weight: 400;
                  "
                  >3</span
                >
              </h2>
              <div class="activities-grid">
                <div class="activity-card">
                  <div
                    class="activity-card__image"
                    style="
                      background: linear-gradient(135deg, #f0fff3, #d9ffe6);
                      position: relative;
                    "
                  >
                    <span class="activity-card__status created">Créée</span>
                  </div>
                  <div class="activity-card__content">
                    <h3 class="activity-card__title">Atelier sculpture</h3>
                    <p class="activity-card__meta">28 déc 2024 • 10 places</p>
                    <button class="activity-card__button">Gérer</button>
                  </div>
                </div>

                <div class="activity-card">
                  <div
                    class="activity-card__image"
                    style="
                      background: linear-gradient(135deg, #e6f7ff, #cceeff);
                      position: relative;
                    "
                  >
                    <span class="activity-card__status created">Créée</span>
                  </div>
                  <div class="activity-card__content">
                    <h3 class="activity-card__title">Randonnée montagne</h3>
                    <p class="activity-card__meta">02 jan 2025 • 20 places</p>
                    <button class="activity-card__button">Gérer</button>
                  </div>
                </div>

                <div class="activity-card">
                  <div
                    class="activity-card__image"
                    style="
                      background: linear-gradient(135deg, #fff4e6, #ffe8cc);
                      position: relative;
                    "
                  >
                    <span class="activity-card__status created">Créée</span>
                  </div>
                  <div class="activity-card__content">
                    <h3 class="activity-card__title">Dégustation culinaire</h3>
                    <p class="activity-card__meta">05 jan 2025 • 15 places</p>
                    <button class="activity-card__button">Gérer</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Friends Tab -->
          <div id="friends" class="tab-content">
            <div class="profile__section">
              <h2 class="profile__section-title">
                Mes Amis
                <span
                  style="
                    color: var(--text-gray);
                    font-size: 1rem;
                    font-weight: 400;
                  "
                  >127</span
                >
              </h2>
              <div
                style="
                  display: grid;
                  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                  gap: 1.5rem;
                "
              >
                <div
                  style="
                    background: var(--white);
                    border-radius: 15px;
                    padding: 1.5rem;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                    text-align: center;
                  "
                >
                  <div style="font-size: 3rem; margin-bottom: 1rem">👩</div>
                  <h3
                    style="
                      font-weight: 600;
                      color: var(--primary-dark);
                      margin-bottom: 0.5rem;
                    "
                  >
                    Marie L.
                  </h3>
                  <p
                    style="
                      color: var(--text-gray);
                      font-size: 0.9rem;
                      margin-bottom: 1rem;
                    "
                  >
                    Active récemment
                  </p>
                  <button
                    class="btn btn--outline btn--small"
                    style="width: 100%"
                  >
                    Visiter le profil
                  </button>
                </div>

                <div
                  style="
                    background: var(--white);
                    border-radius: 15px;
                    padding: 1.5rem;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                    text-align: center;
                  "
                >
                  <div style="font-size: 3rem; margin-bottom: 1rem">👨</div>
                  <h3
                    style="
                      font-weight: 600;
                      color: var(--primary-dark);
                      margin-bottom: 0.5rem;
                    "
                  >
                    Pierre D.
                  </h3>
                  <p
                    style="
                      color: var(--primary-blue);
                      font-size: 0.9rem;
                      margin-bottom: 1rem;
                    "
                  >
                    ● En ligne
                  </p>
                  <button
                    class="btn btn--outline btn--small"
                    style="width: 100%"
                  >
                    Visiter le profil
                  </button>
                </div>

                <div
                  style="
                    background: var(--white);
                    border-radius: 15px;
                    padding: 1.5rem;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                    text-align: center;
                  "
                >
                  <div style="font-size: 3rem; margin-bottom: 1rem">👩</div>
                  <h3
                    style="
                      font-weight: 600;
                      color: var(--primary-dark);
                      margin-bottom: 0.5rem;
                    "
                  >
                    Sophie M.
                  </h3>
                  <p
                    style="
                      color: var(--text-gray);
                      font-size: 0.9rem;
                      margin-bottom: 1rem;
                    "
                  >
                    Il y a 1 jour
                  </p>
                  <button
                    class="btn btn--outline btn--small"
                    style="width: 100%"
                  >
                    Visiter le profil
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Stats Section -->
          <div
            style="
              background: var(--white);
              border-radius: 20px;
              padding: 2rem;
              box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
              margin-top: 3rem;
            "
          >
            <h2 class="profile__section-title">Mes Statistiques</h2>
            <div
              style="
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 2rem;
              "
            >
              <div style="text-align: center">
                <div
                  style="
                    font-size: 2.5rem;
                    font-weight: 700;
                    color: var(--primary-blue);
                    margin-bottom: 0.5rem;
                  "
                >
                  15
                </div>
                <div style="color: var(--text-gray); font-size: 0.95rem">
                  Activités participées
                </div>
              </div>
              <div style="text-align: center">
                <div
                  style="
                    font-size: 2.5rem;
                    font-weight: 700;
                    color: var(--primary-blue);
                    margin-bottom: 0.5rem;
                  "
                >
                  8
                </div>
                <div style="color: var(--text-gray); font-size: 0.95rem">
                  Activités créées
                </div>
              </div>
              <div style="text-align: center">
                <div
                  style="
                    font-size: 2.5rem;
                    font-weight: 700;
                    color: var(--primary-blue);
                    margin-bottom: 0.5rem;
                  "
                >
                  4.8
                </div>
                <div style="color: var(--text-gray); font-size: 0.95rem">
                  Note moyenne
                </div>
              </div>
              <div style="text-align: center">
                <div
                  style="
                    font-size: 2.5rem;
                    font-weight: 700;
                    color: var(--primary-blue);
                    margin-bottom: 0.5rem;
                  "
                >
                  127
                </div>
                <div style="color: var(--text-gray); font-size: 0.95rem">
                  Amis
                </div>
              </div>
              <div style="text-align: center">
                <div
                  style="
                    font-size: 2.5rem;
                    font-weight: 700;
                    color: var(--primary-blue);
                    margin-bottom: 0.5rem;
                  "
                >
                  23
                </div>
                <div style="color: var(--text-gray); font-size: 0.95rem">
                  Mois d'activité
                </div>
              </div>
              <div style="text-align: center">
                <div
                  style="
                    font-size: 2.5rem;
                    font-weight: 700;
                    color: var(--primary-blue);
                    margin-bottom: 0.5rem;
                  "
                >
                  5
                </div>
                <div style="color: var(--text-gray); font-size: 0.95rem">
                  Badges gagnés
                </div>
              </div>
            </div>
          </div>

          <!-- Badges Section -->
          <div
            style="
              background: var(--white);
              border-radius: 20px;
              padding: 2rem;
              box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
              margin-top: 3rem;
            "
          >
            <h2 class="profile__section-title">Badges et Récompenses</h2>
            <div
              style="
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 2rem;
              "
            >
              <div style="text-align: center">
                <div style="font-size: 3rem; margin-bottom: 1rem">🗻</div>
                <h3
                  style="
                    font-weight: 600;
                    color: var(--primary-dark);
                    margin-bottom: 0.5rem;
                  "
                >
                  Aventurier
                </h3>
                <p style="color: var(--text-gray); font-size: 0.9rem">
                  10 randonnées complétées
                </p>
              </div>
              <div style="text-align: center">
                <div style="font-size: 3rem; margin-bottom: 1rem">🎨</div>
                <h3
                  style="
                    font-weight: 600;
                    color: var(--primary-dark);
                    margin-bottom: 0.5rem;
                  "
                >
                  Créatif
                </h3>
                <p style="color: var(--text-gray); font-size: 0.9rem">
                  5 ateliers artistiques
                </p>
              </div>
              <div style="text-align: center">
                <div style="font-size: 3rem; margin-bottom: 1rem">🎭</div>
                <h3
                  style="
                    font-weight: 600;
                    color: var(--primary-dark);
                    margin-bottom: 0.5rem;
                  "
                >
                  Organisateur
                </h3>
                <p style="color: var(--text-gray); font-size: 0.9rem">
                  Créateur d'événements
                </p>
              </div>
              <div style="text-align: center">
                <div style="font-size: 3rem; margin-bottom: 1rem">♛</div>
                <h3
                  style="
                    font-weight: 600;
                    color: var(--primary-dark);
                    margin-bottom: 0.5rem;
                  "
                >
                  Légende
                </h3>
                <p style="color: var(--text-gray); font-size: 0.9rem">
                  50 activités (25 restantes)
                </p>
              </div>
              <div style="text-align: center">
                <div style="font-size: 3rem; margin-bottom: 1rem">★</div>
                <h3
                  style="
                    font-weight: 600;
                    color: var(--primary-dark);
                    margin-bottom: 0.5rem;
                  "
                >
                  Top Contributeur
                </h3>
                <p style="color: var(--text-gray); font-size: 0.9rem">
                  Noté 5 stars
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <?php include 'footer.php'; ?>

    <script>
      // Toggle user menu
      document
        .querySelector(".user-menu__trigger")
        .addEventListener("click", function () {
          const expanded = this.getAttribute("aria-expanded") === "true";
          this.setAttribute("aria-expanded", !expanded);
        });

      // Add scroll effect to navbar
      window.addEventListener("scroll", function () {
        const navbar = document.querySelector(".navbar");
        if (window.scrollY > 50) {
          navbar.classList.add("navbar--scrolled");
        } else {
          navbar.classList.remove("navbar--scrolled");
        }
      });

      // Tab switching
      function showTab(tabName) {
        // Hide all tabs
        const tabs = document.querySelectorAll(".tab-content");
        tabs.forEach((tab) => {
          tab.classList.remove("active");
        });

        // Remove active class from all buttons
        const buttons = document.querySelectorAll(".tab");
        buttons.forEach((btn) => {
          btn.classList.remove("active");
        });

        // Show selected tab
        document.getElementById(tabName).classList.add("active");

        // Add active class to clicked button
        event.target.classList.add("active");
      }
    </script>
  </body>
</html>
