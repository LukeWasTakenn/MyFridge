<?php

session_start();

global $pdo;

$user = $_SESSION['user'] ?? '';

if (!$user) send_response(["error" => "unauthorized"], 401);

$data = get_request_data();

$recipe = $data['recipe'] ?? '';

if (!$recipe) send_response(["error" => "invalid inputs"], 500);

$stmt = $pdo->prepare('SELECT `creator_id` FROM `recipes` WHERE `recipe_id` = ?');
$stmt->execute([$recipe['id']]);

$creatorId = $stmt->fetchColumn(0);

if (!$creatorId) send_response(["error" => "invalid recipe id"], 500);

if ($creatorId !== $user->id && !isAdmin()) send_response(["error" => "No permission"]);

$stmt = $pdo->prepare('SELECT `category_id` FROM `categories` WHERE `value` = ?');
$stmt->execute([strtolower($recipe['category'])]);

$categoryId = $stmt->fetchColumn(0);

if (!$categoryId) send_response(["error" => "invalid category"], 500);

$stmt = $pdo->prepare('UPDATE `recipes` SET `title` = ?, `category_id` = ?, `description` = ?, `estimate_price` = ?, `estimate_time` = ? WHERE `recipe_id` = ?');
$stmt->execute([
    htmlspecialchars($recipe['name']),
    $categoryId,
    $recipe['description'],
    (int) $recipe['costEstimate'],
    (int) $recipe['cookTime'],
    $recipe['id']
]);

$stmt = $pdo->prepare('DELETE FROM `recipe_ingredients` WHERE `recipe_id` = ?');
$stmt->execute([$recipe['id']]);

$stmtRecipeIngredient = $pdo->prepare('INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_id`, `amount`, `unit`) VALUES (?, ?, ?, ?)');

foreach ($recipe['ingredients'] as $ingredient) {
    $ingredientId = createIngredientIfNotExists($ingredient['ingredient']);

    $stmtRecipeIngredient->execute([$recipe['id'], $ingredientId, $ingredient['amount'], $ingredient['unit']]);
}


$recipeImageNames = getAllRecipeImageNames($recipe['id']);
$recipeImages = [];

foreach ($recipeImageNames as $image) {
    $recipeImages[$image] = $image;
}

$id = $recipe['id'];

foreach ($recipe['images'] as $image) {
    $name = htmlspecialchars($image['fileName']);

    if (str_contains($image['src'], "data")) {
        // https://gist.github.com/anthonycoffey/59bc8114d735c32870a21670bc0f9c15
        $base64_img = $image['src'];
        $split = explode(',', substr($base64_img, 5), 2);
        $mime = $split[0];
        $img_data = $split[1];
        $mime_split_without_base64 = explode(';', $mime, 2);
        $mime_split = explode('/', $mime_split_without_base64[0], 2);

        $extension = $mime_split[1];

        if ($extension !== 'jpg' && $extension !== 'png' && $extension !== 'jpeg') return false;

        $decoded = base64_decode($img_data);

        $lastImage = end($recipeImageNames);
        $lastDash = explode("-", $lastImage);
        $number = (int) explode("-", $lastImage)[0];
        $number++;

        $newName = $number . "-" . Date("YmdHis") . "-$name";

        if (!is_dir(base_path("images"))) {
            mkdir(base_path("images"));
        }

        if (!is_dir(base_path("images/$id"))) {
            mkdir(base_path("images/$id"));
        }

        file_put_contents(base_path("images/$id/$newName"), $decoded);
    }

    // Ignore same images that were already set
    if (isset($recipeImages[$image['fileName']])) {
        unset($recipeImages[$image['fileName']]);
    }

}

foreach ($recipeImages as $key => $value) {
    unlink(base_path("images/$id/$key"));
}

send_response([
    "success" => true
]);