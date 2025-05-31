<?php
require_once __DIR__ . '/Event.php';

class PlayerEvent {
    private Event $event;
    private string $timestamping;

    public function __construct(Event $event, string $timestamping) {
        $this->event = $event;
        $this->timestamping = $timestamping;
    }

    public function getEvent(): Event {
        return $this->event;
    }

    public function getTimestamping(): string {
        return $this->timestamping;
    }
}