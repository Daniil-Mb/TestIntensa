<?php

require_once 'models/DB.php';

class Throttle {
    private static $maxAttempts = 5;
    private static $blockDuration = 7200; // 2 часа

    public static function isBlocked($ip) {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT COUNT(*) FROM submissions WHERE ip = :ip AND timestamp > (NOW() - INTERVAL 1 HOUR)");
        $stmt->execute([':ip' => $ip]);
        $attempts = $stmt->fetchColumn();

        if ($attempts >= self::$maxAttempts) {
            $stmt = $db->prepare("SELECT MAX(timestamp) FROM submissions WHERE ip = :ip");
            $stmt->execute([':ip' => $ip]);
            $lastAttempt = strtotime($stmt->fetchColumn());
            return (time() - $lastAttempt) < self::$blockDuration;
        }
        return false;
    }

    public static function recordSubmission($ip) {
        $db = DB::getInstance();
        $stmt = $db->prepare("INSERT INTO submissions (ip, timestamp) VALUES (:ip, NOW())");
        $stmt->execute([':ip' => $ip]);
    }
}
?>
