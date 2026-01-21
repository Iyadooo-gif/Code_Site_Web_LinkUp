<?php
require_once 'config.php';

// 1. VÉRIFICATION DE L'ID DE L'ACTIVITÉ
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Si pas d'ID, on redirige vers l'accueil
    header('Location: index.php');
    exit;
}

$id_activite = (int)$_GET['id'];
$id_user_connecte = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// 2. RÉCUPÉRATION DES DÉTAILS DE L'ACTIVITÉ + ORGANISATEUR
$stmt = $pdo->prepare("
    SELECT 
        a.*,
        u.nom AS host_nom,
        u.prenom AS host_prenom,
        u.photo_profil AS host_photo,
        u.note_moyenne_createur,
        (SELECT COUNT(*) FROM activite WHERE id_createur = u.id_user) as host_nb_activities
    FROM activite a
    JOIN utilisateur u ON a.id_createur = u.id_user
    WHERE a.id_activite = ?
");
$stmt->execute([$id_activite]);
$activity = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$activity) {
    die("Oups ! Cette activité n'existe pas ou a été supprimée.");
}

// 3. RÉCUPÉRATION DES PARTICIPANTS
$stmt = $pdo->prepare("
    SELECT u.id_user, u.prenom, u.nom, u.photo_profil, u.role
    FROM participation p
    JOIN utilisateur u ON p.id_user = u.id_user
    WHERE p.id_activite = ? AND p.statut = 'inscrit'
");
$stmt->execute([$id_activite]);
$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

$nb_inscrits = count($participants);
$places_restantes = $activity['nb_place'] - $nb_inscrits;
$is_complet = $places_restantes <= 0;

// Vérifier si l'utilisateur connecté est déjà inscrit
$is_registered = false;
if ($id_user_connecte) {
    foreach ($participants as $p) {
        if ($p['id_user'] == $id_user_connecte) {
            $is_registered = true;
            break;
        }
    }
}

// 4. FORMATAGE DE LA DATE (Français)
function formatDateComplete($date) {
    setlocale(LC_TIME, 'fr_FR.UTF8', 'fra');
    $timestamp = strtotime($date);
    // Fallback manuel si setlocale ne marche pas sur Windows/Wamp
    $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $mois = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    
    $jourSemaine = $jours[date('w', $timestamp)];
    $jour = date('d', $timestamp);
    $moisNom = $mois[(int)date('m', $timestamp)];
    $annee = date('Y', $timestamp);
    
    return "$jourSemaine $jour $moisNom $annee";
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($activity['titre']); ?> - LinkUp</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <?php include 'header.php'; ?>
    
    <main>
      <section class="section">
        <div class="container">
          
          <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem; margin-bottom: 3rem;">
            
            <div>
              <div
                style="
                  background-image: url('<?php echo !empty($activity['image_couverture']) ? htmlspecialchars($activity['image_couverture']) : 'images/default_activity.jpg'; ?>');
                  background-size: cover;
                  background-position: center;
                  height: 350px;
                  border-radius: 20px;
                  margin-bottom: 2rem;
                  position: relative;
                "
              >
                <?php if($is_registered): ?>
                    <span class="badge badge--verified" style="position: absolute; top: 20px; left: 20px; padding: 0.5rem 1rem;">Vous participez ✅</span>
                <?php endif; ?>
              </div>

              <div style="background: var(--white); border-radius: 20px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);">
                <h1 style="font-size: 2rem; font-weight: 600; color: var(--primary-dark); margin-bottom: 1.5rem;">
                  <?php echo htmlspecialchars($activity['titre']); ?>
                </h1>

                <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                  
                  <div style="display: flex; align-items: center; gap: 1rem">
                    <span style="font-size: 1.3rem">📅</span>
                    <div>
                      <p style="font-size: 0.9rem; color: var(--text-gray); margin: 0;">Date</p>
                      <p style="font-size: 1rem; font-weight: 600; color: var(--primary-dark); margin: 0;">
                        <?php echo formatDateComplete($activity['date_heure']); ?> à <?php echo date('H:i', strtotime($activity['date_heure'])); ?>
                      </p>
                    </div>
                  </div>

                  <div style="display: flex; align-items: center; gap: 1rem">
                    <span style="font-size: 1.3rem">⏱️</span>
                    <div>
                      <p style="font-size: 0.9rem; color: var(--text-gray); margin: 0;">Durée estimée</p>
                      <p style="font-size: 1rem; font-weight: 600; color: var(--primary-dark); margin: 0;">
                        <?php echo !empty($activity['duree']) ? htmlspecialchars($activity['duree']) : 'Non spécifiée'; ?>
                      </p>
                    </div>
                  </div>

                  <div style="display: flex; align-items: center; gap: 1rem">
                    <span style="font-size: 1.3rem">📍</span>
                    <div>
                      <p style="font-size: 0.9rem; color: var(--text-gray); margin: 0;">Lieu</p>
                      <p style="font-size: 1rem; font-weight: 600; color: var(--primary-dark); margin: 0;">
                        <?php echo htmlspecialchars($activity['lieu']); ?>
                      </p>
                    </div>
                  </div>

                  <div style="display: flex; align-items: center; gap: 1rem">
                    <span style="font-size: 1.3rem">👥</span>
                    <div>
                      <p style="font-size: 0.9rem; color: var(--text-gray); margin: 0;">Participants</p>
                      <p style="font-size: 1rem; font-weight: 600; color: var(--primary-dark); margin: 0;">
                        <?php echo $nb_inscrits; ?> / <?php echo $activity['nb_place']; ?> inscrits
                        <?php if($is_complet): ?>
                            <span style="color: #ef4444; font-size: 0.9rem;">(Complet)</span>
                        <?php else: ?>
                            <span style="color: #10b981; font-size: 0.9rem;">(<?php echo $places_restantes; ?> places restantes)</span>
                        <?php endif; ?>
                      </p>
                    </div>
                  </div>

                  <div style="display: flex; align-items: center; gap: 1rem">
                    <span style="font-size: 1.3rem">💶</span>
                    <div>
                      <p style="font-size: 0.9rem; color: var(--text-gray); margin: 0;">Prix</p>
                      <p style="font-size: 1rem; font-weight: 600; color: var(--primary-dark); margin: 0;">
                        <?php echo ($activity['prix'] > 0) ? htmlspecialchars($activity['prix']) . ' €' : 'Gratuit'; ?>
                      </p>
                    </div>
                  </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1rem">
                  <?php if (!$id_user_connecte): ?>
                      <a href="login.php" class="btn btn--secondary" style="display: block; text-align: center">
                        Connectez-vous pour participer
                      </a>
                  <?php elseif ($is_registered): ?>
                      <button class="btn btn--outline" disabled style="display: block; text-align: center; border-color: #10b981; color: #10b981;">
                        Vous êtes inscrit
                      </button>
                      <a href="process-desinscription.php?id=<?php echo $activity['id_activite']; ?>" style="text-align: center; color: #ef4444; font-size: 0.9rem; text-decoration: none;">Se désinscrire</a>
                  <?php elseif ($is_complet): ?>
                      <button class="btn btn--outline" disabled style="display: block; text-align: center; opacity: 0.5;">
                        Complet
                      </button>
                  <?php else: ?>
                      <a href="process-participation.php?id=<?php echo $activity['id_activite']; ?>" class="btn btn--secondary" style="display: block; text-align: center">
                        S'inscrire à l'activité
                      </a>
                  <?php endif; ?>
                  
                  <a href="index.php" class="btn btn--outline" style="display: block; text-align: center">
                    Retour à l'accueil
                  </a>
                </div>
              </div>

              <div style="background: var(--white); border-radius: 20px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); margin-top: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: var(--primary-dark); margin-bottom: 1.5rem;">
                  Description
                </h2>
                <div style="color: var(--text-gray); line-height: 1.8;">
                  <?php echo nl2br(htmlspecialchars($activity['description'])); ?>
                </div>
              </div>
            </div>

            <div>
              <div style="background: var(--white); border-radius: 20px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); margin-bottom: 2rem;">
                <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--primary-dark); margin-bottom: 1.5rem;">
                  Organisateur
                </h2>

                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                  <img 
                    src="<?php echo !empty($activity['host_photo']) ? htmlspecialchars($activity['host_photo']) : 'images/avatar-placeholder.svg'; ?>" 
                    alt="Host" 
                    style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;"
                  >
                  <div>
                    <h3 style="font-weight: 600; color: var(--primary-dark); margin: 0;">
                      <?php echo htmlspecialchars($activity['host_prenom'] . ' ' . $activity['host_nom']); ?>
                    </h3>
                    <p style="color: var(--text-gray); font-size: 0.9rem; margin: 0;">
                      Organisateur
                    </p>
                  </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem">
                  <div style="flex: 1; text-align: center; padding: 1rem; background: var(--bg-light); border-radius: 12px;">
                    <p style="font-size: 1.5rem; font-weight: 700; color: var(--primary-blue); margin: 0;">
                        <?php echo number_format($activity['note_moyenne_createur'] ?? 5.0, 1); ?>
                    </p>
                    <p style="color: var(--text-gray); font-size: 0.85rem; margin: 0;">Note</p>
                  </div>
                  <div style="flex: 1; text-align: center; padding: 1rem; background: var(--bg-light); border-radius: 12px;">
                    <p style="font-size: 1.5rem; font-weight: 700; color: var(--primary-blue); margin: 0;">
                        <?php echo $activity['host_nb_activities']; ?>
                    </p>
                    <p style="color: var(--text-gray); font-size: 0.85rem; margin: 0;">Activités</p>
                  </div>
                </div>

                <a href="profil.php?id=<?php echo $activity['id_createur']; ?>" class="btn btn--outline" style="display: block; text-align: center">
                  Voir le profil
                </a>
              </div>

              <div style="background: var(--white); border-radius: 20px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);">
                <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--primary-dark); margin-bottom: 1.5rem;">
                  Participants (<?php echo $nb_inscrits; ?>)
                </h2>

                <?php if (empty($participants)): ?>
                    <p style="color: var(--text-gray); font-size: 0.9rem;">Soyez le premier à vous inscrire !</p>
                <?php else: ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(60px, 1fr)); gap: 1rem;">
                        <?php foreach($participants as $participant): ?>
                            <div style="text-align: center;">
                                <img 
                                    src="<?php echo !empty($participant['photo_profil']) ? htmlspecialchars($participant['photo_profil']) : 'images/avatar-placeholder.svg'; ?>" 
                                    alt="Participant" 
                                    title="<?php echo htmlspecialchars($participant['prenom']); ?>"
                                    style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid var(--bg-light);"
                                >
                                <p style="font-size: 0.8rem; color: var(--text-gray); margin-top: 5px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?php echo htmlspecialchars($participant['prenom']); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
              </div>

            </div>
          </div>

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
              Ne manquez pas cette opportunité de rencontrer de nouvelles personnes.
            </p>
            <?php if (!$is_registered && !$is_complet && $id_user_connecte): ?>
                <a href="process-participation.php?id=<?php echo $activity['id_activite']; ?>" class="btn btn--secondary" style="display: inline-block">
                  S'inscrire maintenant
                </a>
            <?php endif; ?>
          </div>

        </div>
      </section>
    </main>
    <?php include 'footer.php'; ?>
  </body>
</html>