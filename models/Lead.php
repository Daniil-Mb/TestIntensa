<?php

class Lead {
    public static function create($name, $email, $phone, $city) {
        $db = DB::getInstance();
        $stmt = $db->prepare("INSERT INTO leads (name, email, phone, city) VALUES (:name, :email, :phone, :city)");
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':city' => $city,
        ]);
    }

    public static function getAll() {
        $db = DB::getInstance();
        $stmt = $db->query("SELECT * FROM leads");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByCity($city) {
        $db = DB::getInstance();
        $stmt = $db->prepare("SELECT * FROM leads WHERE city = :city");
        $stmt->execute([':city' => $city]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>