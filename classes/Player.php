<?php
require_once __DIR__ . '/GameSession.php';

class Player {
    private string $pseudo;
    private int $gameSessionId;
    private ?GameSession $gameSession = null;
    private array $events;

    public function __construct(string $pseudo, int $gameSessionId, array $events) {
        $this->pseudo = $pseudo;
        $this->gameSessionId = $gameSessionId;
        $this->events = $events;
    }

    public function getPseudo(): string {
        return $this->pseudo;
    }

    public function getGameSessionId(): int {
        return $this->gameSessionId;
    }

    public function getGameSession(): GameSession {
        return $this->gameSession;
    }

    public function setGameSession(GameSession $gameSession): void {
        $this->gameSession = $gameSession;
    }
}