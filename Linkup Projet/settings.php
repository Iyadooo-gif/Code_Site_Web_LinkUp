<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Réglages - LinkUp</title>
    <link rel="stylesheet" href="css/main2.css" />
  </head>
  <body>
  <?php include 'header.php'; ?>
    <!-- Hero Section -->
    <section class="settings-hero">
      <div class="settings-hero__content">
        <h1 class="settings-hero__title">Préférences</h1>
        <p class="settings-hero__subtitle">
          Personnalisez votre expérience LinkUp
        </p>
      </div>
    </section>

    <!-- Main Content -->
    <main>
      <div class="settings__container">
        <!-- Notifications Settings -->
        <div class="settings-card">
          <div class="settings-card__header">
            <div class="settings-card__icon">🔔</div>
            <div>
              <h2 class="settings-card__title">Notifications</h2>
              <p class="settings-card__description">
                Gérez vos préférences de notifications
              </p>
            </div>
          </div>
          <div class="settings-card__content">
            <div class="notification-group">
              <h3>Notifications Importantes</h3>
              <div class="notification-item">
                <div class="notification-info">
                  <label class="notification-label"
                    >Fonctionnement de la plateforme</label
                  >
                  <p class="notification-description">
                    Notifications importantes sur le fonctionnement
                  </p>
                </div>
                <label class="toggle">
                  <input type="checkbox" checked />
                  <span class="toggle-slider"></span>
                </label>
              </div>
              <div class="notification-item">
                <div class="notification-info">
                  <label class="notification-label">Offres spéciales</label>
                  <p class="notification-description">
                    Conseils et actualités LinkUp
                  </p>
                </div>
                <label class="toggle">
                  <input type="checkbox" checked />
                  <span class="toggle-slider"></span>
                </label>
              </div>
              <div class="notification-item">
                <div class="notification-info">
                  <label class="notification-label"
                    >Modifications d'activités</label
                  >
                  <p class="notification-description">
                    Changements dans les activités auxquelles vous participez
                  </p>
                </div>
                <label class="toggle">
                  <input type="checkbox" checked />
                  <span class="toggle-slider"></span>
                </label>
              </div>
            </div>

            <div
              class="notification-group"
              style="
                margin-top: 2rem;
                border-top: 1px solid var(--bg-light);
                padding-top: 2rem;
              "
            >
              <h3>Canaux de Communication</h3>
              <div class="notification-item">
                <div class="notification-info">
                  <label class="notification-label">SMS Critiques</label>
                  <p class="notification-description">
                    Alertes importantes sur vos activités
                  </p>
                </div>
                <label class="toggle">
                  <input type="checkbox" />
                  <span class="toggle-slider"></span>
                </label>
              </div>
              <div class="notification-item">
                <div class="notification-info">
                  <label class="notification-label">Notifications in-app</label>
                  <p class="notification-description">
                    Messages dans l'application
                  </p>
                </div>
                <label class="toggle">
                  <input type="checkbox" checked />
                  <span class="toggle-slider"></span>
                </label>
              </div>
              <div class="notification-item">
                <div class="notification-info">
                  <label class="notification-label"
                    >Notifications en temps réel</label
                  >
                  <p class="notification-description">
                    Alertes instantanées sur les activités
                  </p>
                </div>
                <label class="toggle">
                  <input type="checkbox" checked />
                  <span class="toggle-slider"></span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <!-- Participation Settings -->
        <div class="settings-card">
          <div class="settings-card__header">
            <div class="settings-card__icon">👥</div>
            <div>
              <h2 class="settings-card__title">Participation</h2>
              <p class="settings-card__description">
                Contrôlez comment vous participez aux activités
              </p>
            </div>
          </div>
          <div class="settings-card__content">
            <div class="participation-settings">
              <div class="participation-item">
                <div class="participation-info">
                  <label class="participation-label"
                    >Approbation de l'organisateur</label
                  >
                  <p class="participation-description">
                    Les organisateurs doivent approuver votre participation
                  </p>
                </div>
                <label class="toggle">
                  <input type="checkbox" />
                  <span class="toggle-slider"></span>
                </label>
              </div>
              <div class="participation-item">
                <div class="participation-info">
                  <label class="participation-label"
                    >Visibilité des activités</label
                  >
                  <p class="participation-description">
                    Comment vos activités sont visibles par défaut
                  </p>
                </div>
                <select class="form-select" style="max-width: 200px">
                  <option value="public">Public</option>
                  <option value="friends">Amis seulement</option>
                  <option value="private">Privé</option>
                </select>
              </div>
              <div class="participation-item">
                <div class="participation-info">
                  <label class="participation-label"
                    >Invitations directes</label
                  >
                  <p class="participation-description">
                    Permettre aux autres utilisateurs de vous inviter
                  </p>
                </div>
                <label class="toggle">
                  <input type="checkbox" checked />
                  <span class="toggle-slider"></span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <!-- Security Settings -->
        <div class="settings-card">
          <div class="settings-card__header">
            <div class="settings-card__icon">🔒</div>
            <div>
              <h2 class="settings-card__title">Sécurité</h2>
              <p class="settings-card__description">
                Protégez votre compte et vos données
              </p>
            </div>
          </div>
          <div class="settings-card__content">
            <div class="security-settings">
              <div class="security-action">
                <div class="security-action__info">
                  <h3>Authentification à deux facteurs</h3>
                  <p>Dernière modification : il y a 3 mois</p>
                </div>
                <div class="security-status">
                  <span
                    class="security-status__badge security-status__badge--inactive"
                    >Inactif</span
                  >
                  <button class="btn btn--secondary btn--small">Activer</button>
                </div>
              </div>

              <div class="security-action">
                <div class="security-action__info">
                  <h3>Sessions connectées</h3>
                  <p>Gérez vos sessions actives</p>
                </div>
                <button class="btn btn--outline btn--small">Gérer</button>
              </div>

              <div class="security-action">
                <div class="security-action__info">
                  <h3>Changement de mot de passe</h3>
                  <p>Renforcez la sécurité avec un nouveau mot de passe</p>
                </div>
                <button class="btn btn--outline btn--small">Changer</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Privacy Settings -->
        <div class="settings-card">
          <div class="settings-card__header">
            <div class="settings-card__icon">🔐</div>
            <div>
              <h2 class="settings-card__title">Confidentialité</h2>
              <p class="settings-card__description">
                Gérez vos données personnelles
              </p>
            </div>
          </div>
          <div class="settings-card__content">
            <div class="privacy-settings">
              <div class="privacy-action">
                <div class="privacy-action__info">
                  <h3>Télécharger vos données</h3>
                  <p>Téléchargez une copie de toutes vos données</p>
                </div>
                <button class="btn btn--outline btn--small">Télécharger</button>
              </div>

              <div class="privacy-action">
                <div class="privacy-action__info">
                  <h3>Politique de confidentialité</h3>
                  <p>Lisez notre politique de confidentialité</p>
                </div>
                <button class="btn btn--outline btn--small">Consulter</button>
              </div>

              <div class="privacy-action privacy-action--danger">
                <div class="privacy-action__info">
                  <h3>Supprimer mon compte</h3>
                  <p>Cette action est irréversible</p>
                </div>
                <button class="btn btn--danger btn--small">Supprimer</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Language & Regional Settings -->
        <div class="settings-card">
          <div class="settings-card__header">
            <div class="settings-card__icon">🌐</div>
            <div>
              <h2 class="settings-card__title">Langue & Région</h2>
              <p class="settings-card__description">
                Personnalisez votre expérience linguistique
              </p>
            </div>
          </div>
          <div class="settings-card__content">
            <div class="language-settings">
              <div class="language-item">
                <div class="language-info">
                  <label class="language-label">Langue d'affichage</label>
                  <p class="language-description">
                    Choisissez votre langue préférée
                  </p>
                </div>
                <select class="form-select" style="max-width: 150px">
                  <option value="fr">Français</option>
                  <option value="en">English</option>
                  <option value="es">Español</option>
                  <option value="de">Deutsch</option>
                </select>
              </div>

              <div class="language-item">
                <div class="language-info">
                  <label class="language-label">Format des dates</label>
                  <p class="language-description">
                    Choisissez le format d'affichage
                  </p>
                </div>
                <select class="form-select" style="max-width: 150px">
                  <option value="dd/mm/yyyy">JJ/MM/AAAA</option>
                  <option value="mm/dd/yyyy">MM/JJ/AAAA</option>
                  <option value="yyyy-mm-dd">AAAA-MM-JJ</option>
                </select>
              </div>

              <div class="language-item">
                <div class="language-info">
                  <label class="language-label">Format des heures</label>
                  <p class="language-description">
                    Choisissez le format d'affichage
                  </p>
                </div>
                <select class="form-select" style="max-width: 150px">
                  <option value="24h">24 heures</option>
                  <option value="12h">12 heures</option>
                </select>
              </div>

              <div class="language-item">
                <div class="language-info">
                  <label class="language-label">Fuseau horaire</label>
                  <p class="language-description">Votre fuseau horaire local</p>
                </div>
                <select class="form-select" style="max-width: 250px">
                  <option value="paris">Europe/Paris (UTC+1)</option>
                  <option value="london">Europe/London (UTC+0)</option>
                  <option value="tokyo">Asia/Tokyo (UTC+9)</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- Appearance Settings -->
        <div class="settings-card">
          <div class="settings-card__header">
            <div class="settings-card__icon">🎨</div>
            <div>
              <h2 class="settings-card__title">Apparence</h2>
              <p class="settings-card__description">
                Personnalisez l'apparence de l'application
              </p>
            </div>
          </div>
          <div class="settings-card__content">
            <div class="appearance-settings">
              <h3 style="margin-bottom: 1.5rem">
                Choisissez votre thème préféré
              </h3>
              <div class="theme-selector">
                <label class="theme-option">
                  <input type="radio" name="theme" value="light" checked />
                  <div class="theme-preview theme-preview--light">
                    <div class="theme-preview__icon">☀️</div>
                    <div>Mode clair</div>
                  </div>
                </label>
                <label class="theme-option">
                  <input type="radio" name="theme" value="dark" />
                  <div class="theme-preview theme-preview--dark">
                    <div class="theme-preview__icon">🌙</div>
                    <div>Mode sombre</div>
                  </div>
              </div>
            </div>
            <!-- Save Button -->
            <div class="settings-actions">
              <button class="btn btn--outline">Annuler</button>
              <button class="btn btn--secondary">
                Enregistrer les modifications
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>

    <?php include 'footer.php'; ?>

    <script>
      document
        .querySelector(".user-menu__trigger")
        .addEventListener("click", function () {
          const expanded = this.getAttribute("aria-expanded") === "true";
          this.setAttribute("aria-expanded", !expanded);
        });

      window.addEventListener("scroll", function () {
        const navbar = document.querySelector(".navbar");
        if (window.scrollY > 50) {
          navbar.classList.add("navbar--scrolled");
        } else {
          navbar.classList.remove("navbar--scrolled");
        }
      });
    </script>
  </body>
</html>
