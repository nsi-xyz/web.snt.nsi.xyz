<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/UserRepository.php';
require_once __DIR__ . '/PlayerRepository.php';
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

    public function getByUser(User $user): array {
        $gameSessionRows = $this->database->getRowByCustomAttribut('game_sessions', 'host_id', $user->getId());
        $gameSessions = [];
        foreach ($gameSessionRows as $gameSessionRow) {
            $gameSession = new GameSession($gameSessionRow);
            $gameSession->setHost($user);
            $gameSessions[] = $gameSession;
        }
        return $gameSessions;
    }

    public function exists($param): bool {
        return ctype_digit($param) ? $this->database->getRowById('game_sessions', $param) !== null : $this->database->getRowByCustomAttribut('sessions', 'code', $param) !== null;
    }

    public function getOpenSessionsFor(User $user): array {
        $gameSessions = $this->getByUser($user);
        $gameSessionsOpen = [];
        foreach ($gameSessions as $gameSession) {
            if ($this->isOpen($gameSession->getId())) {
                $gameSessionsOpen[] = $gameSession;
            }
        }
        return $gameSessionsOpen;
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
            $openGameSession = new GameSession($openGameSessionRow);
            $openGameSession->setHost((new UserRepository($this->database))->getById($openGameSession->getHostId()));
            $openGameSessions[] = $openGameSession;
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
        return (new PlayerRepository($this->database))->getPlayers($gameSession->getId());
    }
}