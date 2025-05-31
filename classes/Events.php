<?php
class Events {
    public const PLAYER_JOIN = 'player.join';
    public const PLAYER_HAS_SOLVED_PUZZLE = 'player.has.solved.puzzle';
    public const PLAYER_HAS_SOLVED_PUZZLE_1 = 'player.has.solved.puzzle.1';
    public const PLAYER_HAS_SOLVED_PUZZLE_2 = 'player.has.solved.puzzle.2';
    public const PLAYER_HAS_SOLVED_PUZZLE_3 = 'player.has.solved.puzzle.3';
    public const PLAYER_HAS_SOLVED_PUZZLE_4 = 'player.has.solved.puzzle.4';
    public const PLAYER_HAS_SOLVED_PUZZLE_5 = 'player.has.solved.puzzle.5';
    public const PLAYER_HAS_SOLVED_PUZZLE_6 = 'player.has.solved.puzzle.6';
    public const PLAYER_HAS_SOLVED_PUZZLE_7 = 'player.has.solved.puzzle.7';
    public const PLAYER_HAS_SOLVED_PUZZLE_8 = 'player.has.solved.puzzle.8';
    public const PLAYER_HAS_SOLVED_PUZZLE_9 = 'player.has.solved.puzzle.9';
    public const PLAYER_HAS_SOLVED_PUZZLE_10 = 'player.has.solved.puzzle.10';

    private static array $definitions = [
        self::PLAYER_JOIN => [
            'description' => "A rejoint la session"
        ],
        self::PLAYER_HAS_SOLVED_PUZZLE_1 => [
            'description' => "A réussi l'énigme 1"
        ],
        self::PLAYER_HAS_SOLVED_PUZZLE_2 => [
            'description' => "A réussi l'énigme 2"
        ],
        self::PLAYER_HAS_SOLVED_PUZZLE_3 => [
            'description' => "A réussi l'énigme 3"
        ],
        self::PLAYER_HAS_SOLVED_PUZZLE_4 => [
            'description' => "A réussi l'énigme 4"
        ],
        self::PLAYER_HAS_SOLVED_PUZZLE_5 => [
            'description' => "A réussi l'énigme 5"
        ],
        self::PLAYER_HAS_SOLVED_PUZZLE_6 => [
            'description' => "A réussi l'énigme 6"
        ],
        self::PLAYER_HAS_SOLVED_PUZZLE_7 => [
            'description' => "A réussi l'énigme 7"
        ],
        self::PLAYER_HAS_SOLVED_PUZZLE_8 => [
            'description' => "A réussi l'énigme 8"
        ],
        self::PLAYER_HAS_SOLVED_PUZZLE_9 => [
            'description' => "A réussi l'énigme 9"
        ],
        self::PLAYER_HAS_SOLVED_PUZZLE_10 => [
            'description' => "A réussi l'énigme 10"
        ]
    ];

    public static function all(): array {
        return array_keys(self::$definitions);
    }

    public static function getDescription(string $event): ?string {
        return self::$definitions[$event]['description'] ?? null;
    }

    public static function getAllWithDetails(): array {
        return self::$definitions;
    }
}
