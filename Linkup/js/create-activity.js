// Script pour gérer les tags de l'activité
(function () {
  // Récupère les éléments HTML
  const input = document.getElementById("tag-input"); // Champ de saisie du tag
  const addBtn = document.getElementById("tag-add-btn"); // Bouton "Ajouter"
  const list = document.getElementById("selected-tags"); // Zone d'affichage des tags
  const hidden = document.getElementById("tags-hidden"); // Champ caché pour envoyer les tags au serveur
  const tags = new Set(); // Stocke les tags (Set évite les doublons)

  // Affiche des messages de débogage dans la console
  console.log("Tag input:", input);
  console.log("Add button:", addBtn);
  console.log("List container:", list);

  // Fonction qui affiche les tags sous forme de petites bulles
  function render() {
    console.log("Rendering tags:", Array.from(tags));
    list.innerHTML = ""; // Vide la liste avant de la remplir
    
    // Pour chaque tag, crée une bulle avec un bouton X pour supprimer
    tags.forEach((tag) => {
      const chip = document.createElement("span");
      chip.className = "tag-chip"; // Style de la bulle

      const label = document.createElement("span");
      label.textContent = tag; // Texte du tag
      chip.appendChild(label);

      // Bouton X pour supprimer le tag
      const remove = document.createElement("button");
      remove.type = "button";
      remove.className = "tag-chip__remove";
      remove.textContent = "×";
      remove.addEventListener("click", (e) => {
        e.preventDefault();
        tags.delete(tag); // Supprime le tag
        render(); // Rafraîchit l'affichage
      });

      chip.appendChild(remove);
      list.appendChild(chip);
    });
    
    // Met à jour le champ caché avec tous les tags séparés par des virgules
    hidden.value = Array.from(tags).join(",");
    console.log("Hidden field value:", hidden.value);
  }

  // Fonction pour ajouter un tag depuis le champ de saisie
  function addTagFromInput() {
    const value = input.value.trim(); // Récupère et nettoie la valeur
    console.log("Adding tag:", value);
    if (value) {
      tags.add(value); // Ajoute le tag à la liste
      input.value = ""; // Vide le champ de saisie
      render(); // Rafraîchit l'affichage
    }
  }

  // Si des tags existent déjà (après rechargement), les recharge
  if (hidden.value) {
    hidden.value.split(",").forEach((t) => {
      const clean = t.trim();
      if (clean) {
        tags.add(clean);
      }
    });
    render();
  }

  // Ajoute un tag quand on appuie sur Entrée
  if (input) {
    input.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        e.preventDefault();
        addTagFromInput();
      }
    });

    // Ajoute un tag quand on sélectionne depuis la liste de suggestions
    input.addEventListener("change", () => {
      addTagFromInput();
    });
  }

  // Ajoute un tag quand on clique sur le bouton "Ajouter"
  if (addBtn) {
    addBtn.addEventListener("click", (e) => {
      e.preventDefault();
      addTagFromInput();
    });
  }
})();
