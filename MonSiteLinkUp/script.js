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
            const nav = document.querySelector('.nav');
            if(nav && nav.classList.contains('nav--open') && window.innerWidth <= 768){
                nav.classList.remove('nav--open');
                document.querySelector('.mobile-menu').setAttribute('aria-expanded','false');
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
const navLinks = document.querySelectorAll('.nav a');

function updateActiveNav(){
    const fromTop = window.scrollY + Math.max(window.innerHeight * 0.15, 60);
    sections.forEach(section => {
        const id = section.getAttribute('id');
        const top = section.offsetTop;
        const height = section.offsetHeight;
        const link = document.querySelector('.nav a[href="#' + id + '"]');
        if(link){
            if(fromTop >= top && fromTop < top + height){
                link.classList.add('nav__link--active');
            } else {
                link.classList.remove('nav__link--active');
            }
        }
    });
}

// Mobile menu toggle
const mobileMenuBtn = document.querySelector('.mobile-menu');
const navLinksContainer = document.querySelector('.nav');
if(mobileMenuBtn && navLinksContainer){
    mobileMenuBtn.addEventListener('click', () => {
        const expanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
        mobileMenuBtn.setAttribute('aria-expanded', String(!expanded));
        navLinksContainer.classList.toggle('nav--open');
    });
    window.addEventListener('resize', () => {
        if(window.innerWidth > 768){
            navLinksContainer.classList.remove('nav--open');
            mobileMenuBtn.setAttribute('aria-expanded','false');
        } else {
            navLinksContainer.classList.remove('nav--open');
            mobileMenuBtn.setAttribute('aria-expanded','false');
        }
    });
}

// Simple interactions for activity cards / view details
document.querySelectorAll('.activity__button').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const card = e.target.closest('.activity');
        if(card){
            const title = card.querySelector('.activity__title')?.textContent || 'Activité';
            const buttonText = e.target.textContent;
            if(buttonText === 'Voir détails'){
                alert(`Détails de: ${title}`);
            } else if(buttonText === 'Annuler inscription'){
                if(confirm(`Annuler l'inscription à ${title} ?`)){
                    alert('Inscription annulée.');
                }
            } else if(buttonText === 'Gérer'){
                alert(`Gérer: ${title}`);
            }
        }
    });
});

// Category card accessibility
document.querySelectorAll('.category').forEach(card => {
    card.addEventListener('focus', () => card.style.outline = '2px solid var(--primary-blue)');
    card.addEventListener('blur', () => card.style.outline = 'none');
});

// Hero carousel logic
const heroCarousel = document.querySelector('.hero__carousel');
const heroSlides = heroCarousel ? heroCarousel.querySelectorAll('.hero__slide') : [];
let heroCurrentIndex = 0;
function showHeroSlide(index){
    if(!heroCarousel || heroSlides.length === 0) return;
    heroCurrentIndex = (index + heroSlides.length) % heroSlides.length;
    heroCarousel.style.transform = 'translateX(-' + (heroCurrentIndex * 100) + '%)';
}
// autoplay
setInterval(() => showHeroSlide(heroCurrentIndex + 1), 5000);

// Set current year in footer
document.getElementById('year').textContent = new Date().getFullYear();

// Tab functionality for profile page
document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', () => {
        const tabId = tab.getAttribute('data-tab');
        
        // Remove active class from all tabs
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        // Add active class to clicked tab
        tab.classList.add('active');
        
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        // Show selected tab content
        document.getElementById(tabId).classList.add('active');
    });
});

// Export data function
function exportData() {
    alert('Fonctionnalité d\'export des données à implémenter. Vos données seront téléchargées au format JSON.');
}

// Enhanced activity button interactions
document.querySelectorAll('.activity-card__button').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const card = e.target.closest('.activity-card');
        if(card){
            const title = card.querySelector('.activity-card__title')?.textContent || 'Activité';
            const buttonText = e.target.textContent;
            if(buttonText === 'Voir détails'){
                alert(`Détails de: ${title}`);
            } else if(buttonText === 'Annuler inscription'){
                if(confirm(`Annuler l'inscription à ${title} ?`)){
                    alert('Inscription annulée.');
                }
            } else if(buttonText === 'Modifier'){
                alert(`Modification de: ${title}`);
            } else if(buttonText === 'Gérer'){
                alert(`Gestion de: ${title}`);
            } else if(buttonText === 'S\'inscrire'){
                alert(`Inscription à: ${title}`);
            }
        }
    });
});

