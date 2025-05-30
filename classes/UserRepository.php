<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/GroupRepository.php';
require_once __DIR__ . '/User.php';

class UserRepository {
    private Database $database;
    private ?User $actor;

    public function __construct(Database $database, ?User $actor = null) {
        $this->database = $database;
        $this->actor = $actor;
    }

    public function create(User $user): int {
        if ($this->actor !== null || !$this->actor->hasPermission(Permission::USER_CREATE)) {
            return -1; // Permission insuffisante
        }
        return 0;
    }

    public function getById($userId): ?User {
        $userRow = $this->database->getRowById('users', $userId);
        if ($userRow) {
            $user = new User($userRow);
            $userGroup = (new GroupRepository($this->database))->getById($user->getGroupId());
            $user->setGroup($userGroup);
            return $user;
        }
        return null;
    }

    public function getByUsername($userUsername): ?User {
        $userRow = $this->database->getRowByCustomAttribut('users', 'username', $userUsername);
        if ($userRow) {
            $user = new User($userRow);
            $userGroup = (new GroupRepository($this->database))->getById($user->getGroupId());
            $user->setGroup($userGroup);
            return $user;
        }
        return null;
    }

    public function exists($param): bool {
        return ctype_digit($param) ? $this->database->getRowById('users', $param) !== null : $this->database->getRowByCustomAttribut('users', 'username', $param) !== null;
    }

    public function canLogin(string $username, string $password): bool {
        if ($this->exists($username)) {
            $user = $this->getByUsername($username);
            return password_verify($password, $user->getHashedPassword());
        }
        return false;
    }

    public function canLoginWithHashedPassword(string $username, string $hashedPassword): bool {
        if ($this->exists($username)) {
            $user = $this->getByUsername($username);
            return $user->getHashedPassword() == urldecode($hashedPassword);
        }
        return false;
    }
}