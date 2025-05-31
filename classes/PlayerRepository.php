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

    public function getPlayers(int $gameSessionId): array {
        $players = [];
        $playersGameSessionRows = $this->database->getRowsByUniqueSet('game_session_players', ['pseudo'], "game_session_id = $gameSessionId");
        if ($playersGameSessionRows === null) return $players;
        foreach ($playersGameSessionRows as $playersGameSessionRow) {
            $players[] = $this->getByPseudoId($playersGameSessionRow['pseudo'], $gameSessionId);
        }
        return $players;
    }

    public function isPlayerInGameSession(Player $player): bool {
        $players = $this->getPlayers($player->getGameSessionId());
        foreach ($players as $existingPlayer) {
            if ($existingPlayer->getPseudo() === $player->getPseudo() && $existingPlayer->getGameSessionId() === $player->getGameSessionId()) {
                return true;
            }
        }
        return false;
    }
}