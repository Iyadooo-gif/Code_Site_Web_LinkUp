// ...existing code...
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>LinkUp - Discover & Share Activities</title>
    <style>
        :root{
            --primary-blue:#5BC4F4;
            --primary-dark:#112242;
            --text-dark:#1F2937;
            --text-gray:#6B7280;
            --bg-light:#F9FAFB;
            --white:#FFFFFF;
            --shadow:0 4px 6px -1px rgba(0,0,0,0.1);
            --shadow-lg:0 10px 15px -3px rgba(0,0,0,0.1);
        }

        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Georgia, 'Times New Roman', serif;color:var(--text-dark);line-height:1.6;background:var(--white)}

        /* Navigation */
        .navbar{background:rgba(255,255,255,0.98);backdrop-filter:blur(10px);padding:1.2rem 2rem;box-shadow:0 2px 20px rgba(0,0,0,0.05);position:sticky;top:0;z-index:100;border-bottom:1px solid rgba(17,34,66,0.08);transition:all .25s}
        .navbar.scrolled{padding:.7rem 2rem;box-shadow:0 6px 30px rgba(0,0,0,0.08)}
        .nav-container{max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:1rem}
        .logo{display:flex;align-items:center;gap:.6rem;font-size:1.25rem;font-weight:700;color:var(--primary-dark);text-decoration:none}
        .nav-links{display:flex;gap:1.2rem;list-style:none;align-items:center;flex:1;justify-content:center}
        .nav-links a{text-decoration:none;color:var(--text-gray);font-weight:500;font-size:.95rem;position:relative;padding:.4rem 0;transition:color .2s}
        .nav-links a.active{color:var(--primary-blue);font-weight:600}
        .nav-actions{display:flex;align-items:center;gap:.6rem}
        .mobile-menu-btn{display:none;background:transparent;border:0;cursor:pointer}
        .mobile-menu-btn span{display:block;width:22px;height:2px;background:var(--primary-dark);margin:4px 0;border-radius:2px}

        /* Hero */
        .hero{position:relative;height:60vh;background:linear-gradient(135deg,var(--primary-dark),#0b2740);display:flex;align-items:center;justify-content:center;color:var(--white);text-align:center;overflow:hidden}
        .hero-carousel{position:absolute;inset:0;display:flex;transition:transform .7s ease}
        .hero-slide{min-width:100%;height:100%;display:flex;align-items:center;justify-content:center;background-size:cover;background-position:center;filter:brightness(.6)}
        .hero-content{position:relative;z-index:2;padding:2rem}
        .hero-content h1{font-size:2.4rem;font-weight:300;margin-bottom:1rem;letter-spacing:1px}
        .hero-search{max-width:700px;margin:0 auto;position:relative}
        .hero-search input{width:100%;padding:1rem 6.5rem 1rem 2.5rem;border:none;border-radius:50px;font-size:1rem;box-shadow:var(--shadow-lg)}

        .hero-search button{position:absolute;right:.6rem;top:50%;transform:translateY(-50%);padding:.6rem 1.2rem;background:linear-gradient(135deg,var(--primary-dark),var(--primary-blue));color:var(--white);border:none;border-radius:50px;cursor:pointer}

        /* Sections */
        .section{padding:4rem 1.25rem;max-width:1200px;margin:0 auto}
        .section-title{text-align:center;font-size:2rem;font-weight:300;margin-bottom:2.25rem;color:var(--primary-dark);font-family:Georgia,serif}

        /* Categories grid */
        .categories{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.25rem}
        .category-card{background:var(--white);padding:1rem;border-radius:12px;box-shadow:var(--shadow);display:flex;flex-direction:column;gap:.8rem;min-height:140px}
        .category-card h3{margin-top:.25rem;font-size:1.05rem}
        .category-card p{color:var(--text-gray);font-size:.9rem}

        /* Activities grid */
        .activities{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1.25rem}
        .activity-card{background:var(--white);border-radius:12px;overflow:hidden;box-shadow:var(--shadow);display:flex;flex-direction:column}
        .activity-image{height:140px;background:#ddd}
        .activity-content{padding:1rem}
        .view-details{display:inline-block;margin-top:.6rem;padding:.45rem .8rem;border-radius:999px;background:transparent;border:1px solid rgba(17,34,66,0.08);cursor:pointer}

        /* CTA */
        .cta-section{background:linear-gradient(135deg,#f8fbff,#eef8ff);padding:3rem;text-align:center}
        .cta-section h2{font-size:1.5rem;margin-bottom:.6rem}
        .cta-section p{color:var(--text-gray);margin-bottom:1rem}

        /* Footer */
        .footer{background:#0f1724;color:#cbd5e1;padding:2rem}
        .footer-content{max-width:1200px;margin:0 auto}
        .footer-bottom{text-align:center;margin-top:1rem;color:#94a3b8}

        /* Responsive */
        @media (max-width:768px){
            .nav-links{display:none;position:absolute;top:100%;left:0;right:0;background:var(--white);flex-direction:column;padding:1rem;border-top:1px solid rgba(17,34,66,0.06)}
            .mobile-menu-btn{display:block}
            .hero-content h1{font-size:1.6rem}
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" aria-label="Main navigation">
        <div class="nav-container">
            <a class="logo" href="#top">
                <div class="logo-icon" aria-hidden="true" style="width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,var(--primary-blue),#8ed8fb);display:flex;align-items:center;justify-content:center;color:var(--primary-dark);font-weight:700">LU</div>
                <div>
                    <div class="logo-text"><span class="logo-text-link">Link</span><span class="logo-text-up">Up</span></div>
                </div>
            </a>

            <button class="mobile-menu-btn" aria-expanded="false" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>

            <ul class="nav-links" role="menubar">
                <li><a href="#hero" class="active">Accueil</a></li>
                <li><a href="#categories">Catégories</a></li>
                <li><a href="#activities">Activités</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>

            <div class="nav-actions">
                <a class="btn btn-secondary" href="#login">Se connecter</a>
                <a class="btn btn-primary" href="#signup" style="padding:.6rem 1rem;border-radius:999px;background:linear-gradient(135deg,var(--primary-dark),var(--primary-blue));color:var(--white)">S'inscrire</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="hero">
        <div class="hero-carousel" aria-hidden="true">
            <div class="hero-slide" style="background-image:linear-gradient(135deg,rgba(10,30,50,.5),rgba(20,60,90,.3)),url('');">
            </div>
            <div class="hero-slide" style="background-image:linear-gradient(135deg,rgba(8,25,45,.5),rgba(15,45,75,.3)),url('');">
            </div>
            <div class="hero-slide" style="background-image:linear-gradient(135deg,rgba(12,35,60,.5),rgba(25,70,110,.3)),url('');">
            </div>
        </div>

        <div class="hero-overlay" aria-hidden="true" style="position:absolute;inset:0;background:linear-gradient(rgba(17,34,66,0.25),rgba(17,34,66,0.15));z-index:1"></div>

        <div class="hero-content">
            <h1>Trouvez des activités près de chez vous</h1>
            <div class="hero-search" role="search">
                <input id="mainSearch" type="text" placeholder="Rechercher une activité, lieu ou mot-clé..." />
                <button type="button" aria-label="Search">Rechercher</button>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="section">
        <h2 class="section-title">Explorez les Activités par Catégorie</h2>
        <div class="categories">
            <article class="category-card" tabindex="0">
                <div class="category-icon" aria-hidden="true" style="font-size:1.6rem">🚴</div>
                <h3>Sport & Aventure</h3>
                <p>Randonnées, vélo, sports nautiques et plus.</p>
            </article>
            <article class="category-card" tabindex="0">
                <div class="category-icon" aria-hidden="true" style="font-size:1.6rem">🎨</div>
                <h3>Arts & Ateliers</h3>
                <p>Peinture, poterie, ateliers créatifs locaux.</p>
            </article>
            <article class="category-card" tabindex="0">
                <div class="category-icon" aria-hidden="true" style="font-size:1.6rem">🍽️</div>
                <h3>Food & Drink</h3>
                <p>Expériences culinaires et dégustations.</p>
            </article>
        </div>
    </section>

    <!-- Popular Activities Section -->
    <section id="activities" class="section" style="background:var(--bg-light);padding:3.5rem 1.25rem;">
        <h2 class="section-title">Activités Populaires Près de Chez Vous</h2>
        <div class="activities" style="max-width:1200px;margin:0 auto;">
            <article class="activity-card">
                <div class="activity-image" style="background-image:linear-gradient(90deg,#e6f7ff,#cceeff);"></div>
                <div class="activity-content">
                    <h3>Balade en montagne</h3>
                    <p class="activity-meta" style="color:var(--text-gray)">2h · Facile · 12 personnes</p>
                    <button class="view-details" type="button">Voir détails</button>
                </div>
            </article>

            <article class="activity-card">
                <div class="activity-image" style="background-image:linear-gradient(90deg,#fff4e6,#ffe8cc);"></div>
                <div class="activity-content">
                    <h3>Atelier poterie</h3>
                    <p class="activity-meta" style="color:var(--text-gray)">3h · Tous niveaux · 8 personnes</p>
                    <button class="view-details" type="button">Voir détails</button>
                </div>
            </article>

            <article class="activity-card">
                <div class="activity-image" style="background-image:linear-gradient(90deg,#f0fff3,#d9ffe6);"></div>
                <div class="activity-content">
                    <h3>Dégustation locale</h3>
                    <p class="activity-meta" style="color:var(--text-gray)">1.5h · 18 ans+ · 20 personnes</p>
                    <button class="view-details" type="button">Voir détails</button>
                </div>
            </article>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="contact">
        <h2>Prêt ? Créez Votre Propre Activité !</h2>
        <p>Connectez-vous et partagez des expériences avec votre communauté</p>
        <button class="btn" style="padding:.7rem 1.4rem;border-radius:999px;background:linear-gradient(135deg,var(--primary-dark),var(--primary-blue));color:var(--white)">Créer une Activité</button>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div style="display:flex;justify-content:space-between;gap:1rem;flex-wrap:wrap">
                <div>
                    <h4 style="color:#fff">LinkUp</h4>
                    <p style="max-width:280px;color:#9fb0c8">Partagez et découvrez des activités proches de vous.</p>
                </div>
                <div>
                    <h4 style="color:#fff">Liens</h4>
                    <ul style="list-style:none">
                        <li><a href="#categories" style="color:#cfeffd;text-decoration:none">Catégories</a></li>
                        <li><a href="#activities" style="color:#cfeffd;text-decoration:none">Activités</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">© <span id="year"></span> LinkUp — Tous droits réservés</div>
    </footer>

    <script>
        // Smooth scroll for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e){
                const href = this.getAttribute('href');
                if(!href || href === '#') return;
                const target = document.querySelector(href);
                if(target){
                    e.preventDefault();
                    target.scrollIntoView({behavior:'smooth',block:'start'});
                    // close mobile menu if open
                    const nav = document.querySelector('.nav-links');
                    if(nav && nav.style.display === 'flex' && window.innerWidth <= 768){
                        nav.style.display = 'none';
                        document.querySelector('.mobile-menu-btn').setAttribute('aria-expanded','false');
                    }
                }
            });
        });

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if(window.scrollY > 60) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
            updateActiveNav();
        });

        // Add active state to navigation based on sections in viewport
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-links a');

        function updateActiveNav(){
            const fromTop = window.scrollY + Math.max(window.innerHeight * 0.15, 60);
            sections.forEach(section => {
                const id = section.getAttribute('id');
                const top = section.offsetTop;
                const height = section.offsetHeight;
                const link = document.querySelector('.nav-links a[href="#' + id + '"]');
                if(link){
                    if(fromTop >= top && fromTop < top + height){
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                }
            });
        }

        // Mobile menu toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const navLinksContainer = document.querySelector('.nav-links');
        if(mobileMenuBtn && navLinksContainer){
            mobileMenuBtn.addEventListener('click', () => {
                const expanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
                mobileMenuBtn.setAttribute('aria-expanded', String(!expanded));
                if(window.getComputedStyle(navLinksContainer).display === 'none' || window.innerWidth <= 768){
                    // toggle display
                    navLinksContainer.style.display = navLinksContainer.style.display === 'flex' ? 'none' : 'flex';
                    navLinksContainer.style.flexDirection = 'column';
                }
            });
            // ensure menu hides on resize to large screens
            window.addEventListener('resize', () => {
                if(window.innerWidth > 768){
                    navLinksContainer.style.display = 'flex';
                    navLinksContainer.style.flexDirection = '';
                } else {
                    navLinksContainer.style.display = 'none';
                    mobileMenuBtn.setAttribute('aria-expanded','false');
                }
            });
            // initialize display state
            if(window.innerWidth <= 768){
                navLinksContainer.style.display = 'none';
            }
        }

        // Simple interactions for activity cards / view details
        document.querySelectorAll('.view-details').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const card = e.target.closest('.activity-card');
                if(card){
                    // Example placeholder behavior: show details via alert (replace with modal)
                    alert(card.querySelector('h3')?.textContent || 'Voir détails');
                }
            });
        });

        // Category card hover/accessibility effect
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('mouseenter', () => card.style.transform = 'translateY(-4px)');
            card.addEventListener('mouseleave', () => card.style.transform = '');
            card.addEventListener('focus', () => card.style.boxShadow = '0 8px 30px rgba(0,0,0,0.08)');
            card.addEventListener('blur', () => card.style.boxShadow = '');
        });

        // Hero carousel logic
        const heroCarousel = document.querySelector('.hero-carousel');
        const heroSlides = heroCarousel ? heroCarousel.querySelectorAll('.hero-slide') : [];
        let heroCurrentIndex = 0;
        function showHeroSlide(index){
            if(!heroCarousel || heroSlides.length === 0) return;
            heroCurrentIndex = (index + heroSlides.length) % heroSlides.length;
            heroCarousel.style.transform = 'translateX(-' + (heroCurrentIndex * 100) + '%)';
        }
        // autoplay
        if(heroSlides.length > 1){
            setInterval(() => showHeroSlide(heroCurrentIndex + 1), 5000);
        }

        // Populate dynamic year in footer
        const yearEl = document.getElementById('year');
        if(yearEl) yearEl.textContent = new Date().getFullYear();

        // Initial active nav update on load
        window.addEventListener('load', () => {
            updateActiveNav();
            // ensure hero shows initial slide
            showHeroSlide(0);
        });
    </script>
</body>
</html>
// ...existing code...
