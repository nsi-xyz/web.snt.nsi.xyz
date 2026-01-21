<?php
class InvalidInputException extends Exception {
    public function __construct($message) {
        parent::__construct('<details><summary>Erreur :</summary>InvalidInputException->' . $message);
    }
}
