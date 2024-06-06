<?php

class CSRF {
    public static function generateToken() {
        return bin2hex(random_bytes(32));
    }

    public static function validateToken($token) {
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function setToken() {
        $_SESSION['csrf_token'] = self::generateToken();
    }
}
?>