// Friend card interactions
document.querySelectorAll('.friend-card__button').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const card = e.target.closest('.friend-card');
        const name = card.querySelector('.friend-card__name')?.textContent || 'Ami';
        alert(`Profil de ${name}`);
    });
});

// Invitation actions
document.querySelectorAll('.btn-accept').forEach(btn => {
    btn.addEventListener('click', () => {
        alert('Invitation acceptée !');
        // In a real app, this would update the invitation status
    });
});

document.querySelectorAll('.btn-decline').forEach(btn => {
    btn.addEventListener('click', () => {
        if(confirm('Refuser cette invitation ?')) {
            alert('Invitation refusée.');
        }
    });
});
if(heroSlides.length > 1){
    setInterval(() => showHeroSlide(heroCurrentIndex + 1), 5000);
}

// Populate dynamic year in footer
const yearEl = document.getElementById('year');
if(yearEl) yearEl.textContent = new Date().getFullYear();

// Initial active nav update on load
window.addEventListener('load', () => {
    updateActiveNav();
    showHeroSlide(0);
});

// ========================================
// NOTIFICATIONS FUNCTIONALITY
// ========================================

// Mark notification as read
function markAsRead(button) {
    const notificationItem = button.closest('.notification-item');
    notificationItem.classList.remove('unread');
    button.remove();
    updateNotificationCount();
}

// Delete notification
function deleteNotification(button) {
    const notificationItem = button.closest('.notification-item');
    notificationItem.style.opacity = '0';
    setTimeout(() => {
        notificationItem.remove();
        updateNotificationCount();
    }, 300);
}

// Mark all notifications as read
function markAllAsRead() {
    const unreadNotifications = document.querySelectorAll('.notification-item.unread');
    unreadNotifications.forEach(item => {
        item.classList.remove('unread');
        const markButton = item.querySelector('.notification-action:not(.delete)');
        if (markButton) markButton.remove();
    });
    updateNotificationCount();
}

// Filter notifications
function filterNotifications() {
    const filterValue = document.getElementById('filter-select').value;
    const notifications = document.querySelectorAll('.notification-item');

    notifications.forEach(notification => {
        const type = notification.getAttribute('data-type');
        const isUnread = notification.classList.contains('unread');

        let show = true;

        switch(filterValue) {
            case 'unread':
                show = isUnread;
                break;
            case 'activities':
                show = type === 'activities';
                break;
            case 'friends':
                show = type === 'friends';
                break;
            case 'system':
                show = type === 'system';
                break;
            default:
                show = true;
        }

        notification.style.display = show ? 'flex' : 'none';
        notification.style.opacity = show ? '1' : '0';
    });
}

// Update notification count (for future badge implementation)
function updateNotificationCount() {
    const unreadCount = document.querySelectorAll('.notification-item.unread').length;
    const countElement = document.getElementById('unread-count');
    if (countElement) {
        countElement.textContent = unreadCount > 0 ? `(${unreadCount} non lue${unreadCount > 1 ? 's' : ''})` : '';
    }
    // This could update a badge in the navbar
    console.log(`Unread notifications: ${unreadCount}`);
}

// Reset preferences
function resetPreferences() {
    if (confirm('Réinitialiser toutes les préférences aux valeurs par défaut ?')) {
        const checkboxes = document.querySelectorAll('.preferences-form input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            // Reset to default state (some checked, some not)
            const defaultChecked = ['email-activities', 'email-friends', 'email-updates', 'push-reminders', 'push-messages', 'push-invitations', 'app-badges', 'app-sounds'];
            checkbox.checked = defaultChecked.includes(checkbox.id);
        });
    }
}

// Save preferences (simulate saving)
function savePreferences(event) {
    event.preventDefault();
    // In a real app, this would send data to server
    alert('Préférences sauvegardées avec succès !');
}

