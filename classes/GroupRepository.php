<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Group.php';

class GroupRepository {
    private Database $database;
    private ?User $actor;

    public function __construct(Database $database, ?User $actor = null) {
        $this->database = $database;
        $this->actor = $actor;
    }

    public function getById($groupId): ?Group {
        $groupRow = $this->database->getRowById('groups', $groupId);
        $groupPermissions = $this->database->getPermissionsByGroupId($groupId);
        return $groupRow ? new Group($groupRow, $groupPermissions) : null;
    }

    public function exists($groupId): bool {
        return $this->database->getRowById('groups', $groupId) !== null;
    }
}