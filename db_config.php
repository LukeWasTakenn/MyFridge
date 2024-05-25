<?php

declare(strict_types=1);

try {
    $pdo = new PDO("mysql:host=" . DB["host"] . ";dbname=" . DB["name"], DB["username"], DB["password"]);
} catch (PDOException $e) {
    dd($e->getMessage());
}
