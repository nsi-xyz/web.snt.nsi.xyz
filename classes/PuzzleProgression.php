<?php
require_once __DIR__ . '/SessionManager.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Page.php';
require_once __DIR__ . '/CookieManager.php';

class PuzzleProgression {
    private Database $database;
    private SessionManager $sessionManager;

    public function __construct(Database $database, SessionManager $sessionManager) {
        $this->database = $database;
        $this->sessionManager = $sessionManager;
        $this->initPuzzleProgression();
        $this->checkPuzzleCookies();
        $this->checkPuzzle10();
    }

    private function initPuzzleProgression(): void {
        if (!isset($_SESSION['puzzles_solved'])) {
            $_SESSION['puzzles_solved'] = [];
        }
    }

    private function checkPuzzleCookies(): void {
        $cookieManager = new CookieManager();
        if (!$this->isPuzzleSolved(7) && !$cookieManager->exists(COOKIE7['name'])) {
            $cookieManager->create(COOKIE7['name'], COOKIE7['value']);
        }
        if (!$this->isPuzzleSolved(8) && !$cookieManager->exists(COOKIE8['name'])) {
            $cookieManager->create(COOKIE8['name'], COOKIE8['value']);
        }
    }

    private function checkPuzzle10(): void {
        if (!isset($_SESSION['puzzle10'])) {
            $_SESSION['puzzle10'] = false;
        }
        if (!$_SESSION['puzzle10'] && Page::getCurrentPage() === 'puzzle10.php') {
            $_SESSION['puzzle10'] = true;
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

    public function isPuzzleSolved(int $puzzleId) {
        return in_array($puzzleId, $this->getPuzzlesSolved());
    }

    public function tickPuzzle($puzzleId): void {
        $_SESSION['puzzles_solved'][] = $puzzleId; 
    }
}