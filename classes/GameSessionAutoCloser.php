<?php
require_once __DIR__ . '/GameSessionRepository.php';

class GameSessionAutoCloser {
    public static function stopIfExpired(GameSessionRepository $gameSessionRepository): void {
        $openGameSessions = $gameSessionRepository->getOpenSessions();
        foreach ($openGameSessions as $openGameSession) {
            $now = new DateTime();
            $start = new DateTime($openGameSession->getCreatedAt());
            $duration = $openGameSession->getDuration();
            $end = (clone $start)->modify("+$duration seconds")->modify('+1 second');
            if ($now > $end) {
                $gameSessionRepository->stopSession($openGameSession->getId());
            }
        }
    }
}
