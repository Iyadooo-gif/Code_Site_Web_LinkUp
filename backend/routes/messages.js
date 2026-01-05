const express = require('express');
const { db } = require('../models/database');

const router = express.Router();

// Récupérer les messages d'un cours
router.get('/:courseId', async (req, res) => {
    const courseId = req.params.courseId;

    try {
        const messages = await db.all(`
            SELECT *
            FROM messages
            WHERE course_id = ?
            ORDER BY sent_at ASC
        `, [courseId]);

        res.json(messages);
    } catch (error) {
        console.error('Erreur récupération messages:', error);
        res.status(500).json({ message: 'Erreur serveur' });
    }
});

// Envoyer un message
router.post('/', async (req, res) => {
    const { course_id, sender_name, content } = req.body;

    try {
        const result = await db.run(
            'INSERT INTO messages (course_id, sender_name, content) VALUES (?, ?, ?)',
            [course_id, sender_name, content]
        );

        const message = {
            id: result.lastInsertRowid,
            course_id,
            sender_name,
            content,
            sent_at: new Date().toISOString()
        };

        res.json(message);
    } catch (error) {
        console.error('Erreur envoi message:', error);
        res.status(500).json({ message: 'Erreur serveur' });
    }
});

module.exports = router;
