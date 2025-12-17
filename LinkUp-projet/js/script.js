// Navbar scroll effect
const navbar = document.querySelector(".navbar");
window.addEventListener("scroll", () => {
  if (window.scrollY > 60) {
    navbar.classList.add("navbar--scrolled");
  } else {
    navbar.classList.remove("navbar--scrolled");
  }
});

// Mobile menu
const mobileMenuBtn = document.querySelector(".mobile-menu");
const navMenu = document.querySelector(".nav");

if (mobileMenuBtn && navMenu) {
  mobileMenuBtn.addEventListener("click", () => {
    const expanded = mobileMenuBtn.getAttribute("aria-expanded") === "true";
    mobileMenuBtn.setAttribute("aria-expanded", String(!expanded));
    navMenu.classList.toggle("nav--open");
  });

  window.addEventListener("resize", () => {
    if (window.innerWidth > 768) {
      navMenu.classList.remove("nav--open");
      mobileMenuBtn.setAttribute("aria-expanded", "false");
    }
  });
}

// Smooth scroll for internal links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    const href = this.getAttribute("href");
    if (!href || href === "#") return;

    const target = document.querySelector(href);
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: "smooth", block: "start" });

      // Close mobile menu if open
      if (navMenu && navMenu.classList.contains("nav--open")) {
        navMenu.classList.remove("nav--open");
        if (mobileMenuBtn) {
          mobileMenuBtn.setAttribute("aria-expanded", "false");
        }
      }
    }
  });
});

// Update active navigation based on scroll position
const sections = document.querySelectorAll("section[id]");
const navLinks = document.querySelectorAll(".nav__link");

function updateActiveNav() {
  if (sections.length === 0) return; // Page login n'a pas de sections

  const fromTop = window.scrollY + Math.max(window.innerHeight * 0.15, 60);

  sections.forEach((section) => {
    const id = section.getAttribute("id");
    const top = section.offsetTop;
    const height = section.offsetHeight;
    const link = document.querySelector(`.nav__link[href="#${id}"]`);

    if (link) {
      if (fromTop >= top && fromTop < top + height) {
        navLinks.forEach((l) => l.classList.remove("nav__link--active"));
        link.classList.add("nav__link--active");
      }
    }
  });
}

// Hero carousel
const heroCarousel = document.querySelector(".hero__carousel");
const heroSlides = heroCarousel
  ? heroCarousel.querySelectorAll(".hero__slide")
  : [];
let heroCurrentIndex = 0;

function showHeroSlide(index) {
  if (!heroCarousel || heroSlides.length === 0) return;
  heroCurrentIndex = (index + heroSlides.length) % heroSlides.length;
  heroCarousel.style.transform = `translateX(-${heroCurrentIndex * 100}%)`;
}

// Autoplay carousel
if (heroSlides.length > 1) {
  setInterval(() => showHeroSlide(heroCurrentIndex + 1), 5000);
}

// Activity card interactions
document.querySelectorAll(".activity__button").forEach((btn) => {
  btn.addEventListener("click", (e) => {
    const card = e.target.closest(".activity");
    if (card) {
      const title =
        card.querySelector(".activity__title")?.textContent || "Activité";
      alert(`Détails de: ${title}`);
      // TODO: Remplacer par une modale ou redirection
    }
  });
});

// Category card hover effects
document.querySelectorAll(".category").forEach((card) => {
  card.addEventListener("focus", () => {
    card.style.boxShadow = "0 12px 40px rgba(0, 0, 0, 0.15)";
  });
  card.addEventListener("blur", () => {
    card.style.boxShadow = "";
  });
});

// Set year
const yearEl = document.getElementById("year");
if (yearEl) yearEl.textContent = new Date().getFullYear();

window.addEventListener("load", () => {
  updateActiveNav();
  showHeroSlide(0);
});
