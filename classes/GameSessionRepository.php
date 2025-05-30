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
        $gameSessionRow = $this->database->getRowById('sessions', $gameSessionId);
        if ($gameSessionRow) {
            $gameSession = new GameSession($gameSessionRow);
            $gameSessionHost = (new UserRepository($this->database))->getById($gameSession->getHostId());
            $gameSession->setHost($gameSessionHost);
            return $gameSession;
        }
        return null;
    }

    public function getByCode($gameSessionCode): ?GameSession {
        $gameSessionRow = $this->database->getRowByCustomAttribut('sessions', 'code', $gameSessionCode);
        if ($gameSessionRow) {
            $gameSession = new GameSession($gameSessionRow);
            $gameSessionHost = (new UserRepository($this->database))->getById($gameSession->getHostId());
            $gameSession->setHost($gameSessionHost);
            return $gameSession;
        }
        return null;
    }

    public function exists($param): bool {
        return ctype_digit($param) ? $this->database->getRowById('sessions', $param) !== null : $this->database->getRowByCustomAttribut('sessions', 'code', $param) !== null;
    }

    public function hasOpenSessionFor(User $user): bool {
        $gameSessions = $this->database->getRowsByCondition('sessions', ['host_id' => ['=', $user->getId()], 'status' => ['>', 0]]);
        return !empty($gameSessions);
    }
}