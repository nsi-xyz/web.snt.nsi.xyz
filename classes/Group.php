<?php
class Group {
    private int $id;
    private string $name;
    private int $hierarchyLevel;
    private array $permissions;

    public function __construct(array $groupRow, array $permissions) {
        $this->id = $groupRow['id'];
        $this->name = $groupRow['name'];
        $this->hierarchyLevel = $groupRow['hierarchy_level'];
        $this->permissions = $permissions;
    }

    public function equals(Group $other): bool {
        return $this->toArray() === $other->toArray();
    }

    private function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'hierarchyLevel' => $this->hierarchyLevel,
            'permissions' => $this->permissions
        ];
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getHierarchyLevel(): int {
        return $this->hierarchyLevel;
    }

    public function isRoot(): bool {
        return $this->hierarchyLevel === 0;
    }

    public function getPermissions(): array {
        return $this->permissions;
    }

    public function hasPermission(string $permission): bool {
        return in_array($permission, $this->permissions);
    }
}