<?php
require_once __DIR__ . '/SessionManager.php';
require_once __DIR__ . '/Translator.php';
require_once __DIR__ . '/GameSessionRepository.php';
require_once __DIR__ . '/FlashMessenger.php';
require_once __DIR__ . '/Redirector.php';
require_once __DIR__ . '/Page.php';
require_once __DIR__ . '/../exceptions/UnauthorizedException.php';
require_once __DIR__ . '/../exceptions/MissingPermissionException.php';

class ControlAccess {
    public static function handlerPanelAccess(SessionManager $session, Translator $translator, GameSessionRepository $gameSessionRepository): void {
        $currentPage = Page::getCurrentPage();
        $inPanel = Page::inPanel();
        if (!$inPanel) return;
        $sessionCode = $_GET['session'] ?? null;
        if ($currentPage === 'stats.php' && isset($_GET['share']) && $gameSessionRepository->exists($sessionCode)) {
            return;
        }
        $user = $session->getCurrentUser();
        $canAccess = false;
        $permissionsMap = [
            'sessions.php' => Permission::ACCESS_SESSIONS_EXPLORER,
            'users.php' => Permission::ACCESS_USER_ACCOUNT_MANAGER,
            'trads.php' => Permission::ACCESS_TRADS_MANAGER,
            'groups.php' => Permission::ACCESS_GROUPS_MANAGER,
            'puzzles.php' => Permission::ACCESS_PUZZLES_MANAGER
        ];
        if ($session->currentUserIsUser()) {
            if (isset($permissionsMap[$currentPage])) {
                $canAccess = $user->hasPermission($permissionsMap[$currentPage]);
            } else {
                $canAccess = true; 
            }
        }
        if (!$canAccess) {
            throw new MissingPermissionException($permissionsMap[$currentPage], $translator->getMessage('error_not_authorized_message'));
        }
    }

    public static function handlerLoginAccess(SessionManager $session, Translator $translator): void {
        $currentPage = Page::getCurrentPage();
        if ($currentPage === 'login.php') {
            if ($session->currentUserIsUser()) {
                Redirector::to('./panel/');
            } elseif ($session->currentUserIsPlayer()) {
                throw new UnauthorizedException($translator->getMessage('error_player_already_in_session'));
            }
        }
    }
}
