<?php

declare(strict_types=1);
session_start();

global $pdo;

if (!isAdmin()) send_response(["error" => "Unauthorized"], 401);

$stmt = $pdo->prepare('SELECT * FROM `categories`');
$stmt->execute();

$categories = $stmt->fetchAll(PDO::FETCH_OBJ);

send_response([
    "categories" => $categories
]);