// Initialize notifications page
document.addEventListener('DOMContentLoaded', () => {
    // Add event listener for preferences form
    const preferencesForm = document.querySelector('.preferences-form');
    if (preferencesForm) {
        preferencesForm.addEventListener('submit', savePreferences);
    }

    // Update notification count on load
    updateNotificationCount();

    // Initialize activity form summary updates
    initializeActivityForm();
});

// Activity form summary update functionality
function initializeActivityForm() {
    const form = document.getElementById('activity-form');
    if (!form) return;

    // Update summary when form inputs change
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', updateActivitySummary);
        input.addEventListener('change', updateActivitySummary);
    });

    // Initial summary update
    updateActivitySummary();

    // Initialize progress indicator
    initializeProgressIndicator();
}

function initializeProgressIndicator() {
    const progressSteps = document.querySelectorAll('.progress-step');
    const sections = document.querySelectorAll('section[id]');

    function updateProgressIndicator() {
        const scrollPosition = window.scrollY + window.innerHeight / 2;

        sections.forEach((section, index) => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const step = progressSteps[index];

            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                // Current section
                step.classList.add('active');
            } else if (scrollPosition >= sectionTop + sectionHeight) {
                // Passed section
                step.classList.add('active');
            } else {
                // Future section
                step.classList.remove('active');
            }
        });
    }

    // Update on scroll
    window.addEventListener('scroll', updateProgressIndicator);
    // Initial update
    updateProgressIndicator();
}

function updateActivitySummary() {
    // Update title
    const titleInput = document.getElementById('activity-title');
    const titleSpan = document.getElementById('summary-title');
    if (titleInput && titleSpan) {
        titleSpan.textContent = titleInput.value || '-';
    }

    // Update date and time
    const dateInput = document.getElementById('activity-date');
    const timeInput = document.getElementById('activity-time');
    const datetimeSpan = document.getElementById('summary-datetime');
    if (dateInput && timeInput && datetimeSpan) {
        const date = dateInput.value;
        const time = timeInput.value;
        if (date && time) {
            const dateObj = new Date(`${date}T${time}`);
            datetimeSpan.textContent = dateObj.toLocaleDateString('fr-FR', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } else {
            datetimeSpan.textContent = '-';
        }
    }

    // Update location
    const cityInput = document.getElementById('activity-city');
    const locationSpan = document.getElementById('summary-location');
    if (cityInput && locationSpan) {
        locationSpan.textContent = cityInput.value || '-';
    }

    // Update price
    const priceInput = document.getElementById('activity-price');
    const priceSpan = document.getElementById('summary-price');
    if (priceInput && priceSpan) {
        const price = priceInput.value;
        priceSpan.textContent = price ? `${price}€` : '-';
    }
}

// ========================================
// SETTINGS PAGE FUNCTIONS
// ========================================





// Language management
function initializeLanguage() {
    const languageSelect = document.getElementById('language');
    if (!languageSelect) return;

    // Load saved language
    const savedLanguage = localStorage.getItem('linkup-language') || 'fr';
    languageSelect.value = savedLanguage;

    // Language change handler
    languageSelect.addEventListener('change', (e) => {
        const language = e.target.value;
        localStorage.setItem('linkup-language', language);
        // In a real app, this would reload the page or update all text
        alert(`Langue changée vers ${language === 'fr' ? 'Français' : language === 'en' ? 'English' : 'Español'}`);
    });
}

// Font size management
function initializeFontSize() {
    const fontSizeSelect = document.getElementById('font-size');
    if (!fontSizeSelect) return;

    // Load saved font size
    const savedFontSize = localStorage.getItem('linkup-font-size') || 'medium';
    fontSizeSelect.value = savedFontSize;
    applyFontSize(savedFontSize);

    // Font size change handler
    fontSizeSelect.addEventListener('change', (e) => {
        const fontSize = e.target.value;
        localStorage.setItem('linkup-font-size', fontSize);
        applyFontSize(fontSize);
    });
}

function applyFontSize(size) {
    const root = document.documentElement;

    switch (size) {
        case 'small':
            root.style.setProperty('font-size', '14px');
            break;
        case 'large':
            root.style.setProperty('font-size', '18px');
            break;
        default: // medium
            root.style.setProperty('font-size', '16px');
            break;
    }
}

// Notification settings management
function initializeNotificationSettings() {
    const notificationToggles = document.querySelectorAll('.notification-settings input[type="checkbox"]');

    notificationToggles.forEach(toggle => {
        // Load saved settings
        const setting = localStorage.getItem(`linkup-notification-${toggle.id}`) === 'true';
        toggle.checked = setting;

        // Save on change
        toggle.addEventListener('change', (e) => {
            localStorage.setItem(`linkup-notification-${e.target.id}`, e.target.checked);
        });
    });
}

// Privacy settings management
function initializePrivacySettings() {
    const privacySelects = document.querySelectorAll('.privacy-settings select');

    privacySelects.forEach(select => {
        // Load saved settings
        const savedValue = localStorage.getItem(`linkup-privacy-${select.id}`) || select.value;
        select.value = savedValue;

        // Save on change
        select.addEventListener('change', (e) => {
            localStorage.setItem(`linkup-privacy-${e.target.id}`, e.target.value);
        });
    });
}

// Profile form handling
function initializeProfileForm() {
    const profileForm = document.querySelector('.profile-form');
    if (!profileForm) return;

    profileForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // In a real app, this would send data to server
        const formData = new FormData(profileForm);
        const data = Object.fromEntries(formData);

        // Simulate save
        console.log('Profile data saved:', data);
        alert('Profil mis à jour avec succès !');

        // Update display name in header if changed
        const firstName = data.first_name;
        const lastName = data.last_name;
        if (firstName && lastName) {
            localStorage.setItem('linkup-user-name', `${firstName} ${lastName}`);
        }
    });
}

