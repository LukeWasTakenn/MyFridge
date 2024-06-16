<?php

declare(strict_types=1);
session_start();

global $pdo;

if (!isAdmin()) send_response(["error" => "Unauthorized"], 401);

$data = get_request_data();

$search = $data['search'];

$stmt = $pdo->prepare('SELECT * FROM `categories` WHERE `label` LIKE ?');
$stmt->execute(["%$search%"]);

$categories = $stmt->fetchAll(PDO::FETCH_OBJ);

send_response([
    "categories" => $categories
]);