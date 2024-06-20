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

        if (count($this->ingredients) <= 0) {
            return false;
        }

        return true;
    }

    public function create(): bool {
        global $pdo;

        $stmt = $pdo->prepare("INSERT INTO `recipes` (`creator_id`, `category_id`, `title`, `description`, `estimate_price`, `estimate_time`, `is_pending`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([$this->creator_id, $this->category_id, $this->title, $this->description, $this->estimate_price, $this->estimate_time, 1]);

        if (!$success) return false;

        $ingredients = $this->ingredients;

        $id = $pdo->lastInsertId();

        $stmtGetIngredientId = $pdo->prepare('SELECT `ingredient_id` FROM `ingredients` WHERE `value` = ?');
        $stmtRecipeIngredient = $pdo->prepare('INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_id`, `amount`, `unit`) VALUES (?, ?, ?, ?)');


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

        return true;
    }
}