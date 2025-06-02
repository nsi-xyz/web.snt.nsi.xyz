<?php
class CookieManager {
    public function exists(string $name): bool {
        return isset($_COOKIE[$name]);
    }

    public function create(string $name, string $value, int $expires = GAMESESSION_DURATION, string $path = '/'): void {
        setcookie($name, $value, time() + $expires, $path);
    }

    public function read(string $name): string|null {
        return $this->exists($name) ? $_COOKIE[$name] : null;
    }

    public function delete(string $name, string $path = '/'): void {
        setcookie($name, '', time() - AUTHCOOKIE_DURATION, $path);
    }
}