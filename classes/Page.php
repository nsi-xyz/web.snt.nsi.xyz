<?php
class Page {
    public static function getCurrentPage(): string {
        return basename($_SERVER['PHP_SELF']);
    }

    public static function getCurrentPuzzle(): ?string {
        $result = filter_var(Page::getCurrentPage(), FILTER_SANITIZE_NUMBER_INT);
        return $result === "" ? null : $result;
    }

    public static function getGetMethod(string $key): ?string {
        return $_GET[$key] ?? null;
    }

    public static function getMethodExists(string $key): bool {
        return isset($_GET[$key]);
    }
}