// Password modal functions
function openPasswordModal() {
    const modal = document.getElementById('password-modal');
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closePasswordModal() {
    const modal = document.getElementById('password-modal');
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }
}

// Password change form handling
function initializePasswordForm() {
    const passwordForm = document.querySelector('.password-form');
    if (!passwordForm) return;

    passwordForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const currentPassword = document.getElementById('current-password').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        // Basic validation
        if (!currentPassword || !newPassword || !confirmPassword) {
            alert('Veuillez remplir tous les champs.');
            return;
        }

        if (newPassword !== confirmPassword) {
            alert('Les mots de passe ne correspondent pas.');
            return;
        }

        if (newPassword.length < 8) {
            alert('Le nouveau mot de passe doit contenir au moins 8 caractères.');
            return;
        }

        // In a real app, this would verify current password and update
        console.log('Password change requested');
        alert('Mot de passe changé avec succès !');

        closePasswordModal();
        passwordForm.reset();
    });
}

// Account deletion confirmation
function confirmAccountDeletion() {
    const confirmed = confirm(
        'Êtes-vous sûr de vouloir supprimer votre compte ?\n\n' +
        'Cette action est irréversible et toutes vos données seront supprimées définitivement.'
    );

    if (confirmed) {
        const finalConfirm = confirm(
            'Dernière confirmation : Cette action ne peut pas être annulée.\n\n' +
            'Cliquez sur "OK" pour supprimer définitivement votre compte.'
        );

        if (finalConfirm) {
            // In a real app, this would call an API to delete the account
            console.log('Account deletion requested');
            alert('Demande de suppression de compte envoyée. Vous serez déconnecté.');

            // Redirect to home page
            window.location.href = 'acceuil.html';
        }
    }
}

// Initialize all settings when DOM is loaded
function initializeSettingsPage() {
    if (!document.querySelector('.settings-section')) return;

    initializeTheme();
    initializeLanguage();
    initializeFontSize();
    initializeNotificationSettings();
    initializePrivacySettings();
    initializeProfileForm();
    initializePasswordForm();

    // Close modal when clicking outside
    const modal = document.getElementById('password-modal');
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closePasswordModal();
            }
        });
    }

    // Close modal on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && modal.classList.contains('show')) {
            closePasswordModal();
        }
    });
}

// Initialize settings when page loads
document.addEventListener('DOMContentLoaded', initializeSettingsPage);

// ========================================
// USER MENU FUNCTIONALITY
// ========================================

