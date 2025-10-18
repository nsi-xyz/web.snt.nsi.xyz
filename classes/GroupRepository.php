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

    public function create($groupName, $permissions): int {
        if ($this->actor !== null && !$this->actor->hasPermission(Permission::GROUP_CREATE)) {
            return -1; // Access denied
        }
        foreach ($permissions as $permission) {
            if (!$this->actor->hasPermission($permission)) {
                return -1; // Access denied, cannot grant permission not possessed
            }
        }
        if (!preg_match(PHPPATTERN_GROUP, $groupName)) {
            return -2;
        }
        $groupId = $this->database->addRow('groups', array('name' => $groupName, 'hierarchy_level' => $this->getLowerHierarchyLevel() - 1));
        foreach ($permissions as $permission) {
            $this->database->addRow('group_permissions', array('group_id' => $groupId, 'permission_key' => $permission));
        }
        return 0;
    }

    public function getById($groupId): ?Group {
        $groupRow = $this->database->getRowById('groups', $groupId);
        $groupPermissions = $this->database->getPermissionsByGroupId($groupId);
        return $groupRow ? new Group($groupRow, $groupPermissions) : null;
    }

    public function exists($groupId): bool {
        return $this->database->getRowById('groups', $groupId) !== null;
    }

    public function getAll(): array {
        $groupsRows = $this->database->getRows('groups');
        if ($groupsRows === null) return [];
        $groups = [];
        foreach ($groupsRows as $groupRow) {
            $group = new Group($groupRow, $this->database->getPermissionsByGroupId($groupRow['id']));
            $groups[] = $group;
        }
        return $groups;
    }

    private function getLowerHierarchyLevel() {
        $groups = $this->getAll();
        $groupsHierarchyLevel = array_map(fn(Group $group): int => $group->getHierarchyLevel(), $groups);
        if (count($groups) === 0 || count($groupsHierarchyLevel) === 0) {
            return 1;
        }
        $min = $groupsHierarchyLevel[0];
        foreach ($groupsHierarchyLevel as $hierarchyLevel) {
            if ($hierarchyLevel < $min) {
                $min = $hierarchyLevel;
            }
        }
        return $min;
    }
}