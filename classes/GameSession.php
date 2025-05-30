<?php
require_once __DIR__ . '/User.php';

class GameSession {
    private int $id;
    private string $code;
    private int $hostId;
    private ?User $host = null;
    private string $createdAt;
    private int $duration;
    private int $slots;
    private int $status;

    public function __construct(array $gameSessionRow) {
        $this->id = $gameSessionRow['id'];
        $this->code = $gameSessionRow['code'];
        $this->hostId = $gameSessionRow['host_id'];
        $this->createdAt = $gameSessionRow['created_at'];
        $this->duration = $gameSessionRow['duration'];
        $this->slots = $gameSessionRow['slots'];
        $this->status = $gameSessionRow['status'];
    }

    public function getId(): int {
        return $this->id;
    }

    public function getCode(): string {
        return $this->code;
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
}