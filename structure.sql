CREATE DATABASE IF NOT EXISTS xtjh1161_web_snt_nsi_xyz CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE xtjh1161_web_snt_nsi_xyz;

CREATE TABLE groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    hierarchy_level INT NOT NULL
);

CREATE TABLE group_permissions (
    group_id INT NOT NULL,
    permission_key VARCHAR(100) NOT NULL,
    PRIMARY KEY (group_id, permission_key),
    FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_connexion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    group_id INT,
    FOREIGN KEY (group_id) REFERENCES groups(id)
);

CREATE TABLE game_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(50) NOT NULL,
    host_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    started_at TIMESTAMP NULL DEFAULT NULL,
    duration INT,
    visibility ENUM('public', 'private') DEFAULT 'public',
    slots INT,
    access_scope ENUM('everyone', 'nobody') DEFAULT 'everyone',
    status INT,
    FOREIGN KEY (host_id) REFERENCES users(id)
);

CREATE TABLE game_session_players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(100) NOT NULL,
    game_session_id INT NOT NULL,
    event VARCHAR(100) NOT NULL,
    timestamping TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (game_session_id) REFERENCES game_sessions(id) ON DELETE CASCADE
);

CREATE TABLE translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    translation_key VARCHAR(100) NOT NULL,
    value TEXT NOT NULL,
    lang VARCHAR(10) NOT NULL,
    UNIQUE (translation_key, lang)
);

INSERT INTO `groups` (`id`, `name`, `hierarchy_level`) VALUES ('1', 'root', '0');
INSERT INTO `users` (`id`, `name`, `surname`, `username`, `password`, `created_at`, `last_update`, `last_connexion`, `group_id`) VALUES ('1', 'ADMIN', 'Admin', 'admin', '', current_timestamp(), current_timestamp(), current_timestamp(), '1');