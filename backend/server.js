const express = require('express');
const cors = require('cors');
const path = require('path');

const app = express();

// Middleware
app.use(cors());
app.use(express.json());

// Initialiser la base de données
const db = require('./models/database');
db.initialize();

// Routes
const courseRoutes = require('./routes/courses');
const messageRoutes = require('./routes/messages');

app.use('/api/courses', courseRoutes);
app.use('/api/messages', messageRoutes);

// Servir les fichiers statiques du frontend
app.use(express.static(path.join(__dirname, '../frontend')));

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Serveur démarré sur le port ${PORT}`);
});
