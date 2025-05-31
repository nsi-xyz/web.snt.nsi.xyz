<?php
class Event {
    private string $key;

    public function __construct(string $key) {
        $this->key = $key;
    }

    public function getKey(): string {
        return $this->key;
    }

    public function getDescription(): ?string {
        return Events::getDescription($this->key);
    }
}
