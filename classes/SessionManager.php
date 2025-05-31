<?php
require_once __DIR__ . '/CookieManager.php';
require_once __DIR__ . '/UserRepository.php';
require_once __DIR__ . '/Guest.php';

class SessionManager {
    private Database $database;
    private CookieManager $cookieManager;
    private UserRepository $userRepository;
    private GameSessionRepository $gameSessionRepository;

    public function __construct(Database $database) {
        $this->database = $database;
        $this->cookieManager = new CookieManager();
        $this->userRepository = new UserRepository($this->database);
        $this->gameSessionRepository = new GameSessionRepository($this->database);
    }

    public function start(): void {
        session_start();
        $this->initLocale();
        $this->initCurrentUser();
    }

    public function init(): void {
        session_set_cookie_params(GAMESESSION_DURATION);
        session_start();
        session_regenerate_id();
        $_SESSION['session_start_time'] = time();
        $cookies = array(COOKIECHOCOLAT, COOKIECHOCOLATINE, COOKIEHAZLENUT, COOKIESESSION, COOKIEPUBLICITAIRE, COOKIEGOOGLE, COOKIEFACEBOOK, COOKIEAMAZON);
        $cookieManager = new CookieManager();
          for ($i = 0; $i < count($cookies); $i++) {
            $cookie = $cookies[$i];
            $cookieManager->create($cookie['name'], $cookie['value']);
        }
        $this->initLocale();
        $this->initCurrentUser();
    }

    public function getLocale(): string {
        return $_SESSION['locale'];
    }

    private function initLocale(): void {
        if (isset($_GET['lang'])) {
            $_SESSION['locale'] = $_GET['lang'];
        } elseif (!isset($_SESSION['locale'])) {
            $_SESSION['locale'] = DEFAULT_LOCALE;
        }
    }

    private function initCurrentUser(): void {
        $authCookieExists = $this->authCookieExists();
        if ($this->getCurrentUser() === null && !$authCookieExists) {
            $this->setCurrentUser(new Guest());
        } elseif ($this->currentUserIsUser() && !$authCookieExists && $this->getStayConnected()) {
            $this->createAuthCookie();
        }
        if ($authCookieExists) {
            [$username, $hashedPassword] = $this->getAuthCookieData();
            if ($this->userRepository->canLoginWithHashedPassword($username, $hashedPassword)) {
                $user = $this->userRepository->getByUsername($username);
                $this->setCurrentUser($user);
            } else {
                $this->setCurrentUser(new Guest());
            }
        } elseif ($this->currentUserIsUser()) {
            $user = $this->getCurrentUser();
            $userDb = $this->userRepository->getById($user->getId());
            if ($userDb === null) {
                $this->setCurrentUser(new Guest());
            } elseif (!$user->equals($userDb)) {
                $this->setCurrentUser($userDb);
            }
        }
        if ($this->currentUserIsPlayer()) {
            $player = $this->getCurrentUser();
            if (!$this->gameSessionRepository->isOpen($player->getGameSession()->getId())) {
                $this->setCurrentUser(new Guest());
            }
        }
    }

    private function getAuthCookieData(): array {
        $value = $this->cookieManager->read(AUTHCOOKIE_NAME);
        $data = explode('_', $value);
        if (count($data) !== 2) {
            return ['', ''];
        }
        return $data;
    }

    public function setStayConnected(bool $status): void {
        $_SESSION['stay_connected'] = $status;
    }

    private function authCookieExists(): bool {
        $cookieManager = new CookieManager();
        return $cookieManager->exists('LOGGED_IN');
    }

    private function createAuthCookie(): void {
        $currentUserUsername = $this->getCurrentUser()->getUsername();
        $currentUserHashedPassword = $this->getCurrentUser()->getHashedPassword();
        $cookieManager = new CookieManager();
        $cookieManager->create(AUTHCOOKIE_NAME, "{$currentUserUsername}_" . urlencode($currentUserHashedPassword), AUTHCOOKIE_DURATION);
    }

    public function getStayConnected(): bool {
        return isset($_SESSION['stay_connected']) && $_SESSION['stay_connected'] === true;
    }

    public function getSessionStartTime(): int {
        return $_SESSION['session_start_time'];
    }

    public function setCurrentUser(User|Player|Guest $param): void {
        $_SESSION['current_user'] = $param;
    }

    public function getCurrentUser(): User|Player|Guest|null {
        return $_SESSION['current_user'] ?? null;
    }

    public function currentUserIsUser(): bool {
        return isset($_SESSION['current_user']) && $_SESSION['current_user'] instanceof User;
    }

    public function currentUserIsPlayer(): bool {
        return isset($_SESSION['current_user']) && $_SESSION['current_user'] instanceof Player;
    }

    public function currentUserIsGuest(): bool {
        return isset($_SESSION['current_user']) && $_SESSION['current_user'] instanceof Guest;
    }

}