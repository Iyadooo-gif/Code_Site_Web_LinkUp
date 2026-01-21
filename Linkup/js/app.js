// app.js
const API_URL = "process-chat.php"; // Pointer vers le fichier PHP local
let currentCourse = null;
let currentUserName = "";

// Initialisation
document.addEventListener("DOMContentLoaded", () => {
  // Récupérer automatiquement le nom de l'utilisateur connecté via le header
  const sessionName = document
    .querySelector(".user-menu__name")
    ?.textContent.trim();
  if (sessionName) {
    currentUserName = sessionName;
    document.getElementById("username-display").textContent = currentUserName;
  }

  loadCourses();

  // Rafraîchir les messages toutes les 3 secondes (ajusté pour PHP)
  setInterval(() => {
    if (currentCourse) {
      loadMessages(currentCourse.id);
    }
  }, 3000);
});

// Demander le nom de l'utilisateur uniquement si non connecté
function askForName() {
  if (!currentUserName) {
    currentUserName = prompt("Entrez votre nom pour le chat:");
    if (!currentUserName) {
      currentUserName = "Anonyme";
    }
    document.getElementById("username-display").textContent = currentUserName;
  }
}

// Charger les activités (remplace les cours)
async function loadCourses() {
  try {
    // Ajout du paramètre action pour process-chat.php
    const response = await fetch(`${API_URL}?action=courses`);
    if (response.ok) {
      const courses = await response.json();
      displayCourses(courses);
    }
  } catch (error) {
    console.error("Erreur chargement activités:", error);
  }
}

function displayCourses(courses) {
  const list = document.getElementById("courses-list");
  if (!list) return;

  list.innerHTML = courses
    .map(
      (course) => `
        <div class="course-item" data-id="${course.id}" data-name="${course.name}">
            <strong>${course.name}</strong>
            <p style="font-size: 11px; color: #666; margin-top: 5px;">
                ${course.description ? course.description.substring(0, 50) + "..." : "Aucune description"}
            </p>
        </div>
    `,
    )
    .join("");

  // Ajouter les événements click
  list.querySelectorAll(".course-item").forEach((item) => {
    item.addEventListener("click", () => {
      const courseId = item.dataset.id;
      const courseName = item.dataset.name;
      selectCourse(courseId, courseName, item);
    });
  });
}

async function selectCourse(courseId, courseName, element) {
  currentCourse = { id: courseId, name: courseName };
  document.getElementById("course-name").textContent = courseName;

  await loadMessages(courseId);

  // Mettre à jour l'état actif visuel
  document.querySelectorAll(".course-item").forEach((item) => {
    item.classList.remove("active");
  });
  element.classList.add("active");
}

async function loadMessages(courseId) {
  try {
    // Ajout du paramètre action et course_id
    const response = await fetch(
      `${API_URL}?action=messages&course_id=${courseId}`,
    );
    if (response.ok) {
      const messages = await response.json();
      const container = document.getElementById("messages");

      const newContent = messages
        .map(
          (msg) =>
            `<div class="message ${msg.sender_name === currentUserName ? "sent" : "received"}">
                    <div class="message-content">${msg.content}</div>
                    <div class="message-meta">
                        ${msg.sender_name} - ${msg.sent_at}
                    </div>
                </div>`,
        )
        .join("");

      // Mise à jour fluide du scroll
      if (container.innerHTML !== newContent) {
        const wasAtBottom =
          container.scrollHeight - container.scrollTop <=
          container.clientHeight + 50;
        container.innerHTML = newContent;
        if (wasAtBottom) {
          container.scrollTop = container.scrollHeight;
        }
      }
    }
  } catch (error) {
    console.error("Erreur chargement messages:", error);
  }
}

async function sendMessage() {
  const input = document.getElementById("message-input");
  const content = input.value.trim();

  if (!content || !currentCourse) return;

  try {
    const response = await fetch(API_URL, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        course_id: currentCourse.id,
        content: content,
      }),
    });

    if (response.ok) {
      input.value = "";
      await loadMessages(currentCourse.id);
    }
  } catch (error) {
    console.error("Erreur envoi message:", error);
  }
}
