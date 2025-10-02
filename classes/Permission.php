<?php
class Permission {
    public const USER_CREATE = 'user.create';
    public const USER_DELETE = 'user.delete';
    public const USER_UPDATE_NAME = 'user.update.name';
    public const USER_UPDATE_SURNAME = 'user.update.surname';
    public const USER_UPDATE_USERNAME = 'user.update.username';
    public const USER_UPDATE_GROUP = 'user.update.group';
    public const USER_UPDATE_PASSWORD = 'user.update.password';
    public const SESSION_CREATE_SHORT = 'session.create.short';
    public const SESSION_CREATE_LONG = 'session.create.long';
    public const ACCESS_SESSIONS_EXPLORER = 'access.sessions.explorer';
    public const ACCESS_USER_ACCOUNT_MANAGER = 'access.user.account.manager';
    public const ACCESS_TRADS_MANAGER = 'access.trads.manager';
    public const ACCESS_GROUPS_MANAGER = 'access.groups.manager';
    public const ACCESS_PUZZLES_MANAGER = 'access.puzzles.manager';
    public const VIEW_GLOBAL_STATS = 'view.global.stats';

    // 0: Low
    // 1: Medium
    // 2: High
    // 3: Critical
    private static array $definitions = [
        self::USER_CREATE => [
            'description' => "Créer un nouvel utilisateur",
            'level' => 2,
        ],
        self::USER_DELETE => [
            'description' => "Supprimer un utilisateur",
            'level' => 2,
        ],
        self::USER_UPDATE_NAME => [
            'description' => "Modifier le prénom d'un utilisateur",
            'level' => 1,
        ],
        self::USER_UPDATE_SURNAME => [
            'description' => "Modifier le nom de famille d'un utilisateur",
            'level' => 1,
        ],
        self::USER_UPDATE_USERNAME => [
            'description' => "Modifier le nom d'utilisateur",
            'level' => 2,
        ],
        self::USER_UPDATE_GROUP => [
            'description' => "Modifier le rôle d'un utilisateur",
            'level' => 2,
        ],
        self::USER_UPDATE_PASSWORD => [
            'description' => "Changer le mot de passe",
            'level' => 3,
        ],
        self::SESSION_CREATE_SHORT => [
            'description' => "Créer une session courte",
            'level' => 0,
        ],
        self::SESSION_CREATE_LONG => [
            'description' => "Créer une session longue",
            'level' => 0,
        ],
        self::ACCESS_SESSIONS_EXPLORER => [
            'description' => "Accéder à l'explorateur de sessions",
            'level' => 2,
        ],
        self::ACCESS_USER_ACCOUNT_MANAGER => [
            'description' => "Accéder à la gestion des utilisateurs",
            'level' => 3,
        ],
        self::ACCESS_TRADS_MANAGER => [
            'description' => "Accéder à la gestion des traductions",
            'level' => 3,
        ],
        self::ACCESS_GROUPS_MANAGER => [
            'description' => "Accéder à la gestion des rôles",
            'level' => 3,
        ],
        self::ACCESS_PUZZLES_MANAGER => [
            'description' => "Accéder à la gestion des énigmes",
            'level' => 3,
        ],
        self::VIEW_GLOBAL_STATS => [
            'description' => "Permet de voir les statistiques globales du site web",
            'level' => 1,
        ]
    ];

    public static function all(): array {
        return array_keys(self::$definitions);
    }

    public static function getDescription(string $permission): ?string {
        return self::$definitions[$permission]['description'] ?? null;
    }

    public static function getLevel(string $permission): ?int {
        return self::$definitions[$permission]['level'] ?? null;
    }

    public static function getAllWithDetails(): array {
        return self::$definitions;
    }
}
