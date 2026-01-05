const API_URL = 'http://localhost:3000/api';
let currentCourse = null;
let currentUserName = '';

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    loadCourses();
    setInterval(() => {
        if (currentCourse) {
            loadMessages(currentCourse.id);
        }
    }, 2000); // Rafraîchir les messages toutes les 2 secondes
});

// Demander le nom de l'utilisateur
function askForName() {
    if (!currentUserName) {
        currentUserName = prompt('Entrez votre nom:');
        if (!currentUserName) {
            currentUserName = 'Anonyme';
        }
        document.getElementById('username-display').textContent = currentUserName;
    }
}

// Charger les cours
async function loadCourses() {
    try {
        const response = await fetch(`${API_URL}/courses`);
        if (response.ok) {
            const courses = await response.json();
            displayCourses(courses);
        }
    } catch (error) {
        console.error('Erreur chargement cours:', error);
    }
}

function displayCourses(courses) {
    const list = document.getElementById('courses-list');
    list.innerHTML = courses.map(course => `
        <div class="course-item" data-id="${course.id}" data-name="${course.name}">
            <strong>${course.name}</strong>
            <p style="font-size: 12px; color: #666; margin-top: 5px;">
                ${course.description || ''}
            </p>
        </div>
    `).join('');

    // Ajouter les événements click
    list.querySelectorAll('.course-item').forEach(item => {
        item.addEventListener('click', () => {
            const courseId = item.dataset.id;
            const courseName = item.dataset.name;
            selectCourse(courseId, courseName, item);
        });
    });
}

async function selectCourse(courseId, courseName, element) {
    askForName();

    currentCourse = { id: courseId, name: courseName };
    document.getElementById('course-name').textContent = courseName;

    await loadMessages(courseId);

    // Mettre à jour l'état actif
    document.querySelectorAll('.course-item').forEach(item => {
        item.classList.remove('active');
    });
    element.classList.add('active');
}

async function loadMessages(courseId) {
    try {
        const response = await fetch(`${API_URL}/messages/${courseId}`);
        if (response.ok) {
            const messages = await response.json();
            const container = document.getElementById('messages');

            // Ne mettre à jour que si le contenu change
            const newContent = messages.map(msg =>
                `<div class="message ${msg.sender_name === currentUserName ? 'sent' : 'received'}">
                    <div class="message-content">${msg.content}</div>
                    <div class="message-meta">
                        ${msg.sender_name} - ${new Date(msg.sent_at).toLocaleString('fr-FR', {
                            hour: '2-digit',
                            minute: '2-digit'
                        })}
                    </div>
                </div>`
            ).join('');

            if (container.innerHTML !== newContent) {
                const wasAtBottom = container.scrollHeight - container.scrollTop <= container.clientHeight + 50;
                container.innerHTML = newContent;
                if (wasAtBottom) {
                    container.scrollTop = container.scrollHeight;
                }
            }
        }
    } catch (error) {
        console.error('Erreur chargement messages:', error);
    }
}

async function sendMessage() {
    askForName();

    const input = document.getElementById('message-input');
    const content = input.value.trim();

    if (!content || !currentCourse) return;

    try {
        const response = await fetch(`${API_URL}/messages`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                course_id: currentCourse.id,
                sender_name: currentUserName,
                content
            })
        });

        if (response.ok) {
            input.value = '';
            await loadMessages(currentCourse.id);
        }
    } catch (error) {
        console.error('Erreur envoi message:', error);
    }
}
