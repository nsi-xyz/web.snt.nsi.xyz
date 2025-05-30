<?php
require_once __DIR__ . '/SessionManager.php';
require_once __DIR__ . '/Translator.php';
require_once __DIR__ . '/GameSessionRepository.php';
require_once __DIR__ . '/FlashMessenger.php';
require_once __DIR__ . '/Redirector.php';

class ControlAccess {
    public static function handlePanelAccess(SessionManager $session, Translator $translator, GameSessionRepository $gameSessionRepository): void {
        $currentPage = basename($_SERVER['PHP_SELF']);
        $inPanel = str_contains($_SERVER['PHP_SELF'], 'panel');
        $sessionCode = $_GET['session'] ?? null;
        $sessionExists = $sessionCode && $gameSessionRepository->exists($sessionCode);
        $user = $session->getCurrentUser();
        if ($inPanel) {
            if ($currentPage === 'stats.php' && isset($_GET['share']) && $sessionExists) {
                return;
            }
            $canAccess = false;
            if ($session->currentUserIsUser()) {
                switch ($currentPage) {
                    case 'index.php':
                        $canAccess = true;
                        break;
                    case 'session.php':
                        $canAccess = true;
                        break;
                    case 'stats.php':
                        $canAccess = true;
                        break;
                    case 'myaccount.php':
                        $canAccess = true;
                        break;
                    case 'sessions.php':
                        $canAccess = $user->hasPermission(Permission::ACCESS_SESSIONS_EXPLORER);
                        break;
                    case 'users.php':
                        $canAccess = $user->hasPermission(Permission::ACCESS_USER_ACCOUNT_MANAGER);
                        break;
                    case 'trads.php':
                        $canAccess = $user->hasPermission(Permission::ACCESS_TRADS_MANAGER);
                        break;
                    case 'groups.php':
                        $canAccess = $user->hasPermission(Permission::ACCESS_GROUPS_MANAGER);
                        break;
                    case 'puzzles.php':
                        $canAccess = $user->hasPermission(Permission::ACCESS_PUZZLES_MANAGER);
                        break;
                }
            } elseif ($session->currentUserIsPlayer()) {
                $canAccess = false;
            } elseif ($session->currentUserIsGuest()) {
                $canAccess = false;
            } else {
                $canAccess = false;
            }
            if (!$canAccess) {
                FlashMessenger::error($translator->getMessage('error_not_authorized_message'));
                Redirector::to('../login.php');
            }
        }
    }
}
