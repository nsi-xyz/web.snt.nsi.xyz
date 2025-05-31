<?php
require_once __DIR__ . '/SessionManager.php';
require_once __DIR__ . '/Database.php';

class PuzzleProgression {
    private Database $database;
    private SessionManager $sessionManager;

    public function __construct(Database $database, SessionManager $sessionManager) {
        $this->database = $database;
        $this->sessionManager = $sessionManager;
        $this->initPuzzleProgression();
    }

    private function initPuzzleProgression(): void {
        if (!isset($_SESSION['puzzles_solved'])) {
            $_SESSION['puzzles_solved'] = [];
        }
    }

    public function getPuzzlesSolved(): array {
        if ($this->sessionManager->currentUserIsGuest() || $this->sessionManager->currentUserIsUser()) {
            return $_SESSION['puzzles_solved'];
        } elseif ($this->sessionManager->currentUserIsPlayer()) {
            $puzzlesSolved = [];
            $playerRows = $this->database->getEventsByPlayer($this->sessionManager->getCurrentUser()->getPseudo(), $this->sessionManager->getCurrentUser()->getGameSession()->getId());
            foreach ($playerRows as $playerRow) {
                if (str_contains($playerRow['event'], Events::PLAYER_HAS_SOLVED_PUZZLE)) {
                    $puzzlesSolved[] = (int)substr($playerRow['event'], -1);
                }
            }
            sort($puzzlesSolved);
            return $puzzlesSolved;
        }
        return [];
    }

    public function tickPuzzle($puzzleId): void {
        $_SESSION['puzzles_solved'][] = $puzzleId; 
    }
}