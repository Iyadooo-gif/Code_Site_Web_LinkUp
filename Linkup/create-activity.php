<?php


// Connexion à la base de données via PDO
require_once 'config.php';

// SÉCURITÉ : Redirection si l'utilisateur n'est pas connecté
// Cela évite l'erreur SQL de clé étrangère (Integrity constraint violation)
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fonction pour sécuriser l'affichage des données (évite les failles XSS)
function h($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

// ============================================================
// INITIALISATION DES VARIABLES
// ============================================================
$errors = [];
$successMessage = '';

$title = $description = $category = $tagsInput = $dateEvt = $timeEvt = '';
$duration = $equipment = $level = $address = $accessInfo = '';
$maxParticipants = 0;
$price = 0;

// ============================================================
// TRAITEMENT DU FORMULAIRE (POST)
// ============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? ''); 
    $tagsInput = trim($_POST['tags'] ?? '');    
    $dateEvt = trim($_POST['date_evt'] ?? '');
    $timeEvt = trim($_POST['time_evt'] ?? '');
    $duration = trim($_POST['duration'] ?? '');
    $maxParticipants = (int)($_POST['max_participants'] ?? 0);
    $equipment = trim($_POST['equipment'] ?? '');
    $level = trim($_POST['level'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $address = trim($_POST['address'] ?? '');
    $accessInfo = trim($_POST['access_info'] ?? '');

    if ($title === '') { $errors[] = 'Le titre est requis.'; }
    if ($category === '') { $errors[] = 'La catégorie est requise.'; }
    if ($dateEvt === '' || $timeEvt === '') { $errors[] = 'La date et l\'heure sont requises.'; }
    if ($address === '') { $errors[] = 'L\'adresse est requise.'; }

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            $datetime_complet = $dateEvt . ' ' . $timeEvt . ':00';

            $stmtCat = $pdo->prepare("SELECT id_type FROM type_activite WHERE nom_du_type = ?");
            $stmtCat->execute([$category]);
            $id_type = $stmtCat->fetchColumn();

            if (!$id_type) {
                throw new Exception("Catégorie invalide. Veuillez sélectionner une catégorie existante.");
            }

            // Utilisation de l'ID réel de l'utilisateur connecté
            $id_createur = $_SESSION['user_id'];

            $sqlInsert = "INSERT INTO activite 
                (id_createur, id_type, titre, description, date_heure, duree, lieu, nb_place, equipements, niveau, prix, acces_info, statut) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'ouvert')";
            
            $stmt = $pdo->prepare($sqlInsert);
            $stmt->execute([
                $id_createur, $id_type, $title, $description, $datetime_complet,
                $duration, $address, $maxParticipants, $equipment, $level, $price, $accessInfo
            ]);

            $id_activite = $pdo->lastInsertId();

            if (!empty($tagsInput)) {
                $tagsArray = explode(',', $tagsInput); 
                foreach ($tagsArray as $tagName) {
                    $tagName = trim($tagName);
                    if ($tagName === '') continue;

                    $stmtTag = $pdo->prepare("INSERT IGNORE INTO tag (nom_tag) VALUES (?)");
                    $stmtTag->execute([$tagName]);

                    $stmtGetTag = $pdo->prepare("SELECT id_tag FROM tag WHERE nom_tag = ?");
                    $stmtGetTag->execute([$tagName]);
                    $id_tag = $stmtGetTag->fetchColumn();

                    if ($id_tag) {
                        $stmtLink = $pdo->prepare("INSERT IGNORE INTO activite_tag (id_activite, id_tag) VALUES (?, ?)");
                        $stmtLink->execute([$id_activite, $id_tag]);
                    }
                }
            }

            $pdo->commit();
            $successMessage = 'Activité publiée avec succès !';
            
            // Réinitialisation après succès
            $title = $description = $category = $tagsInput = $dateEvt = $timeEvt = '';
            $duration = $equipment = $level = $address = $accessInfo = '';
            $maxParticipants = $price = 0;

        } catch (Exception $e) {
            if ($pdo->inTransaction()) { $pdo->rollBack(); }
            $errors[] = 'Erreur lors de l\'enregistrement : ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Créer une Activité - LinkUp</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="css/create-activity.css?v=<?php echo time(); ?>" />
  </head>
  <body>
    <?php include 'header.php'; ?>
    <main>
      <section class="section">
        <div class="container">
          <h1 class="page-title">Créer une Nouvelle Activité</h1>

          <?php if ($successMessage): ?>
          <div class="alert alert--success"><?php echo h($successMessage); ?></div>
          <?php endif; ?>

          <?php if (!empty($errors)): ?>
          <div class="alert alert--error">
            <?php foreach ($errors as $error): ?>
              <p><?php echo h($error); ?></p>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

          <div class="create-layout">
            <aside class="create-sidebar">
              <h2 class="create-sidebar__title">Créer une<br />Nouvelle<br />Activité</h2>
              <ul class="create-steps">
                <li class="create-step create-step--active"><span class="create-step__number">1</span><span>Informations</span></li>
                <li class="create-step"><span class="create-step__number">2</span><span>Détails</span></li>
                <li class="create-step"><span class="create-step__number">3</span><span>Lieu</span></li>
                <li class="create-step"><span class="create-step__number">4</span><span>Finalisation</span></li>
              </ul>
            </aside>

            <div class="create-card">
              <form class="form" method="post" action="create-activity.php">
                <div class="create-block">
                  <div class="create-block__header">
                    <h2>Informations de Base</h2>
                    <p>Commencez par décrire les fondamentaux de votre activité.</p>
                  </div>

                  <div class="form__group">
                    <label class="form__label" for="title">Titre de l'activité *</label>
                    <input type="text" id="title" name="title" class="form__input" placeholder="Ex: Randonnée en montagne" value="<?php echo h($title); ?>" required />
                  </div>

                  <div class="form__group">
                    <label class="form__label" for="description">Description *</label>
                    <textarea id="description" name="description" class="form__textarea" placeholder="Décrivez votre activité en détail..." required><?php echo h($description); ?></textarea>
                  </div>

                  <div class="create-grid-2">
                    <div class="form__group">
                      <label class="form__label" for="category">Catégorie *</label>
                      <select id="category" name="category" class="form-select" required>
                        <option value="">Sélectionner</option>
                        <option value="sport" <?php echo $category === 'sport' ? 'selected' : ''; ?>>Sport</option>
                        <option value="art" <?php echo $category === 'art' ? 'selected' : ''; ?>>Art & Culture</option>
                        <option value="nature" <?php echo $category === 'nature' ? 'selected' : ''; ?>>Nature</option>
                      </select>
                    </div>
                    <div class="form__group">
                      <label class="form__label">Tags</label>
                      <div class="tag-input-row">
                        <input type="text" class="form__input" id="tag-input" placeholder="Rechercher un tag" />
                        <button type="button" id="tag-add-btn" class="btn btn--secondary">Ajouter</button>
                      </div>
                      <div id="selected-tags" class="tag-list"></div>
                      <input type="hidden" name="tags" id="tags-hidden" value="<?php echo h($tagsInput); ?>" />
                    </div>
                  </div>
                </div>

                <div class="create-block">
                  <div class="create-block__header">
                    <h2>Détails Pratiques</h2>
                    <p>Définissez les conditions et équipements nécessaires.</p>
                  </div>
                  <div class="create-grid-2">
                    <div class="form__group">
                      <label class="form__label" for="date_evt">Date *</label>
                      <input type="date" id="date_evt" name="date_evt" class="form__input" value="<?php echo h($dateEvt); ?>" required />
                    </div>
                    <div class="form__group">
                      <label class="form__label" for="time_evt">Heure *</label>
                      <input type="time" id="time_evt" name="time_evt" class="form__input" value="<?php echo h($timeEvt); ?>" required />
                    </div>
                  </div>
                  <div class="create-grid-2">
                    <div class="form__group">
                      <label class="form__label" for="duration">Durée estimée *</label>
                      <input type="text" id="duration" name="duration" class="form__input" placeholder="Ex: 3 heures" value="<?php echo h($duration); ?>" required />
                    </div>
                    <div class="form__group">
                      <label class="form__label" for="max_participants">Participants max *</label>
                      <input type="number" id="max_participants" name="max_participants" class="form__input" placeholder="20" min="0" value="<?php echo h($maxParticipants); ?>" required />
                    </div>
                  </div>
                  <div class="form__group">
                    <label class="form__label" for="equipment">Équipements</label>
                    <textarea id="equipment" name="equipment" class="form__textarea" placeholder="Listez les équipements..." rows="3"><?php echo h($equipment); ?></textarea>
                  </div>
                  <div class="create-grid-2">
                    <div class="form__group">
                      <label class="form__label" for="level">Niveau *</label>
                      <select id="level" name="level" class="form-select" required>
                        <option value="">Sélectionner</option>
                        <option value="facile" <?php echo $level === 'facile' ? 'selected' : ''; ?>>Facile</option>
                        <option value="moyen" <?php echo $level === 'moyen' ? 'selected' : ''; ?>>Moyen</option>
                        <option value="difficile" <?php echo $level === 'difficile' ? 'selected' : ''; ?>>Difficile</option>
                      </select>
                    </div>
                    <div class="form__group">
                      <label class="form__label" for="price">Prix par personne *</label>
                      <input type="number" id="price" name="price" class="form__input" placeholder="0" step="0.01" min="0" value="<?php echo h($price); ?>" required />
                    </div>
                  </div>
                </div>

                <div class="create-block">
                  <div class="create-block__header">
                    <h2>Lieu et Accès</h2>
                  </div>
                  <div class="form__group">
                    <label class="form__label" for="address">Adresse *</label>
                    <input type="text" id="address" name="address" class="form__input" placeholder="Ex: 10 Rue de la Paix, 75000 Paris" value="<?php echo h($address); ?>" required />
                  </div>
                  <div class="form__group">
                    <label class="form__label" for="access_info">Informations d'accès</label>
                    <textarea id="access_info" name="access_info" class="form__textarea" placeholder="Transports, parking..." rows="3"><?php echo h($accessInfo); ?></textarea>
                  </div>
                </div>

                <div class="create-actions">
                  <button type="submit" class="btn btn--secondary">Publier l'activité</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </main>
    <?php include 'footer.php'; ?>
    <script src="js/script.js?v=<?php echo time(); ?>"></script>
    <script src="js/create-activity.js?v=<?php echo time(); ?>"></script>
  </body>
</html>