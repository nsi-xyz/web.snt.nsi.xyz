<?php

class Player {
    private int $id;

    public function __construct(array $userRow) {
        $this->id = $userRow['id'];
        $this->name = $userRow['name'];
        $this->surname = $userRow['surname'];
        $this->username = $userRow['username'];
        $this->createdAt = $userRow['created_at'];
        $this->lastUpdate = $userRow['last_update'];
        $this->lastConnexion = $userRow['last_connexion'];
        $this->groupId = $userRow['group_id'];
    }

    public function getId(): int {
        return $this->id;
    }
}