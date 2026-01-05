const express = require('express');
const bcrypt = require('bcrypt');
const { db } = require('../models/database');

const router = express.Router();

// Inscription
router.post('/register', async (req, res) => {
    const { username, password, role } = req.body;

    if (!username || !password || !role) {
        return res.status(400).json({ message: 'Tous les champs sont requis' });
    }

    if (!['student', 'instructor'].includes(role)) {
        return res.status(400).json({ message: 'Rôle invalide' });
    }

    try {
        const hashedPassword = await bcrypt.hash(password, 10);

        const result = await db.run(
            'INSERT INTO users (username, password, role) VALUES (?, ?, ?)',
            [username, hashedPassword, role]
        );

        req.session.userId = result.lastInsertRowid;
        req.session.role = role;

        res.json({
            id: result.lastInsertRowid,
            username,
            role
        });
    } catch (error) {
        if (error.message.includes('UNIQUE')) {
            res.status(400).json({ message: 'Nom d\'utilisateur déjà pris' });
        } else {
            console.error('Erreur register:', error);
            res.status(500).json({ message: 'Erreur serveur' });
        }
    }
});

// Connexion
router.post('/login', async (req, res) => {
    const { username, password } = req.body;

    try {
        const user = await db.get('SELECT * FROM users WHERE username = ?', [username]);

        if (!user) {
            return res.status(401).json({ message: 'Identifiants incorrects' });
        }

        const validPassword = await bcrypt.compare(password, user.password);
        if (!validPassword) {
            return res.status(401).json({ message: 'Identifiants incorrects' });
        }

        req.session.userId = user.id;
        req.session.role = user.role;

        res.json({
            id: user.id,
            username: user.username,
            role: user.role
        });
    } catch (error) {
        console.error('Erreur login:', error);
        res.status(500).json({ message: 'Erreur serveur' });
    }
});

// Déconnexion
router.post('/logout', (req, res) => {
    req.session.destroy();
    res.json({ message: 'Déconnexion réussie' });
});

// Utilisateur actuel
router.get('/me', async (req, res) => {
    if (!req.session.userId) {
        return res.status(401).json({ message: 'Non authentifié' });
    }

    try {
        const user = await db.get('SELECT id, username, role FROM users WHERE id = ?', [req.session.userId]);
        res.json(user);
    } catch (error) {
        console.error('Erreur me:', error);
        res.status(500).json({ message: 'Erreur serveur' });
    }
});

module.exports = router;
