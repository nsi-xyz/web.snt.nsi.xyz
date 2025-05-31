<?php
class Page {
    public static function getCurrentPage(): string {
        return basename($_SERVER['PHP_SELF']);
    }
}