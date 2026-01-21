<?php
require_once 'config.php';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LinkUp - Messagerie</title>
    <link rel="stylesheet" href="css/style.css" /> 
    <link rel="stylesheet" href="stylechat.css" />
</head>
  <body>
    <?php include 'header.php'; ?>
    <div class="container">
      <div class="sidebar">
        <div class="user-info">
          <span id="username-display">Invité</span>
        </div>

        <h3>Cours disponibles</h3>
        <div id="courses-list"></div>
      </div>

      <!-- Chatbox centrale -->
      <div class="chat-container">
        <div class="chat-header">
          <h2 id="course-name">Sélectionnez un cours</h2>
        </div>
        <div class="messages-container" id="messages"></div>
        <div class="message-input-container">
          <input
            type="text"
            id="message-input"
            placeholder="Tapez votre message..."
          />
          <button onclick="sendMessage()">Envoyer</button>
        </div>
      </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="app.js"></script>
  </body>
</html>