function initializeUserMenu() {
    const userMenuTrigger = document.querySelector('.user-menu__trigger');
    if (!userMenuTrigger) return;

    const userMenuDropdown = document.querySelector('.user-menu__dropdown');

    // Toggle dropdown on button click
    userMenuTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        const isExpanded = userMenuTrigger.getAttribute('aria-expanded') === 'true';
        userMenuTrigger.setAttribute('aria-expanded', !isExpanded);
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!userMenuTrigger.contains(e.target) && !userMenuDropdown.contains(e.target)) {
            userMenuTrigger.setAttribute('aria-expanded', 'false');
        }
    });

    // Close dropdown on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && userMenuTrigger.getAttribute('aria-expanded') === 'true') {
            userMenuTrigger.setAttribute('aria-expanded', 'false');
        }
    });

    // Load user name from localStorage if available
    const savedUserName = localStorage.getItem('linkup-user-name');
    if (savedUserName) {
        const userNameElement = document.querySelector('.user-menu__name');
        if (userNameElement) {
            userNameElement.textContent = savedUserName;
        }
    }
}

// Initialize user menu when page loads
document.addEventListener('DOMContentLoaded', initializeUserMenu);

// ========================================
// ENHANCED SETTINGS FUNCTIONALITY
// ========================================

// Theme management with visual previews
function initializeThemeSelector() {
    const themeInputs = document.querySelectorAll('input[name="theme"]');
    if (themeInputs.length === 0) return;

    themeInputs.forEach(input => {
        input.addEventListener('change', (e) => {
            const theme = e.target.value;
            applyTheme(theme);
        });
    });

    // Load saved theme
    const savedTheme = localStorage.getItem('linkup-theme') || 'light';
    const savedInput = document.querySelector(`input[name="theme"][value="${savedTheme}"]`);
    if (savedInput) {
        savedInput.checked = true;
    }
    applyTheme(savedTheme);
}

function applyTheme(theme) {
    const html = document.documentElement;

    if (theme === 'dark') {
        html.setAttribute('data-theme', 'dark');
        localStorage.setItem('linkup-theme', 'dark');
    } else if (theme === 'auto') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        html.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
        localStorage.setItem('linkup-theme', 'auto');
    } else {
        // Light theme (default)
        html.setAttribute('data-theme', 'light');
        localStorage.setItem('linkup-theme', 'light');
    }
}

// Language and region settings
function initializeLanguageSettings() {
    const languageSelect = document.getElementById('language');
    const dateFormatSelect = document.getElementById('date-format');
    const timeFormatSelect = document.getElementById('time-format');
    const timezoneSelect = document.getElementById('timezone');

    // Load saved settings
    if (languageSelect) {
        const savedLanguage = localStorage.getItem('linkup-language') || 'fr';
        languageSelect.value = savedLanguage;
        languageSelect.addEventListener('change', (e) => {
            localStorage.setItem('linkup-language', e.target.value);
            // In a real app, this would trigger a page reload or translation
            alert(`Langue changée vers ${e.target.value === 'fr' ? 'Français' : e.target.value === 'en' ? 'English' : 'Español'}`);
        });
    }

    if (dateFormatSelect) {
        const savedDateFormat = localStorage.getItem('linkup-date-format') || 'dd/mm/yyyy';
        dateFormatSelect.value = savedDateFormat;
        dateFormatSelect.addEventListener('change', (e) => {
            localStorage.setItem('linkup-date-format', e.target.value);
        });
    }

    if (timeFormatSelect) {
        const savedTimeFormat = localStorage.getItem('linkup-time-format') || '24h';
        timeFormatSelect.value = savedTimeFormat;
        timeFormatSelect.addEventListener('change', (e) => {
            localStorage.setItem('linkup-time-format', e.target.value);
        });
    }

    if (timezoneSelect) {
        const savedTimezone = localStorage.getItem('linkup-timezone') || 'Europe/Paris';
        timezoneSelect.value = savedTimezone;
        timezoneSelect.addEventListener('change', (e) => {
            localStorage.setItem('linkup-timezone', e.target.value);
        });
    }
}

