<?php
// ======================================
// CONFIGURATION & SESSION
// ======================================
session_start();

// Simuler un utilisateur connecté pour les tests
// EN PRODUCTION : vérifier que l'utilisateur est vraiment connecté
if (!isset($_SESSION['id_user'])) {
    $_SESSION['id_user'] = 1; // Pour les tests - Change cet ID selon ton utilisateur
}

$id_user = $_SESSION['id_user'];

// ======================================
// CONNEXION BASE DE DONNÉES
// ======================================
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=linkup_db;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// ======================================
// RÉCUPÉRER LES DONNÉES UTILISATEUR
// ======================================
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
    die("Utilisateur introuvable. Veuillez créer un utilisateur dans la table 'utilisateur'.");
}

// ======================================
// STATISTIQUES DE L'UTILISATEUR
// ======================================

// Nombre total d'activités participées
$stmt = $pdo->prepare("
    SELECT COUNT(*) as count 
    FROM participation 
    WHERE id_user = ? AND statut = 'inscrit'
");
$stmt->execute([$id_user]);
$total_activities = $stmt->fetch()['count'];

// Nombre d'activités créées
$stmt = $pdo->prepare("
    SELECT COUNT(*) as count 
    FROM activite 
    WHERE id_createur = ?
");
$stmt->execute([$id_user]);
$created_activities = $stmt->fetch()['count'];

// Nombre d'amis
$stmt = $pdo->prepare("
    SELECT COUNT(*) as count 
    FROM contact 
    WHERE (id_user = ? OR id_destinataire = ?) AND statut = 'ami'
");
$stmt->execute([$id_user, $id_user]);
$friends_count = $stmt->fetch()['count'];

// Note moyenne (depuis la table utilisateur)
$note_moyenne = $user['note_moyenne_createur'] ?? 0.0;

// ======================================
// RÉCUPÉRER LES ACTIVITÉS PAR CATÉGORIE
// ======================================

// Activités passées (terminées)
$stmt = $pdo->prepare("
    SELECT 
        a.id_activite,
        a.titre,
        a.description,
        a.date_heure,
        a.lieu,
        a.image_couverture,
        COUNT(p.id_user) as participants,
        t.nom_du_type
    FROM activite a
    INNER JOIN participation p ON a.id_activite = p.id_activite
    LEFT JOIN type_activite t ON a.id_type = t.id_type
    WHERE p.id_user = ? AND a.date_heure < NOW() AND p.statut = 'inscrit'
    GROUP BY a.id_activite
    ORDER BY a.date_heure DESC
    LIMIT 10
");
$stmt->execute([$id_user]);
$past_activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Activités en cours (à venir)
$stmt = $pdo->prepare("
    SELECT 
        a.id_activite,
        a.titre,
        a.description,
        a.date_heure,
        a.lieu,
        a.image_couverture,
        COUNT(p.id_user) as participants,
        t.nom_du_type
    FROM activite a
    INNER JOIN participation p ON a.id_activite = p.id_activite
    LEFT JOIN type_activite t ON a.id_type = t.id_type
    WHERE p.id_user = ? AND a.date_heure >= NOW() AND p.statut = 'inscrit'
    GROUP BY a.id_activite
    ORDER BY a.date_heure ASC
    LIMIT 10
");
$stmt->execute([$id_user]);
$ongoing_activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Activités créées par l'utilisateur
$stmt = $pdo->prepare("
    SELECT 
        a.id_activite,
        a.titre,
        a.description,
        a.date_heure,
        a.lieu,
        a.image_couverture,
        a.nb_place,
        a.statut,
        COUNT(p.id_user) as participants_inscrits,
        t.nom_du_type
    FROM activite a
    LEFT JOIN participation p ON a.id_activite = p.id_activite AND p.statut = 'inscrit'
    LEFT JOIN type_activite t ON a.id_type = t.id_type
    WHERE a.id_createur = ?
    GROUP BY a.id_activite
    ORDER BY a.date_heure DESC
    LIMIT 10
");
$stmt->execute([$id_user]);
$created_activities_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les amis
$stmt = $pdo->prepare("
    SELECT 
        u.id_user,
        u.nom,
        u.prenom,
        u.photo_profil,
        u.date_inscription
    FROM utilisateur u
    INNER JOIN contact c ON (
        (c.id_destinataire = u.id_user AND c.id_user = ?)
        OR (c.id_user = u.id_user AND c.id_destinataire = ?)
    )
    WHERE c.statut = 'ami'
    ORDER BY u.date_inscription DESC
    LIMIT 6
");
$stmt->execute([$id_user, $id_user]);
$friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fonction pour formater la date en français
function formatDateFr($date)
{
    $mois = ['', 'jan', 'fév', 'mar', 'avr', 'mai', 'juin', 'juil', 'août', 'sep', 'oct', 'nov', 'déc'];
    $d = new DateTime($date);
    return $d->format('d') . ' ' . $mois[(int) $d->format('m')] . ' ' . $d->format('Y');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil - <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?> - LinkUp</title>
    <link rel="stylesheet" href="css/main2.css" />
</head>

<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="navbar__container">
                <a href="index.html" class="logo">
                    <div class="logo__icon">
                        <img src="images/Logo.png" alt="LinkUp Logo" />
                    </div>
                </a>

                <ul class="nav">
                    <li class="nav__item"><a href="index.html" class="nav__link">Accueil</a></li>
                    <li class="nav__item"><a href="index.html#categorie" class="nav__link">Catégories</a></li>
                    <li class="nav__item"><a href="index.html#activites" class="nav__link">Activités</a></li>
                    <li class="nav__item"><a href="index.html#contact" class="nav__link">Contact</a></li>
                    <li class="nav__item"><a href="notifications.html" class="nav__link">Notifications</a></li>
                    <li class="nav__item"><a href="profil.php" class="nav__link nav__link--active">Profil</a></li>
                    <li class="nav__item"><a href="settings.html" class="nav__link">Réglages</a></li>
                </ul>

                <div class="navbar__actions">
                    <div class="user-menu">
                        <button class="user-menu__trigger" aria-expanded="false">
                            <div class="user-avatar">
                                <img src="<?php echo htmlspecialchars($user['photo_profil']); ?>" alt="Avatar"
                                    class="user-avatar__image" />
                            </div>
                            <span
                                class="user-menu__name"><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></span>
                            <svg class="user-menu__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                        </button>
                        <div class="user-menu__dropdown">
                            <a href="profil.php" class="user-menu__item user-menu__item--active">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Mon Profil
                            </a>
                            <a href="settings.html" class="user-menu__item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Paramètres
                            </a>
                            <div class="user-menu__divider"></div>
                            <a href="logout.php" class="user-menu__item user-menu__item--danger">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Déconnexion
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <section class="section">
            <div class="container">

                <!-- Profile Header - DYNAMIQUE -->
                <div class="profile__header">
                    <div class="profile__avatar">
                        <img src="<?php echo htmlspecialchars($user['photo_profil']); ?>"
                            alt="<?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?>"
                            style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;" />
                        <button class="profile__edit-avatar">Modifier</button>
                    </div>

                    <div class="profile__info">
                        <h1 class="profile__title"><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?>
                        </h1>
                        <p class="profile__bio">
                            <?php
                            if ($user['interets']) {
                                echo htmlspecialchars($user['interets']);
                            } else {
                                echo "Membre depuis " . date('Y', strtotime($user['date_inscription']));
                            }
                            ?>
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
                            <button class="btn btn--secondary"
                                onclick="window.location.href='create_activity.php'">Créer une Activité</button>
                            <button class="btn btn--outline">Inviter des Amis</button>
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="profile__tabs">
                    <button class="tab active" onclick="showTab('activities')">Activités Passées</button>
                    <button class="tab" onclick="showTab('ongoing')">En Cours</button>
                    <button class="tab" onclick="showTab('created')">Créées</button>
                    <button class="tab" onclick="showTab('friends')">Amis</button>
                </div>

                <!-- ONGLET 1: Activités Passées - DYNAMIQUE -->
                <div id="activities" class="tab-content active">
                    <div class="profile__section">
                        <h2 class="profile__section-title">
                            Activités Passées
                            <span style="color: var(--text-gray); font-size: 1rem; font-weight: 400;">
                                <?php echo count($past_activities); ?>
                            </span>
                        </h2>
                        <div class="activities-grid">
                            <?php if (empty($past_activities)): ?>
                                <p style="color: var(--text-gray); padding: 2rem;">Aucune activité passée</p>
                            <?php else: ?>
                                <?php foreach ($past_activities as $activity): ?>
                                    <div class="activity-card">
                                        <div class="activity-card__image"
                                            style="background: linear-gradient(135deg, #e6f7ff, #cceeff); position: relative;">
                                            <?php if ($activity['image_couverture'] && $activity['image_couverture'] != 'assets/img/default_activity.jpg'): ?>
                                                <img src="<?php echo htmlspecialchars($activity['image_couverture']); ?>"
                                                    alt="<?php echo htmlspecialchars($activity['titre']); ?>"
                                                    style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
                                            <?php endif; ?>
                                            <span class="activity-card__status completed">Terminée</span>
                                        </div>
                                        <div class="activity-card__content">
                                            <h3 class="activity-card__title"><?php echo htmlspecialchars($activity['titre']); ?>
                                            </h3>
                                            <p class="activity-card__meta">
                                                <?php echo formatDateFr($activity['date_heure']); ?> •
                                                <?php echo $activity['participants']; ?>
                                                participant<?php echo $activity['participants'] > 1 ? 's' : ''; ?>
                                            </p>
                                            <button class="activity-card__button"
                                                onclick="window.location.href='activity.php?id=<?php echo $activity['id_activite']; ?>'">
                                                Voir détails
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- ONGLET 2: En Cours - DYNAMIQUE -->
                <div id="ongoing" class="tab-content">
                    <div class="profile__section">
                        <h2 class="profile__section-title">
                            En Cours
                            <span style="color: var(--text-gray); font-size: 1rem; font-weight: 400;">
                                <?php echo count($ongoing_activities); ?>
                            </span>
                        </h2>
                        <div class="activities-grid">
                            <?php if (empty($ongoing_activities)): ?>
                                <p style="color: var(--text-gray); padding: 2rem;">Aucune activité en cours</p>
                            <?php else: ?>
                                <?php foreach ($ongoing_activities as $activity): ?>
                                    <div class="activity-card">
                                        <div class="activity-card__image"
                                            style="background: linear-gradient(135deg, #fff4e6, #ffe8cc); position: relative;">
                                            <?php if ($activity['image_couverture'] && $activity['image_couverture'] != 'assets/img/default_activity.jpg'): ?>
                                                <img src="<?php echo htmlspecialchars($activity['image_couverture']); ?>"
                                                    alt="<?php echo htmlspecialchars($activity['titre']); ?>"
                                                    style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
                                            <?php endif; ?>
                                            <span class="activity-card__status ongoing">En cours</span>
                                        </div>
                                        <div class="activity-card__content">
                                            <h3 class="activity-card__title"><?php echo htmlspecialchars($activity['titre']); ?>
                                            </h3>
                                            <p class="activity-card__meta">
                                                <?php echo formatDateFr($activity['date_heure']); ?> •
                                                <?php echo $activity['participants']; ?>
                                                participant<?php echo $activity['participants'] > 1 ? 's' : ''; ?>
                                            </p>
                                            <button class="activity-card__button"
                                                onclick="window.location.href='activity.php?id=<?php echo $activity['id_activite']; ?>'">
                                                Voir détails
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- ONGLET 3: Créées - DYNAMIQUE -->
                <div id="created" class="tab-content">
                    <div class="profile__section">
                        <h2 class="profile__section-title">
                            Activités Créées
                            <span style="color: var(--text-gray); font-size: 1rem; font-weight: 400;">
                                <?php echo count($created_activities_list); ?>
                            </span>
                        </h2>
                        <div class="activities-grid">
                            <?php if (empty($created_activities_list)): ?>
                                <p style="color: var(--text-gray); padding: 2rem;">Vous n'avez créé aucune activité</p>
                            <?php else: ?>
                                <?php foreach ($created_activities_list as $activity): ?>
                                    <div class="activity-card">
                                        <div class="activity-card__image"
                                            style="background: linear-gradient(135deg, #f0fff3, #d9ffe6); position: relative;">
                                            <?php if ($activity['image_couverture'] && $activity['image_couverture'] != 'assets/img/default_activity.jpg'): ?>
                                                <img src="<?php echo htmlspecialchars($activity['image_couverture']); ?>"
                                                    alt="<?php echo htmlspecialchars($activity['titre']); ?>"
                                                    style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
                                            <?php endif; ?>
                                            <span class="activity-card__status created">Créée</span>
                                        </div>
                                        <div class="activity-card__content">
                                            <h3 class="activity-card__title"><?php echo htmlspecialchars($activity['titre']); ?>
                                            </h3>
                                            <p class="activity-card__meta">
                                                <?php echo formatDateFr($activity['date_heure']); ?> •
                                                <?php echo $activity['participants_inscrits']; ?>/<?php echo $activity['nb_place'] ?? '∞'; ?>
                                                places
                                            </p>
                                            <button class="activity-card__button"
                                                onclick="window.location.href='manage_activity.php?id=<?php echo $activity['id_activite']; ?>'">
                                                Gérer
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- ONGLET 4: Amis - DYNAMIQUE -->
                <div id="friends" class="tab-content">
                    <div class="profile__section">
                        <h2 class="profile__section-title">
                            Mes Amis
                            <span style="color: var(--text-gray); font-size: 1rem; font-weight: 400;">
                                <?php echo $friends_count; ?>
                            </span>
                        </h2>
                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                            <?php if (empty($friends)): ?>
                                <p style="color: var(--text-gray); padding: 2rem;">Vous n'avez pas encore d'amis</p>
                            <?php else: ?>
                                <?php foreach ($friends as $friend): ?>
                                    <div
                                        style="background: var(--white); border-radius: 15px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); text-align: center;">
                                        <div style="margin-bottom: 1rem;">
                                            <img src="<?php echo htmlspecialchars($friend['photo_profil']); ?>"
                                                alt="<?php echo htmlspecialchars($friend['prenom'] . ' ' . $friend['nom']); ?>"
                                                style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                                        </div>
                                        <h3 style="font-weight: 600; color: var(--primary-dark); margin-bottom: 0.5rem;">
                                            <?php echo htmlspecialchars($friend['prenom'] . ' ' . substr($friend['nom'], 0, 1) . '.'); ?>
                                        </h3>
                                        <p style="color: var(--text-gray); font-size: 0.9rem; margin-bottom: 1rem;">
                                            Membre depuis <?php echo date('Y', strtotime($friend['date_inscription'])); ?>
                                        </p>
                                        <button class="btn btn--outline btn--small" style="width: 100%;"
                                            onclick="window.location.href='profil.php?id=<?php echo $friend['id_user']; ?>'">
                                            Visiter le profil
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer__content">
            <div class="footer__wrapper">
                <div class="footer__section">
                    <h3 class="footer__section-title">LinkUp</h3>
                    <p class="footer__description">Découvrez et organisez des activités près de chez vous.</p>
                </div>
                <div class="footer__section">
                    <h4 class="footer__section-title">Liens rapides</h4>
                    <ul class="footer__list">
                        <li class="footer__item"><a href="index.html" class="footer__link">Accueil</a></li>
                        <li class="footer__item"><a href="index.html#activites" class="footer__link">Activités</a></li>
                        <li class="footer__item"><a href="index.html#contact" class="footer__link">À propos</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer__bottom">
                <p>&copy; 2024 LinkUp. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="js/profil.js"></script>
</body>

</html>
