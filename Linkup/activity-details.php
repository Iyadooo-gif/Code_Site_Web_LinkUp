<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Randonnée en montagne - LinkUp</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <?php include 'header.php'; ?>
    <!-- Main Content -->
    <main>
      <section class="section">
        <div class="container">
          <!-- Activity Header -->
          <div
            style="
              display: grid;
              grid-template-columns: 1fr 1fr;
              gap: 3rem;
              margin-bottom: 3rem;
            "
          >
            <!-- Left: Image & Info -->
            <div>
              <div
                style="
                  background: linear-gradient(135deg, #e6f7ff, #cceeff);
                  height: 300px;
                  border-radius: 20px;
                  margin-bottom: 2rem;
                "
              ></div>

              <div
                style="
                  background: var(--white);
                  border-radius: 20px;
                  padding: 2rem;
                  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
                "
              >
                <h1
                  style="
                    font-size: 2rem;
                    font-weight: 600;
                    color: var(--primary-dark);
                    margin-bottom: 1.5rem;
                  "
                >
                  Randonnée en montagne
                </h1>

                <div
                  style="
                    display: flex;
                    flex-direction: column;
                    gap: 1rem;
                    margin-bottom: 2rem;
                  "
                >
                  <div style="display: flex; align-items: center; gap: 1rem">
                    <span style="font-size: 1.3rem"></span>
                    <div>
                      <p
                        style="
                          font-size: 0.9rem;
                          color: var(--text-gray);
                          margin: 0;
                        "
                      >
                        Date
                      </p>
                      <p
                        style="
                          font-size: 1rem;
                          font-weight: 600;
                          color: var(--primary-dark);
                          margin: 0;
                        "
                      >
                        Samedi 21 Décembre 2025
                      </p>
                    </div>
                  </div>

                  <div style="display: flex; align-items: center; gap: 1rem">
                    <span style="font-size: 1.3rem"></span>
                    <div>
                      <p
                        style="
                          font-size: 0.9rem;
                          color: var(--text-gray);
                          margin: 0;
                        "
                      >
                        Durée
                      </p>
                      <p
                        style="
                          font-size: 1rem;
                          font-weight: 600;
                          color: var(--primary-dark);
                          margin: 0;
                        "
                      >
                        4 heures
                      </p>
                    </div>
                  </div>

                  <div style="display: flex; align-items: center; gap: 1rem">
                    <span style="font-size: 1.3rem"></span>
                    <div>
                      <p
                        style="
                          font-size: 0.9rem;
                          color: var(--text-gray);
                          margin: 0;
                        "
                      >
                        Lieu
                      </p>
                      <p
                        style="
                          font-size: 1rem;
                          font-weight: 600;
                          color: var(--primary-dark);
                          margin: 0;
                        "
                      >
                        Massif des Alpes, France
                      </p>
                    </div>
                  </div>

                  <div style="display: flex; align-items: center; gap: 1rem">
                    <span style="font-size: 1.3rem"></span>
                    <div>
                      <p
                        style="
                          font-size: 0.9rem;
                          color: var(--text-gray);
                          margin: 0;
                        "
                      >
                        Participants
                      </p>
                      <p
                        style="
                          font-size: 1rem;
                          font-weight: 600;
                          color: var(--primary-dark);
                          margin: 0;
                        "
                      >
                        15/20 inscrits
                      </p>
                    </div>
                  </div>

                  <div style="display: flex; align-items: center; gap: 1rem">
                    <span style="font-size: 1.3rem"></span>
                    <div>
                      <p
                        style="
                          font-size: 0.9rem;
                          color: var(--text-gray);
                          margin: 0;
                        "
                      >
                        Prix
                      </p>
                      <p
                        style="
                          font-size: 1rem;
                          font-weight: 600;
                          color: var(--primary-dark);
                          margin: 0;
                        "
                      >
                        25 € par personne
                      </p>
                    </div>
                  </div>

                  <div style="display: flex; align-items: center; gap: 1rem">
                    <span style="font-size: 1.3rem"></span>
                    <div>
                      <p
                        style="
                          font-size: 0.9rem;
                          color: var(--text-gray);
                          margin: 0;
                        "
                      >
                        Niveau
                      </p>
                      <p
                        style="
                          font-size: 1rem;
                          font-weight: 600;
                          color: var(--primary-dark);
                          margin: 0;
                        "
                      >
                        Intermédiaire
                      </p>
                    </div>
                  </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1rem">
                  <a
                    href="#"
                    class="btn btn--secondary"
                    style="display: block; text-align: center"
                  >
                    S'inscrire à l'activité
                  </a>
                  <a
                    href="index.html"
                    class="btn btn--secondary"
                    style="display: block; text-align: center"
                  >
                    Retour à l'accueil
                  </a>
                </div>
              </div>
            </div>

            <!-- Right: Organizer & Details -->
            <div>
              <!-- Organizer Card -->
              <div
                style="
                  background: var(--white);
                  border-radius: 20px;
                  padding: 2rem;
                  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
                  margin-bottom: 2rem;
                "
              >
                <h2
                  style="
                    font-size: 1.25rem;
                    font-weight: 600;
                    color: var(--primary-dark);
                    margin-bottom: 1.5rem;
                  "
                >
                  Organisateur
                </h2>

                <div
                  style="
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                    margin-bottom: 1.5rem;
                  "
                >
                  <div style="font-size: 3rem">👨</div>
                  <div>
                    <h3
                      style="
                        font-weight: 600;
                        color: var(--primary-dark);
                        margin: 0;
                      "
                    >
                      Marc Dubois
                    </h3>
                    <p
                      style="
                        color: var(--text-gray);
                        font-size: 0.9rem;
                        margin: 0;
                      "
                    >
                      Guide de montagne certifié
                    </p>
                  </div>
                </div>

                <p
                  style="
                    color: var(--text-gray);
                    font-size: 0.95rem;
                    line-height: 1.6;
                    margin-bottom: 1.5rem;
                  "
                >
                  Marc est un guide de montagne passionné avec plus de 15 ans
                  d'expérience. Il adore partager sa connaissance des Alpes avec
                  les randonneurs de tous niveaux.
                </p>

                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem">
                  <div
                    style="
                      flex: 1;
                      text-align: center;
                      padding: 1rem;
                      background: var(--bg-light);
                      border-radius: 12px;
                    "
                  >
                    <p
                      style="
                        font-size: 1.5rem;
                        font-weight: 700;
                        color: var(--primary-blue);
                        margin: 0;
                      "
                    >
                      4.9
                    </p>
                    <p
                      style="
                        color: var(--text-gray);
                        font-size: 0.85rem;
                        margin: 0;
                      "
                    >
                      Note moyenne
                    </p>
                  </div>
                  <div
                    style="
                      flex: 1;
                      text-align: center;
                      padding: 1rem;
                      background: var(--bg-light);
                      border-radius: 12px;
                    "
                  >
                    <p
                      style="
                        font-size: 1.5rem;
                        font-weight: 700;
                        color: var(--primary-blue);
                        margin: 0;
                      "
                    >
                      42
                    </p>
                    <p
                      style="
                        color: var(--text-gray);
                        font-size: 0.85rem;
                        margin: 0;
                      "
                    >
                      Activités
                    </p>
                  </div>
                </div>

                <a
                  href="profil.html"
                  class="btn btn--outline"
                  style="display: block; text-align: center"
                >
                  Voir le profil
                </a>
              </div>

              <!-- Activity Details -->
              <div
                style="
                  background: var(--white);
                  border-radius: 20px;
                  padding: 2rem;
                  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
                "
              >
                <h2
                  style="
                    font-size: 1.25rem;
                    font-weight: 600;
                    color: var(--primary-dark);
                    margin-bottom: 1.5rem;
                  "
                >
                  Rendez-vous
                </h2>

                <div
                  style="
                    background: var(--bg-light);
                    border-radius: 12px;
                    padding: 1.5rem;
                  "
                >
                  <h3
                    style="
                      font-weight: 600;
                      color: var(--primary-dark);
                      margin-bottom: 0.5rem;
                    "
                  >
                    Point de rendez-vous
                  </h3>
                  <p style="color: var(--text-gray); margin-bottom: 1rem">
                    Parking du Col de la Madeleine
                  </p>
                  <p
                    style="
                      color: var(--text-gray);
                      font-size: 0.9rem;
                      margin-bottom: 1rem;
                    "
                  >
                    73440 Les Belleville, France
                  </p>

                  <p
                    style="
                      font-size: 0.85rem;
                      font-weight: 600;
                      color: var(--text-gray);
                      margin-bottom: 0.5rem;
                    "
                  >
                    Coordonnées GPS :
                  </p>
                  <p
                    style="
                      color: var(--primary-blue);
                      font-size: 0.9rem;
                      font-weight: 500;
                      margin: 0;
                    "
                  >
                    45.4017° N, 6.5589° E
                  </p>
                </div>

                <div style="margin-top: 1.5rem">
                  <h3
                    style="
                      font-weight: 600;
                      color: var(--primary-dark);
                      margin-bottom: 0.5rem;
                    "
                  >
                    Heure de rendez-vous
                  </h3>
                  <p
                    style="
                      color: var(--primary-dark);
                      font-size: 1.1rem;
                      font-weight: 600;
                      margin: 0;
                    "
                  >
                    9h00
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Description Section -->
          <div
            style="
              background: var(--white);
              border-radius: 20px;
              padding: 2rem;
              box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
              margin-bottom: 3rem;
            "
          >
            <h2
              style="
                font-size: 1.5rem;
                font-weight: 600;
                color: var(--primary-dark);
                margin-bottom: 1.5rem;
              "
            >
              Description de l'activité
            </h2>

            <p
              style="
                color: var(--text-gray);
                line-height: 1.8;
                margin-bottom: 1.5rem;
              "
            >
              Rejoignez-nous pour une magnifique randonnée dans le massif des
              Alpes ! Cette sortie de 4 heures vous permettra de découvrir des
              paysages à couper le souffle, des sommets enneigés et une
              biodiversité exceptionnelle.
            </p>

            <p
              style="
                color: var(--text-gray);
                line-height: 1.8;
                margin-bottom: 1.5rem;
              "
            >
              Le parcours, accessible à tous niveaux, serpente à travers des
              forêts de pins et des alpages fleuris. Vous serez accompagnés par
              un guide expérimenté qui partagera avec vous son savoir sur la
              faune et la flore locales.
            </p>

            <h3
              style="
                font-size: 1.1rem;
                font-weight: 600;
                color: var(--primary-dark);
                margin-bottom: 1rem;
              "
            >
              Points forts :
            </h3>
            <ul
              style="
                color: var(--text-gray);
                line-height: 1.8;
                margin-bottom: 1.5rem;
                padding-left: 1.5rem;
              "
            >
              <li>Vue panoramique spectaculaire</li>
              <li>Pique-nique en altitude</li>
              <li>Découverte de la faune alpine</li>
              <li>Guidage professionnel</li>
            </ul>

            <h3
              style="
                font-size: 1.1rem;
                font-weight: 600;
                color: var(--primary-dark);
                margin-bottom: 1rem;
              "
            >
              Ce qu'il faut apporter :
            </h3>
            <ul
              style="
                color: var(--text-gray);
                line-height: 1.8;
                margin-bottom: 0;
                padding-left: 1.5rem;
              "
            >
              <li>Chaussures de randonnée</li>
              <li>Vêtements chauds et imperméables</li>
              <li>Eau (au moins 1.5L)</li>
              <li>Collation énergétique</li>
              <li>Protection solaire</li>
            </ul>
          </div>

          <!-- Participants Section -->
          <div
            style="
              background: var(--white);
              border-radius: 20px;
              padding: 2rem;
              box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
              margin-bottom: 3rem;
            "
          >
            <h2
              style="
                font-size: 1.5rem;
                font-weight: 600;
                color: var(--primary-dark);
                margin-bottom: 1.5rem;
              "
            >
              Participants
              <span
                style="
                  color: var(--text-gray);
                  font-size: 1rem;
                  font-weight: 400;
                "
                >(15/20)</span
              >
            </h2>

            <div
              style="
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 1.5rem;
              "
            >
              <div
                style="
                  text-align: center;
                  padding: 1rem;
                  background: var(--bg-light);
                  border-radius: 12px;
                "
              >
                <div style="font-size: 2.5rem; margin-bottom: 0.5rem">👤</div>
                <p
                  style="
                    font-weight: 600;
                    color: var(--primary-dark);
                    margin: 0;
                    font-size: 0.9rem;
                  "
                >
                  Sophie M.
                </p>
                <p
                  style="color: var(--text-gray); font-size: 0.85rem; margin: 0"
                >
                  Confirmé
                </p>
              </div>

              <div
                style="
                  text-align: center;
                  padding: 1rem;
                  background: var(--bg-light);
                  border-radius: 12px;
                "
              >
                <div style="font-size: 2.5rem; margin-bottom: 0.5rem">👤</div>
                <p
                  style="
                    font-weight: 600;
                    color: var(--primary-dark);
                    margin: 0;
                    font-size: 0.9rem;
                  "
                >
                  Thomas P.
                </p>
                <p
                  style="color: var(--text-gray); font-size: 0.85rem; margin: 0"
                >
                  Débutant
                </p>
              </div>

              <div
                style="
                  text-align: center;
                  padding: 1rem;
                  background: var(--bg-light);
                  border-radius: 12px;
                "
              >
                <div style="font-size: 2.5rem; margin-bottom: 0.5rem">👤</div>
                <p
                  style="
                    font-weight: 600;
                    color: var(--primary-dark);
                    margin: 0;
                    font-size: 0.9rem;
                  "
                >
                  Léa D.
                </p>
                <p
                  style="color: var(--text-gray); font-size: 0.85rem; margin: 0"
                >
                  Intermédiaire
                </p>
              </div>

              <div
                style="
                  text-align: center;
                  padding: 1rem;
                  background: var(--bg-light);
                  border-radius: 12px;
                  opacity: 0.5;
                "
              >
                <div style="font-size: 2rem">+12</div>
                <p
                  style="color: var(--text-gray); font-size: 0.85rem; margin: 0"
                >
                  Autres participants
                </p>
              </div>
            </div>
          </div>

          <!-- Reviews Section -->
          <div
            style="
              background: var(--white);
              border-radius: 20px;
              padding: 2rem;
              box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
              margin-bottom: 3rem;
            "
          >
            <h2
              style="
                font-size: 1.5rem;
                font-weight: 600;
                color: var(--primary-dark);
                margin-bottom: 1.5rem;
              "
            >
              Avis
              <span
                style="
                  color: var(--text-gray);
                  font-size: 1rem;
                  font-weight: 400;
                "
                >(4.9/5)</span
              >
            </h2>

            <div style="display: flex; flex-direction: column; gap: 1.5rem">
              <div
                style="
                  padding: 1.5rem;
                  background: var(--bg-light);
                  border-radius: 12px;
                "
              >
                <div
                  style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 0.5rem;
                  "
                >
                  <h3
                    style="
                      font-weight: 600;
                      color: var(--primary-dark);
                      margin: 0;
                    "
                  >
                    Sophie M.
                  </h3>
                  <span style="color: #f59e0b; font-size: 0.9rem">★★★★★</span>
                </div>
                <p
                  style="
                    color: var(--text-gray);
                    font-size: 0.9rem;
                    margin-bottom: 0.5rem;
                  "
                >
                  Il y a 1 semaine
                </p>
                <p style="color: var(--text-gray); line-height: 1.6; margin: 0">
                  Une expérience extraordinaire ! Marc est un excellent guide et
                  très bienveillant. Les paysages étaient magnifiques.
                </p>
              </div>

              <div
                style="
                  padding: 1.5rem;
                  background: var(--bg-light);
                  border-radius: 12px;
                "
              >
                <div
                  style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 0.5rem;
                  "
                >
                  <h3
                    style="
                      font-weight: 600;
                      color: var(--primary-dark);
                      margin: 0;
                    "
                  >
                    Thomas P.
                  </h3>
                  <span style="color: #f59e0b; font-size: 0.9rem">★★★★★</span>
                </div>
                <p
                  style="
                    color: var(--text-gray);
                    font-size: 0.9rem;
                    margin-bottom: 0.5rem;
                  "
                >
                  Il y a 3 jours
                </p>
                <p style="color: var(--text-gray); line-height: 1.6; margin: 0">
                  Parfait pour débuter ! L'ambiance était super conviviale et
                  j'ai appris plein de choses sur la montagne.
                </p>
              </div>
            </div>
          </div>

          <!-- CTA Section -->
          <div
            style="
              background: linear-gradient(135deg, var(--primary-dark), #0b2740);
              border-radius: 20px;
              padding: 3rem;
              text-align: center;
              color: var(--white);
            "
          >
            <h2 style="font-size: 2rem; font-weight: 600; margin-bottom: 1rem">
              Prêt à rejoindre l'aventure ?
            </h2>
            <p style="font-size: 1.1rem; opacity: 0.9; margin-bottom: 2rem">
              Inscrivez-vous maintenant et vivez une expérience inoubliable !
            </p>
            <a
              href="#"
              class="btn btn--secondary"
              style="display: inline-block"
            >
              S'inscrire maintenant
            </a>
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
    </script>
  </body>
</html>