// Google Translate integration
function initializeGoogleTranslate() {
    // Add Google Translate script
    const script = document.createElement('script');
    script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
    script.async = true;
    document.head.appendChild(script);

    // Initialize translate widget
    window.googleTranslateElementInit = function() {
        new google.translate.TranslateElement({
            pageLanguage: 'fr',
            includedLanguages: 'fr,en,es,de,it',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');

        // Hide the widget initially
        const widget = document.getElementById('google_translate_element');
        if (widget) {
            widget.style.display = 'none';
        }
    };
}

// Participation rules settings
function initializeParticipationSettings() {
    const approvalRequired = document.getElementById('approval-required');
    const defaultVisibility = document.getElementById('default-visibility');
    const directInvitations = document.getElementById('direct-invitations');

    // Load saved settings
    if (approvalRequired) {
        const saved = localStorage.getItem('linkup-approval-required') === 'true';
        approvalRequired.checked = saved;
        approvalRequired.addEventListener('change', (e) => {
            localStorage.setItem('linkup-approval-required', e.target.checked);
        });
    }

    if (defaultVisibility) {
        const saved = localStorage.getItem('linkup-default-visibility') || 'friends';
        defaultVisibility.value = saved;
        defaultVisibility.addEventListener('change', (e) => {
            localStorage.setItem('linkup-default-visibility', e.target.value);
        });
    }

    if (directInvitations) {
        const saved = localStorage.getItem('linkup-direct-invitations') !== 'false'; // Default true
        directInvitations.checked = saved;
        directInvitations.addEventListener('change', (e) => {
            localStorage.setItem('linkup-direct-invitations', e.target.checked);
        });
    }
}

// Notification settings management
function initializeNotificationSettings() {
    const notificationToggles = document.querySelectorAll('.notification-settings input[type="checkbox"]');

    notificationToggles.forEach(toggle => {
        // Load saved settings
        const setting = localStorage.getItem(`linkup-notification-${toggle.id}`) !== 'false'; // Default true for most
        toggle.checked = setting;

        // Save on change
        toggle.addEventListener('change', (e) => {
            localStorage.setItem(`linkup-notification-${e.target.id}`, e.target.checked);
        });
    });
}

// Two-Factor Authentication Modal Functions
function openTwoFactorModal() {
    const modal = document.getElementById('twofactor-modal');
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        // Reset to first step
        showTwoFactorStep(1);
    }
}

function closeTwoFactorModal() {
    const modal = document.getElementById('twofactor-modal');
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }
}

function showTwoFactorStep(step) {
    // Hide all steps
    document.querySelectorAll('.twofactor-step').forEach(stepEl => {
        stepEl.style.display = 'none';
    });

    // Show current step
    const currentStep = document.getElementById(`twofactor-step-${step}`);
    if (currentStep) {
        currentStep.style.display = 'block';
    }
}

function nextTwoFactorStep() {
    const visibleStep = document.querySelector('.twofactor-step[style*="display: block"]');
    if (visibleStep) {
        const currentId = visibleStep.id;
        const stepNum = parseInt(currentId.split('-')[2]);
        if (stepNum < 3) {
            showTwoFactorStep(stepNum + 1);
        }
    }
}

function prevTwoFactorStep() {
    const visibleStep = document.querySelector('.twofactor-step[style*="display: block"]');
    if (visibleStep) {
        const currentId = visibleStep.id;
        const stepNum = parseInt(currentId.split('-')[2]);
        if (stepNum > 1) {
            showTwoFactorStep(stepNum - 1);
        }
    }
}

function activateTwoFactor() {
    const code = document.getElementById('twofactor-code').value;
    if (!code || code.length !== 6) {
        alert('Veuillez entrer un code à 6 chiffres valide.');
        return;
    }

    // In a real app, this would verify the code with the server
    alert('Authentification à deux facteurs activée avec succès !');
    closeTwoFactorModal();

    // Update UI
    const statusBadge = document.querySelector('.security-status__badge');
    if (statusBadge) {
        statusBadge.textContent = 'Activé';
        statusBadge.classList.remove('security-status__badge--inactive');
        statusBadge.classList.add('security-status__badge--active');
    }

    const activateBtn = document.querySelector('.security-status .btn');
    if (activateBtn) {
        activateBtn.textContent = 'Gérer';
        activateBtn.onclick = () => openTwoFactorModal();
    }
}

// Sessions Modal Functions
function openSessionsModal() {
    const modal = document.getElementById('sessions-modal');
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeSessionsModal() {
    const modal = document.getElementById('sessions-modal');
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }
}

