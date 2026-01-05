// ALTERNATIVE: Utilisez ce fichier si better-sqlite3 ne s'installe pas
// 1. Installez sqlite3: npm install sqlite3
// 2. Renommez ce fichier en database.js
// 3. Supprimez l'ancien database.js

const sqlite3 = require('sqlite3').verbose();
const path = require('path');

const db = new sqlite3.Database(path.join(__dirname, '../database.db'), (err) => {
    if (err) {
        console.error('Erreur connexion base de données:', err);
    } else {
        console.log('Connecté à la base de données SQLite');
    }
});

function initialize() {
    // Users table
    db.run(`
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            role TEXT NOT NULL CHECK(role IN ('student', 'instructor')),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    `);

    // Courses table
    db.run(`
        CREATE TABLE IF NOT EXISTS courses (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            description TEXT,
            instructor_id INTEGER NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (instructor_id) REFERENCES users(id)
        )
    `);

    // Enrollments table
    db.run(`
        CREATE TABLE IF NOT EXISTS enrollments (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            student_id INTEGER NOT NULL,
            course_id INTEGER NOT NULL,
            enrolled_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (student_id) REFERENCES users(id),
            FOREIGN KEY (course_id) REFERENCES courses(id),
            UNIQUE(student_id, course_id)
        )
    `);

    // Messages table
    db.run(`
        CREATE TABLE IF NOT EXISTS messages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            course_id INTEGER NOT NULL,
            sender_id INTEGER NOT NULL,
            receiver_id INTEGER NOT NULL,
            content TEXT NOT NULL,
            sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            read_at DATETIME,
            FOREIGN KEY (course_id) REFERENCES courses(id),
            FOREIGN KEY (sender_id) REFERENCES users(id),
            FOREIGN KEY (receiver_id) REFERENCES users(id)
        )
    `, (err) => {
        if (err) {
            console.error('Erreur initialisation base de données:', err);
        } else {
            console.log('Base de données initialisée');
        }
    });
}

// Wrapper pour compatibilité avec better-sqlite3
const dbWrapper = {
    prepare: (sql) => {
        return {
            run: (...params) => {
                return new Promise((resolve, reject) => {
                    db.run(sql, params, function(err) {
                        if (err) reject(err);
                        else resolve({ lastInsertRowid: this.lastID, changes: this.changes });
                    });
                });
            },
            get: (...params) => {
                return new Promise((resolve, reject) => {
                    db.get(sql, params, (err, row) => {
                        if (err) reject(err);
                        else resolve(row);
                    });
                });
            },
            all: (...params) => {
                return new Promise((resolve, reject) => {
                    db.all(sql, params, (err, rows) => {
                        if (err) reject(err);
                        else resolve(rows);
                    });
                });
            }
        };
    }
};

module.exports = {
    db: dbWrapper,
    initialize
};
