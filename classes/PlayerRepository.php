<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/GameSessionRepository.php';
require_once __DIR__ . '/Player.php';

class PlayerRepository {
    private Database $database;

    public function __construct(Database $database) {
        $this->database = $database;
    }

    public function getByPseudoId(string $playerGameSessionPseudo, int $playerGameSessionId): ?Player {
        $playerEventsRows = $this->database->getEventsByPlayer($playerGameSessionPseudo, $playerGameSessionId);
        if ($playerEventsRows) {
            $playerEvents = [];
            foreach ($playerEventsRows as $playerEventsRow) {
                $playerEvents[] = new PlayerEvent(new Event($playerEventsRow['event']), $playerEventsRow['timestamping']);
            }
            $player = new Player($playerGameSessionPseudo, $playerGameSessionId, $playerEvents);
            $player->setGameSession(new GameSession($this->database->getRowById('game_sessions', $playerGameSessionId)));
            return $player;
        }
        return null;
    }
}