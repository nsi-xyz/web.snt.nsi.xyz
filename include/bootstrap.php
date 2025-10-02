<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/../classes/Database.php';
$db = new Database($dbAddress, $dbName, $dbUsername, $dbPassword);

require_once __DIR__ . '/../constants.php';
require_once __DIR__ . '/../classes/Permission.php';
require_once __DIR__ . '/../classes/UserRepository.php';
require_once __DIR__ . '/../classes/SessionManager.php';
require_once __DIR__ . '/../classes/Translator.php';
require_once __DIR__ . '/../classes/ControlAccess.php';
require_once __DIR__ . '/../classes/Page.php';
require_once __DIR__ . '/../classes/GameSessionAutoCloser.php';
require_once __DIR__ . '/../classes/PuzzleProgression.php';
require_once __DIR__ . '/../include/functions.php';
$session = new SessionManager($db);
$cookieManager = new CookieManager();
if (!$cookieManager->exists('PHPSESSID')) {
    $session->init();
} else {
    $session->start();
}
$translator = new Translator($db);
$translator->setLocale($session->getLocale());
$userRepository = new UserRepository($db);
$gameSessionRepository = new GameSessionRepository($db);
$puzzleProgression = new PuzzleProgression($db, $session);

// Check page access rights
ControlAccess::handlerPanelAccess($session, $translator, $gameSessionRepository);
ControlAccess::handlerLoginAccess($session, $translator);
// Stop finished sessions
GameSessionAutoCloser::stopIfExpired($gameSessionRepository);