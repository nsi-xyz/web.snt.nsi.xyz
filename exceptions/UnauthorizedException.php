<?php
class UnauthorizedException extends Exception {
    public function __construct($message) {
        parent::__construct('<details><summary>Erreur :</summary>UnauthorizedException</details> ' . $message);
    }
}
