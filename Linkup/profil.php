<?php
require_once 'config.php';

// 1. VÉRIFICATION DE LA SESSION (Est-ce que l'utilisateur est connecté ?)
if (!isset($_SESSION['user_id'])) {
    // Si pas connecté, on redirige vers la page de connexion
    header('Location: login.php');
    exit;
}

// 2. RÉCUPÉRATION DE L'ID DE L'UTILISATEUR CONNECTÉ
$id_user = $_SESSION['user_id'];

// ======================================
// RÉCUPÉRER LES DONNÉES UTILISATEUR
// ======================================
// On utilise des valeurs par défaut (COALESCE ou vérification PHP) pour éviter les bugs si les champs sont vides
$stmt = $pdo->prepare("
    SELECT 
        id_user,
        nom,
        prenom,
        email,
        localisation,
        interets,
        photo_profil,
        note_moyenne_createur,
        date_inscription
    FROM utilisateur 
    WHERE id_user = ?
");
$stmt->execute([$id_user]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Cas rare : l'utilisateur est en session mais supprimé de la BDD
    session_destroy();
    header('Location: login.php');
    exit;
}

// Gestion de la photo de profil par défaut si vide
$user_avatar = !empty($user['photo_profil']) ? $user['photo_profil'] : 'images/avatar-placeholder.svg';

// ======================================
// STATISTIQUES (Avec gestion d'erreurs si les tables n'existent pas encore)
// ======================================
try {
    // Nombre total d'activités participées
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM participation WHERE id_user = ? AND statut = 'inscrit'");
    $stmt->execute([$id_user]);
    $total_activities = $stmt->fetch()['count'];

    // Nombre d'activités créées
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM activite WHERE id_createur = ?");
    $stmt->execute([$id_user]);
    $created_activities = $stmt->fetch()['count'];

    // Nombre d'amis
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM contact WHERE (id_user = ? OR id_destinataire = ?) AND statut = 'ami'");
    $stmt->execute([$id_user, $id_user]);
    $friends_count = $stmt->fetch()['count'];
} catch (PDOException $e) {
    // Si les tables n'existent pas encore, on met 0 pour ne pas casser la page
    $total_activities = 0;
    $created_activities = 0;
    $friends_count = 0;
}

// Note moyenne
$note_moyenne = $user['note_moyenne_createur'] ?? 5.0; // 5.0 par défaut pour faire joli au début

// ======================================
// RÉCUPÉRATION DES LISTES (Activités, Amis...)
// ======================================
$past_activities = [];
$ongoing_activities = [];
$created_activities_list = [];
$friends = [];

try {
    // Activités passées
    $stmt = $pdo->prepare("
        SELECT a.*, COUNT(p.id_user) as participants
        FROM activite a
        INNER JOIN participation p ON a.id_activite = p.id_activite
        WHERE p.id_user = ? AND a.date_heure < NOW() AND p.statut = 'inscrit'
        GROUP BY a.id_activite
        ORDER BY a.date_heure DESC LIMIT 5
    ");
    $stmt->execute([$id_user]);
    $past_activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Activités à venir (En cours)
    $stmt = $pdo->prepare("
        SELECT a.*, COUNT(p.id_user) as participants
        FROM activite a
        INNER JOIN participation p ON a.id_activite = p.id_activite
        WHERE p.id_user = ? AND a.date_heure >= NOW() AND p.statut = 'inscrit'
        GROUP BY a.id_activite
        ORDER BY a.date_heure ASC LIMIT 5
    ");
    $stmt->execute([$id_user]);
    $ongoing_activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Activités créées
    $stmt = $pdo->prepare("
        SELECT a.*, COUNT(p.id_user) as participants_inscrits
        FROM activite a
        LEFT JOIN participation p ON a.id_activite = p.id_activite AND p.statut = 'inscrit'
        WHERE a.id_createur = ?
        GROUP BY a.id_activite
        ORDER BY a.date_heure DESC LIMIT 5
    ");
    $stmt->execute([$id_user]);
    $created_activities_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Tables manquantes, on laisse les tableaux vides
}

// Fonction pour formater la date
function formatDateFr($date) {
    if (!$date) return '';
    $mois = ['', 'jan', 'fév', 'mar', 'avr', 'mai', 'juin', 'juil', 'août', 'sep', 'oct', 'nov', 'déc'];
    $timestamp = strtotime($date);
    return date('d', $timestamp) . ' ' . $mois[(int)date('m', $timestamp)] . ' ' . date('Y', $timestamp);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil - <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?> - LinkUp</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <section class="section">
            <div class="container">

                <div class="profile__header">
                    <div class="profile__avatar">
                        <img src="<?php echo htmlspecialchars($user_avatar); ?>"
                            alt="<?php echo htmlspecialchars($user['prenom']); ?>"
                            style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;" />
                        <button class="profile__edit-avatar">Modifier</button>
                    </div>

                    <div class="profile__info">
                        <h1 class="profile__title"><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></h1>
                        <p class="profile__bio">
                            <?php echo !empty($user['interets']) ? htmlspecialchars($user['interets']) : "Passionné d'aventure et de découvertes. Membre depuis " . date('Y', strtotime($user['date_inscription'])); ?>
                        </p>

                        <div class="profile__stats">
                            <div class="stat">
                                <span class="stat__number"><?php echo $total_activities; ?></span>
                                <span class="stat__label">Activités</span>
                            </div>
                            <div class="stat">
                                <span class="stat__number"><?php echo $created_activities; ?></span>
                                <span class="stat__label">Créées</span>
                            </div>
                            <div class="stat">
                                <span class="stat__number"><?php echo number_format($note_moyenne, 1); ?></span>
                                <span class="stat__label">Note</span>
                            </div>
                        </div>

                        <div class="profile__actions">
                            <button class="btn btn--secondary" onclick="window.location.href='create-activity.php'">Créer une Activité</button>
                            <button class="btn btn--outline" onclick="window.location.href='settings.php'">Modifier le profil</button>
                        </div>
                    </div>
                </div>

                <div class="profile__tabs">
                    <button class="tab active" onclick="showTab('activities')">Activités Passées</button>
                    <button class="tab" onclick="showTab('ongoing')">En Cours</button>
                    <button class="tab" onclick="showTab('created')">Créées</button>
                    <button class="tab" onclick="showTab('friends')">Amis</button>
                </div>

                <div id="activities" class="tab-content active">
                    <div class="profile__section">
                        <h2 class="profile__section-title">Activités Passées</h2>
                        <div class="activities-grid">
                            <?php if (empty($past_activities)): ?>
                                <p style="color: var(--text-gray);">Vous n'avez pas encore participé à des activités passées.</p>
                            <?php else: ?>
                                <?php foreach ($past_activities as $activity): ?>
                                    <div class="activity-card">
                                        <div class="activity-card__image" style="background-image: url('<?php echo !empty($activity['image_couverture']) ? htmlspecialchars($activity['image_couverture']) : 'images/acceuil_app.jpg'; ?>');">
                                            <span class="activity-card__status completed">Terminée</span>
                                        </div>
                                        <div class="activity-card__content">
                                            <h3 class="activity-card__title"><?php echo htmlspecialchars($activity['titre']); ?></h3>
                                            <p class="activity-card__meta">
                                                <?php echo formatDateFr($activity['date_heure']); ?> • <?php echo $activity['participants']; ?> participants
                                            </p>
                                            <button class="activity-card__button">Voir détails</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div id="ongoing" class="tab-content">
                    <div class="profile__section">
                        <h2 class="profile__section-title">Activités à venir</h2>
                        <div class="activities-grid">
                            <?php if (empty($ongoing_activities)): ?>
                                <p style="color: var(--text-gray);">Aucune activité prévue pour le moment.</p>
                            <?php else: ?>
                                <?php foreach ($ongoing_activities as $activity): ?>
                                    <div class="activity-card">
                                        <div class="activity-card__image" style="background-image: url('<?php echo !empty($activity['image_couverture']) ? htmlspecialchars($activity['image_couverture']) : 'images/boardgame.jpg'; ?>');">
                                            <span class="activity-card__status ongoing">Bientôt</span>
                                        </div>
                                        <div class="activity-card__content">
                                            <h3 class="activity-card__title"><?php echo htmlspecialchars($activity['titre']); ?></h3>
                                            <p class="activity-card__meta">
                                                <?php echo formatDateFr($activity['date_heure']); ?> • <?php echo $activity['participants']; ?> participants
                                            </p>
                                            <button class="activity-card__button">Voir détails</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div id="created" class="tab-content">
                    <div class="profile__section">
                        <h2 class="profile__section-title">Vos créations</h2>
                        <div class="activities-grid">
                            <?php if (empty($created_activities_list)): ?>
                                <p style="color: var(--text-gray);">Vous n'avez pas encore créé d'activité.</p>
                            <?php else: ?>
                                <?php foreach ($created_activities_list as $activity): ?>
                                    <div class="activity-card">
                                        <div class="activity-card__image" style="background-image: url('<?php echo !empty($activity['image_couverture']) ? htmlspecialchars($activity['image_couverture']) : 'images/img_morning_run_app.jpg'; ?>');">
                                            <span class="activity-card__status created">Créée</span>
                                        </div>
                                        <div class="activity-card__content">
                                            <h3 class="activity-card__title"><?php echo htmlspecialchars($activity['titre']); ?></h3>
                                            <p class="activity-card__meta">
                                                <?php echo formatDateFr($activity['date_heure']); ?> • <?php echo $activity['participants_inscrits']; ?> inscrits
                                            </p>
                                            <button class="activity-card__button">Gérer</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div id="friends" class="tab-content">
                    <div class="profile__section">
                        <h2 class="profile__section-title">Mes Amis</h2>
                        <p style="color: var(--text-gray);">Fonctionnalité amis à venir...</p>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

    <script>
      // Script pour gérer les onglets (Tabs)
        function showTab(tabName) {
        // Cacher tous les contenus
        const contents = document.querySelectorAll('.tab-content');
        contents.forEach(content => content.classList.remove('active'));
        
        // Désactiver tous les boutons
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => tab.classList.remove('active'));
        
        // Activer le contenu demandé
        document.getElementById(tabName).classList.add('active');
        
        // Activer le bouton cliqué (On cherche le bouton qui a l'onclick correspondant)
        // Note: une façon simple est de passer 'this' dans la fonction, mais ici on fait simple :
        const activeBtn = Array.from(document.querySelectorAll('.tab')).find(btn => btn.getAttribute('onclick').includes(tabName));
        if(activeBtn) activeBtn.classList.add('active');
        }
    </script>
</body>
</html>