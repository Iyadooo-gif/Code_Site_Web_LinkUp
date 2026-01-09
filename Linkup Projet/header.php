<header class="header">
  <nav class="navbar">
    <div class="navbar__container">
      <a href="index.php" class="logo">
        <div class="logo__icon">
          <img src="images/Logo.png" alt="LinkUp Logo" />
        </div>
      </a>

      <ul class="nav">
        <li class="nav__item"><a href="index.php" class="nav__link">Accueil</a></li>
        <li class="nav__item"><a href="index.php#categorie" class="nav__link">Catégories</a></li>
        <li class="nav__item"><a href="index.php#activites" class="nav__link">Activités</a></li>
        </ul>

      <div class="navbar__actions">
        <?php if (isset($_SESSION['user_id'])): ?>
          <div class="user-menu">
            <button class="user-menu__trigger" aria-expanded="false">
              <div class="user-avatar">
                <img src="images/avatar-placeholder.svg" alt="Avatar" class="user-avatar__image" />
              </div>
              <span class="user-menu__name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
              <svg class="user-menu__arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
              </svg>
            </button>
            <div class="user-menu__dropdown">
              <a href="profil.php" class="user-menu__item">Mon Profil</a>
              <a href="settings.php" class="user-menu__item">Préférences</a>
              <div class="user-menu__divider"></div>
              <a href="logout.php" class="user-menu__item user-menu__item--danger">Déconnexion</a>
            </div>
          </div>
        <?php else: ?>
          <a class="btn btn--secondary" href="login.php">Se connecter</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
</header>