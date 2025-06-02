<?php
class Page {
    public static function getCurrentPage(): string {
        return basename($_SERVER['PHP_SELF']);
    }

    public static function getGetMethod(string $key): ?string {
        return $_GET[$key] ?? null;
    }
}