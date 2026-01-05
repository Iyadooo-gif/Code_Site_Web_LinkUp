const express = require('express');
const { db } = require('../models/database');

const router = express.Router();

// Liste des cours disponibles
router.get('/', async (req, res) => {
    try {
        const courses = await db.all('SELECT * FROM courses');
        res.json(courses);
    } catch (error) {
        console.error('Erreur liste cours:', error);
        res.status(500).json({ message: 'Erreur serveur' });
    }
});

// Détails d'un cours
router.get('/:id', async (req, res) => {
    try {
        const course = await db.get('SELECT * FROM courses WHERE id = ?', [req.params.id]);

        if (!course) {
            return res.status(404).json({ message: 'Cours non trouvé' });
        }

        res.json(course);
    } catch (error) {
        console.error('Erreur détails cours:', error);
        res.status(500).json({ message: 'Erreur serveur' });
    }
});

module.exports = router;
