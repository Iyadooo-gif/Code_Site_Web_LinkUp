<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Créer une Activité - LinkUp</title>
    <link rel="stylesheet" href="css/main2.css" />
    <link rel="stylesheet" href="css/create-activity.css" />
  </head>
  <body>
    <?php include 'header.php'; ?>
    <main>
      <section class="section">
        <div class="container">
          <h1 class="page-title">Créer une Nouvelle Activité</h1>

          <div class="create-layout">
            <!-- Left Sidebar -->
            <div class="create-sidebar">
              <h2 class="create-sidebar__title">Créer une<br />Nouvelle<br />Activité</h2>

              <ul class="create-steps">
                <li class="create-step create-step--active">
                  <span class="create-step__number">1</span>
                  <span>Informations</span>
                </li>
                <li class="create-step">
                  <span class="create-step__number">2</span>
                  <span>Détails</span>
                </li>
                <li class="create-step">
                  <span class="create-step__number">3</span>
                  <span>Lieu</span>
                </li>
                <li class="create-step">
                  <span class="create-step__number">4</span>
                  <span>Finalisation</span>
                </li>
              </ul>

              <div class="create-help">
                <h3 class="create-help__title">Besoin d'aide ?</h3>
                <p class="create-help__text">Découvrez nos conseils pour créer la meilleure activité possible</p>
              </div>
            </div>

            <!-- Right Form -->
            <div class="create-card">
              <form class="form">
                <!-- Section 1 -->
                <div class="create-block">
                  <div class="create-block__header">
                    <h2>Informations de Base</h2>
                    <p>Commencez par décrire les fondamentaux de votre activité</p>
                  </div>

                  <div class="form__group">
                    <label class="form__label">Titre de l'activité *</label>
                    <input
                      type="text"
                      class="form__input"
                      placeholder="Ex: Randonnée en montagne"
                      required
                    />
                  </div>

                  <div class="form__group">
                    <label class="form__label">Description *</label>
                    <textarea
                      class="form__textarea"
                      placeholder="Décrivez votre activité en détail..."
                      required
                    ></textarea>
                  </div>

                  <div class="create-grid-2">
                    <div class="form__group">
                      <label class="form__label">Catégorie *</label>
                      <select class="form-select" required>
                        <option value="">Sélectionner</option>
                        <option value="sport">Sport</option>
                        <option value="art">Art & Culture</option>
                        <option value="nature">Nature</option>
                      </select>
                    </div>
                    <div class="form__group">
                      <label class="form__label">Type *</label>
                      <select class="form-select" required>
                        <option value="">Sélectionner</option>
                        <option value="group">Groupe</option>
                        <option value="solo">Solo</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- Section 2 -->
                <div class="create-block">
                  <div class="create-block__header">
                    <h2>Détails Pratiques</h2>
                    <p>Définissez les conditions et équipements nécessaires</p>
                  </div>

                  <div class="create-grid-2">
                    <div class="form__group">
                      <label class="form__label">Date *</label>
                      <input type="date" class="form__input" required />
                    </div>
                    <div class="form__group">
                      <label class="form__label">Heure *</label>
                      <input type="time" class="form__input" required />
                    </div>
                  </div>

                  <div class="create-grid-2" style="margin-top: 1.5rem">
                    <div class="form__group">
                      <label class="form__label">Durée estimée *</label>
                      <input
                        type="text"
                        class="form__input"
                        placeholder="Ex: 3 heures"
                        required
                      />
                    </div>
                    <div class="form__group">
                      <label class="form__label">Participants max *</label>
                      <input
                        type="number"
                        class="form__input"
                        placeholder="20"
                        required
                      />
                    </div>
                  </div>

                  <div class="form__group" style="margin-top: 1.5rem">
                    <label class="form__label">Équipements</label>
                    <textarea
                      class="form__textarea"
                      placeholder="Listez les équipements..."
                      style="min-height: 80px"
                    ></textarea>
                  </div>

                  <div class="create-grid-2" style="margin-top: 1.5rem">
                    <div class="form__group">
                      <label class="form__label">Niveau *</label>
                      <select class="form-select" required>
                        <option value="">Sélectionner</option>
                        <option value="facile">Facile</option>
                        <option value="moyen">Moyen</option>
                        <option value="difficile">Difficile</option>
                      </select>
                    </div>
                    <div class="form__group">
                      <label class="form__label">Prix par personne *</label>
                      <input
                        type="number"
                        class="form__input"
                        placeholder="0"
                        step="0.01"
                      />
                    </div>
                  </div>

                  <!-- Tags Section -->
                  <div class="form__group" style="margin-top: 1.5rem">
                    <label class="form__label">Tags/Mots-clés</label>
                    <div class="tag-input-row">
                      <input
                        type="text"
                        id="tag-input"
                        class="form__input"
                        placeholder="Ajouter un tag et appuyer sur Entrée"
                      />
                      <button type="button" id="tag-add-btn" class="btn btn--secondary">
                        Ajouter
                      </button>
                    </div>
                    <div id="selected-tags" class="tag-list"></div>
                    <input type="hidden" id="tags-hidden" />
                  </div>
                </div>

                <!-- Section 3 -->
                <div class="create-block">
                  <div class="create-block__header">
                    <h2>Lieu et Accès</h2>
                    <p>Indiquez où et comment rejoindre votre activité</p>
                  </div>

                  <div class="form__group">
                    <label class="form__label">Adresse *</label>
                    <input
                      type="text"
                      class="form__input"
                      placeholder="Ex: 10 Rue de la Paix, 75000 Paris"
                      required
                    />
                  </div>

                  <div class="form__group" style="margin-top: 1.5rem">
                    <label class="form__label">Informations d'accès</label>
                    <textarea
                      class="form__textarea"
                      placeholder="Transports, parking..."
                      style="min-height: 80px"
                    ></textarea>
                  </div>
                </div>

                <!-- Section 4 -->
                <div class="create-block">
                  <div class="create-block__header">
                    <h2>Finalisation</h2>
                    <p>Ajoutez une photo et vérifiez avant publication</p>
                  </div>

                  <div class="form__group">
                    <label class="form__label">Photo de couverture</label>
                    <input type="file" class="form__input" accept="image/*" />
                  </div>

                  <div class="form__checkbox">
                    <label>
                      <input type="checkbox" required />
                      <span>Je certifie que les informations sont exactes</span>
                    </label>
                  </div>
                </div>

                <!-- Summary -->
                <div class="create-summary">
                  <h3 class="create-summary__title">Récapitulatif</h3>
                  <div class="create-summary__grid">
                    <div>
                      <span class="create-summary__label">Titre</span>
                      <p class="create-summary__value">-</p>
                    </div>
                    <div>
                      <span class="create-summary__label">Date & Heure</span>
                      <p class="create-summary__value">-</p>
                    </div>
                    <div>
                      <span class="create-summary__label">Lieu</span>
                      <p class="create-summary__value">-</p>
                    </div>
                    <div>
                      <span class="create-summary__label">Prix</span>
                      <p class="create-summary__value">-</p>
                    </div>
                  </div>
                </div>

                <!-- Buttons -->
                <div class="create-actions">
                  <button type="button" class="btn btn--outline">
                    Précédent
                  </button>
                  <button type="button" class="btn btn--secondary">
                    Suivant
                  </button>
                  <button type="submit" class="btn btn--secondary">
                    Publier
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </main>
    <?php include 'footer.php'; ?>
    <script src="js/create-activity.js"></script>
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
