<?php
class MissingPermissionException extends Exception {
    public function __construct(?string $missingPermission = null, string $message = "Action impossible.") {
        parent::__construct("<details><summary>Erreur :</summary>MissingPermissionException ($missingPermission)</details> " . $message);
    }
}
