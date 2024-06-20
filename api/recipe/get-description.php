<?php

global $pdo;

$data = get_request_data();

$id = $data['id'];

$stmt = $pdo->prepare('SELECT `description` FROM `recipes` WHERE `recipe_id` = ?');
$stmt->execute([$id]);

$description = $stmt->fetchColumn(0);

send_response([
    "contents" => $description
]);