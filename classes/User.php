<?php
require_once __DIR__ . '/Group.php';

class User {
    private int $id;
    private string $name;
    private string $surname;
    private string $username;
    private string $hashedPassword;
    private string $createdAt;
    private string $lastUpdate;
    
    private string $lastConnexion;
    private int $groupId;
    private ?Group $group = null;

    public function __construct(array $userRow) {
        $this->id = $userRow['id'];
        $this->name = $userRow['name'];
        $this->surname = $userRow['surname'];
        $this->username = $userRow['username'];
        $this->hashedPassword = $userRow['password'];
        $this->createdAt = $userRow['created_at'];
        $this->lastUpdate = $userRow['last_update'];
        $this->lastConnexion = $userRow['last_connexion'];
        $this->groupId = $userRow['group_id'];
    }

    public function equals(User $other): bool {
        return $this->toArray() === $other->toArray() && $this->getGroup()->equals($other->getGroup());
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'username' => $this->username,
            'hashedPassword' => $this->hashedPassword,
            'createdAt' => $this->createdAt,
            'lastUpdate' => $this->lastUpdate,
            'lastConnexion' => $this->lastConnexion,
            'groupId' => $this->groupId
        ];
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getSurname(): string {
        return $this->surname;
    }

    public function getFullName(): string {
        return "{$this->surname} {$this->name}";
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getHashedPassword(): string {
        return $this->hashedPassword;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function getLastUpdate(): string {
        return $this->lastUpdate;
    }

    public function getLastConnexion(): string {
        return $this->lastConnexion;
    }

    public function getGroupId(): int {
        return $this->groupId;
    }

    public function getGroup(): ?Group {
        return $this->group;
    }

    public function setGroup(Group $group): void {
        $this->group = $group;
    }

    public function hasPermission(string $permission): bool {
        return $this->group ? $this->group->hasPermission($permission) : false;
    }

    public function hasOpenSession(GameSessionRepository $gameSessionRepository): bool {
        return $gameSessionRepository->hasOpenSessionFor($this);
    }

    public function getNumberOfOpenSessions(GameSessionRepository $gameSessionRepository): int {
        return count($gameSessionRepository->getOpenSessionsFor($this));
    }

    public function canEditGroup(Group $group): bool {
        if (!$this->hasPermission(Permission::GROUP_EDIT)) return false;
        if ($this->getGroup()->isLowerThan($group)) return false;
        if ($group->isRoot()) return false;
        return true;
    }

    public function canDeleteGroup(Group $group): bool {
        if (!$this->hasPermission(Permission::GROUP_DELETE)) return false;
        if ($this->getGroup()->isLowerThan($group)) return false;
        if ($group->isRoot()) return false;
        return true;
    }
}