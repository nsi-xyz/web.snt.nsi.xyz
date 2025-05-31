<?php
require_once __DIR__ . '/User.php';

class GameSession {
    private int $id;
    private string $name;
    private string $code;
    private int $hostId;
    private ?User $host = null;
    private string $createdAt;
    private int $duration;
    private string $visibility;
    private int $slots;
    private int $status;

    public function __construct(array $gameSessionRow) {
        $this->id = $gameSessionRow['id'];
        $this->name = $gameSessionRow['name'];
        $this->code = $gameSessionRow['code'];
        $this->hostId = $gameSessionRow['host_id'];
        $this->createdAt = $gameSessionRow['created_at'];
        $this->duration = $gameSessionRow['duration'];
        $this->duration = $gameSessionRow['visibility'];
        $this->slots = $gameSessionRow['slots'];
        $this->status = $gameSessionRow['status'];
    }

    public function getId(): int {
        return $this->id;
    }

    public function getCode(): string {
        return $this->code;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getHostId(): int {
        return $this->hostId;
    }

    public function getHost(): ?User {
        return $this->host;
    }

    public function setHost(User $host): void {
        $this->host = $host;
    }

    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    public function getDuration(): int {
        return $this->duration;
    }

    public function getStatus(): int {
        return $this->status;
    }
}