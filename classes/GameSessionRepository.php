<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/UserRepository.php';
require_once __DIR__ . '/GameSession.php';
require_once __DIR__ . '/User.php';

class GameSessionRepository {
    private Database $database;
    private ?User $actor;

    public function __construct(Database $database, ?User $actor = null) {
        $this->database = $database;
        $this->actor = $actor;
    }

    public function create(User $user): int {
        if ($this->actor !== null || !$this->actor->hasPermission(Permission::USER_CREATE)) {
            return -1; // Permission insuffisante
        }
        return 0;
    }

    public function getById($gameSessionId): ?GameSession {
        $gameSessionRow = $this->database->getRowById('game_sessions', $gameSessionId);
        if ($gameSessionRow) {
            $gameSession = new GameSession($gameSessionRow);
            $gameSessionHost = (new UserRepository($this->database))->getById($gameSession->getHostId());
            $gameSession->setHost($gameSessionHost);
            return $gameSession;
        }
        return null;
    }

    public function getByCode($gameSessionCode): ?GameSession {
        $gameSessionRow = $this->database->getRowByCustomAttribut('game_sessions', 'code', $gameSessionCode);
        if ($gameSessionRow) {
            $gameSession = new GameSession($gameSessionRow);
            $gameSessionHost = (new UserRepository($this->database))->getById($gameSession->getHostId());
            $gameSession->setHost($gameSessionHost);
            return $gameSession;
        }
        return null;
    }

    public function exists($param): bool {
        return ctype_digit($param) ? $this->database->getRowById('game_sessions', $param) !== null : $this->database->getRowByCustomAttribut('sessions', 'code', $param) !== null;
    }

    public function hasOpenSessionFor(User $user): bool {
        $gameSessions = $this->database->getRowsByCondition('game_sessions', ['host_id' => ['=', $user->getId()], 'status' => ['>', 0]]);
        return !empty($gameSessions);
    }

    public function getOpenSessions(): array {
        $openGameSessionsRows = $this->database->getRowsByCondition('game_sessions', ['status' => ['>', 0]]);
        if ($openGameSessionsRows === null) return [];
        $openGameSessions = [];
        foreach ($openGameSessionsRows as $openGameSessionRow) {
            $openGameSessions[] = new GameSession($openGameSessionRow);
        }
        return $openGameSessions;
    }

    public function isOpen(int $gameSessionId): bool {
        $gameSessionRow = $this->database->getRowById('game_sessions', $gameSessionId);
        return $gameSessionRow === null ? false : (new GameSession($gameSessionRow))->getStatus() > 0;
    }

    public function stopSession(int $gameSessionId): void {
        $this->database->updateRow('game_sessions', ['status' => 0], "id = $gameSessionId");
    }

    public function getPlayers(GameSession $gameSession): array {
        $players = $this->database;
        return [];
    }
}