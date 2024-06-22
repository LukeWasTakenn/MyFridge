<?php

declare(strict_types=1);

global $pdo;

class Recipe
{
    function __construct(
        public int $creator_id,
        public int $category_id,
        public string $title,
        public string $description,
        public int $estimate_price,
        public int $estimate_time,
        public array $ingredients,
        public array $images,
    ) {}

    public function validate(): bool {
        if (!$this->title || !$this->category_id || !$this->description) {
            return false;
        }

        if (!$this->estimate_time || !$this->estimate_price) {
            return false;
        }

        if (count($this->ingredients) <= 0 || count($this->images) <= 0) {
            return false;
        }

        return true;
    }

    public function create(): int | bool {
        global $pdo;

        $stmt = $pdo->prepare("INSERT INTO `recipes` (`creator_id`, `category_id`, `title`, `description`, `estimate_price`, `estimate_time`, `is_pending`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([$this->creator_id, $this->category_id, $this->title, $this->description, $this->estimate_price, $this->estimate_time, 1]);

        if (!$success) return false;

        $ingredients = $this->ingredients;

        $id = $pdo->lastInsertId();

        $stmtGetIngredientId = $pdo->prepare('SELECT `ingredient_id` FROM `ingredients` WHERE `value` = ?');
        $stmtRecipeIngredient = $pdo->prepare('INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_id`, `amount`, `unit`) VALUES (?, ?, ?, ?)');

        $images = $this->images;

        if (count($images) <= 0) return false;

        $imageCount = 0;
        foreach ($images as $image) {
            $name = $image['fileName'];

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

            $imageCount++;
            $newName = $imageCount . "-" . Date("YmdHis") . "-$name";

            if (!is_dir(base_path("images"))) {
                mkdir(base_path("images"));
            }

            if (!is_dir(base_path("images/$id"))) {
                mkdir(base_path("images/$id"));
            }

            file_put_contents(base_path("images/$id/$newName"), $decoded);
        }

        foreach ($ingredients as $ingredient) {
            $stmtGetIngredientId->execute([strtolower($ingredient['ingredient'])]);

            $ingredientId = $stmtGetIngredientId->fetchColumn(0);

            if (!$ingredientId) {
                $stmt = $pdo->prepare('INSERT INTO `ingredients` (`label`, `value`) VALUES (?, ?)');
                $stmt->execute([ucfirst($ingredient['ingredient']), strtolower($ingredient['ingredient'])]);

                $ingredientId = $pdo->lastInsertId();
            }

            $stmtRecipeIngredient->execute([$id, $ingredientId, $ingredient['amount'], $ingredient['unit']]);
        }



        return (int) $id;
    }
}