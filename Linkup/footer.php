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
              <li class="footer__item">
                <a href="index.php" class="footer__link">Accueil</a>
              </li>
              <li class="footer__item">
                <a href="index.php#activites" class="footer__link"
                  >Activités</a
                >
              </li>
              <li class="footer__item">
                <a href="index.php#contact" class="footer__link">À propos</a>
              </li>
            </ul>
          </div>
          <div class="footer__section">
            <h4 class="footer__section-title">Ressources</h4>
            <ul class="footer__list">
              <li class="footer__item">
                <a href="cgu.php" class="footer__link">Conditions</a>
              </li>
            </ul>
          </div>
          </div>
        <div class="footer__bottom">
          <p>&copy; <?php echo date("Y"); ?> LinkUp. Tous droits réservés.</p>
        </div>
      </div>
    </footer>
    
    <script src="js/script.js"></script>
    <script>
      const userMenuTrigger = document.querySelector(".user-menu__trigger");
      if (userMenuTrigger) {
        userMenuTrigger.addEventListener("click", function(e) {
            const expanded = this.getAttribute("aria-expanded") === "true";
            this.setAttribute("aria-expanded", !expanded);
        });
      }
    </script>
  </body>
</html>