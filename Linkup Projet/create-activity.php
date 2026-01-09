<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Créer une Activité - LinkUp</title>
    <link rel="stylesheet" href="css/main2.css" />
  </head>
  <body>
    <?php include 'header.php'; ?>
    <main>
      <section class="section">
        <div class="container">
          <h1 class="page-title">Créer une Nouvelle Activité</h1>

          <div
            style="
              display: grid;
              grid-template-columns: 1fr 2fr;
              gap: 2rem;
              margin: 2rem 0;
            "
          >
            <!-- Left Sidebar -->
            <div
              style="
                background: linear-gradient(
                  135deg,
                  var(--primary-dark),
                  #0b2740
                );
                border-radius: 20px;
                padding: 2rem;
                color: white;
                height: fit-content;
              "
            >
              <h2
                style="
                  font-size: 2rem;
                  font-weight: 700;
                  text-align: center;
                  margin-bottom: 2rem;
                  line-height: 1.2;
                "
              >
                Créer une<br />Nouvelle<br />Activité
              </h2>

              <ul style="list-style: none; margin-bottom: 2rem">
                <li
                  style="
                    display: flex;
                    align-items: center;
                    margin-bottom: 1.5rem;
                    font-size: 1.05rem;
                    font-weight: 500;
                  "
                >
                  <span
                    style="
                      display: flex;
                      align-items: center;
                      justify-content: center;
                      width: 40px;
                      height: 40px;
                      background: var(--primary-blue);
                      border-radius: 50%;
                      margin-right: 1rem;
                      flex-shrink: 0;
                      font-weight: 600;
                      color: var(--primary-dark);
                    "
                    >1</span
                  >
                  <span>Informations</span>
                </li>
                <li
                  style="
                    display: flex;
                    align-items: center;
                    margin-bottom: 1.5rem;
                    font-size: 1.05rem;
                    font-weight: 500;
                  "
                >
                  <span
                    style="
                      display: flex;
                      align-items: center;
                      justify-content: center;
                      width: 40px;
                      height: 40px;
                      background: rgba(91, 196, 244, 0.3);
                      border-radius: 50%;
                      margin-right: 1rem;
                      flex-shrink: 0;
                      font-weight: 600;
                    "
                    >2</span
                  >
                  <span>Détails</span>
                </li>
                <li
                  style="
                    display: flex;
                    align-items: center;
                    margin-bottom: 1.5rem;
                    font-size: 1.05rem;
                    font-weight: 500;
                  "
                >
                  <span
                    style="
                      display: flex;
                      align-items: center;
                      justify-content: center;
                      width: 40px;
                      height: 40px;
                      background: rgba(91, 196, 244, 0.3);
                      border-radius: 50%;
                      margin-right: 1rem;
                      flex-shrink: 0;
                      font-weight: 600;
                    "
                    >3</span
                  >
                  <span>Lieu</span>
                </li>
                <li
                  style="
                    display: flex;
                    align-items: center;
                    margin-bottom: 1.5rem;
                    font-size: 1.05rem;
                    font-weight: 500;
                  "
                >
                  <span
                    style="
                      display: flex;
                      align-items: center;
                      justify-content: center;
                      width: 40px;
                      height: 40px;
                      background: rgba(91, 196, 244, 0.3);
                      border-radius: 50%;
                      margin-right: 1rem;
                      flex-shrink: 0;
                      font-weight: 600;
                    "
                    >4</span
                  >
                  <span>Finalisation</span>
                </li>
              </ul>

              <div
                style="
                  background: rgba(255, 255, 255, 0.1);
                  border-radius: 12px;
                  padding: 1.5rem;
                  margin-top: 2rem;
                "
              >
                <h3 style="margin-bottom: 0.75rem; font-size: 1rem">
                  Besoin d'aide ?
                </h3>
                <p
                  style="
                    font-size: 0.9rem;
                    line-height: 1.5;
                    opacity: 0.9;
                    margin: 0;
                  "
                >
                  Découvrez nos conseils pour créer la meilleure activité
                  possible
                </p>
              </div>
            </div>

            <!-- Right Form -->
            <div
              style="
                background: var(--white);
                border-radius: 20px;
                padding: 2rem;
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
              "
            >
              <form class="form">
                <!-- Section 1 -->
                <div style="margin-bottom: 2rem">
                  <h2
                    style="
                      font-size: 1.5rem;
                      font-weight: 600;
                      color: var(--primary-dark);
                      margin-bottom: 1rem;
                      padding-bottom: 1rem;
                      border-bottom: 2px solid var(--bg-light);
                    "
                  >
                    Informations de Base
                  </h2>
                  <p
                    style="
                      color: var(--text-gray);
                      font-size: 1rem;
                      margin-bottom: 1.5rem;
                    "
                  >
                    Commencez par décrire les fondamentaux de votre activité
                  </p>

                  <div class="form__group">
                    <label class="form__label">Titre de l'activité *</label>
                    <input
                      type="text"
                      class="form__input"
                      placeholder="Ex: Randonnée en montagne"
                      required
                    />
                  </div>

                  <div class="form__group" style="margin-top: 1.5rem">
                    <label class="form__label">Description *</label>
                    <textarea
                      class="form__textarea"
                      placeholder="Décrivez votre activité en détail..."
                      required
                    ></textarea>
                  </div>

                  <div
                    style="
                      display: grid;
                      grid-template-columns: 1fr 1fr;
                      gap: 1.5rem;
                      margin-top: 1.5rem;
                    "
                  >
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
                <div style="margin-bottom: 2rem">
                  <h2
                    style="
                      font-size: 1.5rem;
                      font-weight: 600;
                      color: var(--primary-dark);
                      margin-bottom: 1rem;
                      padding-bottom: 1rem;
                      border-bottom: 2px solid var(--bg-light);
                    "
                  >
                    Détails Pratiques
                  </h2>
                  <p
                    style="
                      color: var(--text-gray);
                      font-size: 1rem;
                      margin-bottom: 1.5rem;
                    "
                  >
                    Définissez les conditions et équipements nécessaires
                  </p>

                  <div
                    style="
                      display: grid;
                      grid-template-columns: 1fr 1fr;
                      gap: 1.5rem;
                    "
                  >
                    <div class="form__group">
                      <label class="form__label">Date *</label>
                      <input type="date" class="form__input" required />
                    </div>
                    <div class="form__group">
                      <label class="form__label">Heure *</label>
                      <input type="time" class="form__input" required />
                    </div>
                  </div>

                  <div
                    style="
                      display: grid;
                      grid-template-columns: 1fr 1fr;
                      gap: 1.5rem;
                      margin-top: 1.5rem;
                    "
                  >
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

                  <div
                    style="
                      display: grid;
                      grid-template-columns: 1fr 1fr;
                      gap: 1.5rem;
                      margin-top: 1.5rem;
                    "
                  >
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
                </div>

                <!-- Section 3 -->
                <div style="margin-bottom: 2rem">
                  <h2
                    style="
                      font-size: 1.5rem;
                      font-weight: 600;
                      color: var(--primary-dark);
                      margin-bottom: 1rem;
                      padding-bottom: 1rem;
                      border-bottom: 2px solid var(--bg-light);
                    "
                  >
                    Lieu et Accès
                  </h2>
                  <p
                    style="
                      color: var(--text-gray);
                      font-size: 1rem;
                      margin-bottom: 1.5rem;
                    "
                  >
                    Indiquez où et comment rejoindre votre activité
                  </p>

                  <div class="form__group">
                    <label class="form__label">Adresse *</label>
                    <input
                      type="text"
                      class="form__input"
                      placeholder="Ex: 10 Rue de la Paix, 75000 Paris"
                      required
                    />
                  </div>

                  <div
                    style="
                      display: grid;
                      grid-template-columns: 1fr 1fr;
                      gap: 1.5rem;
                      margin-top: 1.5rem;
                    "
                  ></div>

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
                <div style="margin-bottom: 2rem">
                  <h2
                    style="
                      font-size: 1.5rem;
                      font-weight: 600;
                      color: var(--primary-dark);
                      margin-bottom: 1rem;
                      padding-bottom: 1rem;
                      border-bottom: 2px solid var(--bg-light);
                    "
                  >
                    Finalisation
                  </h2>
                  <p
                    style="
                      color: var(--text-gray);
                      font-size: 1rem;
                      margin-bottom: 1.5rem;
                    "
                  >
                    Ajoutez une photo et vérifiez avant publication
                  </p>

                  <div class="form__group">
                    <label class="form__label">Photo de couverture</label>
                    <input type="file" class="form__input" accept="image/*" />
                  </div>

                  <div class="form__group" style="margin-top: 1.5rem">
                    <label
                      style="
                        display: flex;
                        align-items: center;
                        cursor: pointer;
                      "
                    >
                      <input
                        type="checkbox"
                        style="margin-right: 0.5rem; width: 18px; height: 18px"
                      />
                      <span style="font-weight: 500; color: var(--text-dark)"
                        >Je certifie que les informations sont exactes</span
                      >
                    </label>
                  </div>
                </div>

                <!-- Summary -->
                <div
                  style="
                    background: var(--bg-light);
                    border-radius: 15px;
                    padding: 1.5rem;
                    margin-bottom: 2rem;
                    border: 2px solid #e5e7eb;
                  "
                >
                  <h3
                    style="
                      font-size: 1.25rem;
                      font-weight: 600;
                      color: var(--primary-dark);
                      margin-bottom: 1.5rem;
                    "
                  >
                    Récapitulatif
                  </h3>
                  <div
                    style="
                      display: grid;
                      grid-template-columns: 1fr 1fr;
                      gap: 1.5rem;
                    "
                  >
                    <div>
                      <span
                        style="
                          font-size: 0.85rem;
                          font-weight: 600;
                          color: var(--text-gray);
                          text-transform: uppercase;
                        "
                        >Titre</span
                      >
                      <p
                        style="
                          font-size: 1.1rem;
                          font-weight: 600;
                          color: var(--primary-dark);
                          margin: 0.5rem 0 0 0;
                        "
                      >
                        -
                      </p>
                    </div>
                    <div>
                      <span
                        style="
                          font-size: 0.85rem;
                          font-weight: 600;
                          color: var(--text-gray);
                          text-transform: uppercase;
                        "
                        >Date & Heure</span
                      >
                      <p
                        style="
                          font-size: 1.1rem;
                          font-weight: 600;
                          color: var(--primary-dark);
                          margin: 0.5rem 0 0 0;
                        "
                      >
                        -
                      </p>
                    </div>
                    <div>
                      <span
                        style="
                          font-size: 0.85rem;
                          font-weight: 600;
                          color: var(--text-gray);
                          text-transform: uppercase;
                        "
                        >Lieu</span
                      >
                      <p
                        style="
                          font-size: 1.1rem;
                          font-weight: 600;
                          color: var(--primary-dark);
                          margin: 0.5rem 0 0 0;
                        "
                      >
                        -
                      </p>
                    </div>
                    <div>
                      <span
                        style="
                          font-size: 0.85rem;
                          font-weight: 600;
                          color: var(--text-gray);
                          text-transform: uppercase;
                        "
                        >Prix</span
                      >
                      <p
                        style="
                          font-size: 1.1rem;
                          font-weight: 600;
                          color: var(--primary-dark);
                          margin: 0.5rem 0 0 0;
                        "
                      >
                        -
                      </p>
                    </div>
                  </div>
                </div>

                <!-- Buttons -->
                <div style="display: flex; gap: 1rem; margin-top: 2rem">
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
