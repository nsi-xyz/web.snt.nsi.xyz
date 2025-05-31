<?php
class FlashMessenger {
    public static function success(string $message, string $tag = 'msg'): void {
        $_SESSION['message'] = [$message, 'success', $tag];
    }

    public static function error(string $message, string $tag = 'msg'): void {
        $_SESSION['message'] = [$message, 'error', $tag];
    }

    public static function info(string $message, string $tag = 'msg'): void {
        $_SESSION['message'] = [$message, 'info', $tag];
    }

    public static function get(): ?array {
        return $_SESSION['message'] ?? null;
    }

    public static function clear(): void {
        unset($_SESSION['message']);
    }
}