<?php
require_once __DIR__ . '/SessionManager.php';
require_once __DIR__ . '/UserRepository.php';

class LastConnexionUpdater {
    public static function updateLastConnexion(SessionManager $session, UserRepository $userRepository): void {
        if ($session->currentUserIsUser()) {
            $user = $session->getCurrentUser();
            $timeUserLastConnexion = new DateTime($user->getLastConnexion());
            $timeNow = new DateTime();
            $interval = $timeNow->diff($timeUserLastConnexion);
            if ($interval->days*24*60*60 + $interval->h*60*60 + $interval->i*60 + $interval->s > 59) {
                $userRepository->update($user, ['last_connexion' => date('Y-m-d H:i:s', time())]);
            }
        }
    }
}