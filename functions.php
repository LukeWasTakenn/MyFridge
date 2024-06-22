<?php

declare(strict_types=1);

function dd(mixed $var): void
{
    die(var_dump($var));
}

function base_path(string $path): string
{
    return BASE_PATH . $path;
}

// https://gomakethings.com/how-to-create-your-own-api-endpoints-with-php/
function get_request_data() {
    return array_merge(empty($_POST) ? array() : $_POST, (array) json_decode(file_get_contents('php://input'), true), $_GET);
}

function send_response($response, $code = 200) {
    http_response_code($code);
    die(json_encode($response));
}

function createToken(int $length): ?string
{
    try {
        return bin2hex(random_bytes($length));
    } catch (\Exception $e) {
        error_log("****************************************");
        error_log($e->getMessage());
        error_log("file:" . $e->getFile() . " line:" . $e->getLine());
        return null;
    }
}

function isAdmin(): bool {
    $user = $_SESSION['user'];

    if (!$user || $user->role !== 'admin') {
        return false;
    }

    return true;
}

function getAllRecipeImageNames($recipeId): ?array {
    $files = scandir(base_path("images/$recipeId"));
    $images = [];

    if (!$files || count($files) <= 0) return null;

    foreach ($files as $file) {
        if (!str_contains($file, ".jpeg") && !str_contains($file, ".png") && !str_contains($file, ".jpg")) continue;

        $images[] = $file;
    }

    if (count($images) <= 0) return null;

    return $images;
}

function getRecipeImageName($recipeId): ?string {
    $images = getAllRecipeImageNames($recipeId);

    if (!$images || count($images) <= 0) return null;

    return $images[0];
};

function createIngredientIfNotExists(string $label): int {
    global $pdo;

    $label = ucfirst($label);
    $value = strtolower($label);

    $stmt = $pdo->prepare('SELECT `ingredient_id` FROM `ingredients` WHERE `value` = ?');
    $stmt->execute([$value]);

    $id = $stmt->fetchColumn(0);

    if (!$id) {
        $stmt = $pdo->prepare('INSERT INTO `ingredients` (`label`, `value`) VALUES (?, ?)');
        $stmt->execute([$label, $value]);

        $id = $pdo->lastInsertId();
    }

    return (int) $id;
}