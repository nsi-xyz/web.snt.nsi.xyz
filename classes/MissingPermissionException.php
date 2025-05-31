<?php
class MissingPermissionException extends Exception {
    private ?string $missingPermission;

    public function __construct(?string $missingPermission = null, string $message = "Action impossible") {
        $this->missingPermission = $missingPermission;
        parent::__construct($message);
    }

    public function getMissingPermission(): ?string {
        return $this->missingPermission;
    }
}