function revokeSession(button) {
    const sessionItem = button.closest('.session-item');
    if (sessionItem && !sessionItem.classList.contains('session-item--current')) {
        if (confirm('Êtes-vous sûr de vouloir révoquer cette session ?')) {
            sessionItem.remove();
        }
    }
}

function revokeAllSessions() {
    if (confirm('Êtes-vous sûr de vouloir révoquer toutes les sessions ? Vous serez déconnecté de tous vos appareils.')) {
        const sessions = document.querySelectorAll('.session-item:not(.session-item--current)');
        sessions.forEach(session => session.remove());
        alert('Toutes les sessions ont été révoquées.');
        // In a real app, this would redirect to login
    }
}

// Integration functions
function connectGoogleDrive() {
    // In a real app, this would open OAuth flow
    alert('Connexion à Google Drive... (Simulation)');
    setTimeout(() => {
        const statusBadge = document.querySelector('.integration-item:nth-child(1) .integration-status__badge');
        if (statusBadge) {
            statusBadge.textContent = 'Connecté';
            statusBadge.classList.remove('integration-status__badge--inactive');
            statusBadge.classList.add('integration-status__badge--active');
        }
        const connectBtn = document.querySelector('.integration-item:nth-child(1) .btn');
        if (connectBtn) {
            connectBtn.textContent = 'Gérer';
        }
    }, 2000);
}

function connectSlack() {
    alert('Connexion à Slack... (Simulation)');
    setTimeout(() => {
        const statusBadge = document.querySelector('.integration-item:nth-child(2) .integration-status__badge');
        if (statusBadge) {
            statusBadge.textContent = 'Connecté';
            statusBadge.classList.remove('integration-status__badge--inactive');
            statusBadge.classList.add('integration-status__badge--active');
        }
        const connectBtn = document.querySelector('.integration-item:nth-child(2) .btn');
        if (connectBtn) {
            connectBtn.textContent = 'Gérer';
        }
    }, 2000);
}

function connectOutlook() {
    alert('Connexion à Outlook Calendar... (Simulation)');
    setTimeout(() => {
        const statusBadge = document.querySelector('.integration-item:nth-child(3) .integration-status__badge');
        if (statusBadge) {
            statusBadge.textContent = 'Connecté';
            statusBadge.classList.remove('integration-status__badge--inactive');
            statusBadge.classList.add('integration-status__badge--active');
        }
        const connectBtn = document.querySelector('.integration-item:nth-child(3) .btn');
        if (connectBtn) {
            connectBtn.textContent = 'Gérer';
        }
    }, 2000);
}

// Data export function
function exportData() {
    alert('Préparation de l\'export de vos données...');
    setTimeout(() => {
        // In a real app, this would trigger a download
        alert('Vos données ont été exportées. Vérifiez vos téléchargements.');
    }, 2000);
}

// Privacy policy function
function openPrivacyPolicy() {
    // In a real app, this would open a modal or redirect to privacy page
    alert('Ouverture de la politique de confidentialité...');
}

// Settings form handling
function initializeSettingsForm() {
    const settingsForm = document.getElementById('settings-form');
    if (!settingsForm) return;

    settingsForm.addEventListener('submit', (e) => {
        e.preventDefault();

        // Collect all form data
        const formData = new FormData(settingsForm);
        const data = Object.fromEntries(formData);

        // Save all settings
        Object.keys(data).forEach(key => {
            localStorage.setItem(`linkup-${key}`, data[key]);
        });

        // Show success message
        alert('Paramètres enregistrés avec succès !');
    });
}

function cancelChanges() {
    if (confirm('Êtes-vous sûr de vouloir annuler toutes les modifications ?')) {
        location.reload(); // Reload to reset all changes
    }
}

// Initialize all enhanced settings when DOM is loaded
function initializeEnhancedSettings() {
    if (!document.querySelector('.settings-section')) return;

    initializeThemeSelector();
    initializeLanguageSettings();
    initializeParticipationSettings();
    initializeNotificationSettings();
    initializeSettingsForm();
    initializeGoogleTranslate();
}

// Initialize enhanced settings when page loads
document.addEventListener('DOMContentLoaded', initializeEnhancedSettings);
