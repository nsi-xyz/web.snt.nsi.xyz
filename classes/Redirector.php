<?php
class Redirector {
    public static function to(string $url = null, bool $inHeader = true): void {
        if ($url === null) {
            $url = $_SERVER["REQUEST_URI"];
        }
        if ($inHeader) {
            header('Location: ' . $url);
        } else {
            echo '<script>window.location.replace("'. $url .'");</script>';
        }
        exit;
    }
}
