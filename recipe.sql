CREATE TABLE `accounts`
(
    `account_id`   INT UNSIGNED AUTO_INCREMENT
        PRIMARY KEY,
    `first_name`   VARCHAR(50) NOT NULL,
    `last_name`    VARCHAR(50) NOT NULL,
    `email`        VARCHAR(60) NOT NULL,
    `password`     VARCHAR(60) NOT NULL,
    `phone_number` VARCHAR(10) NULL,
    CONSTRAINT `accounts_pk2`
        UNIQUE (`email`)
);

CREATE TABLE `categories`
(
    `category_id` INT UNSIGNED AUTO_INCREMENT
        PRIMARY KEY,
    `name`        VARCHAR(255) NULL
);

CREATE TABLE `ingredients`
(
    `ingredient_id` INT UNSIGNED AUTO_INCREMENT
        PRIMARY KEY,
    `name`          VARCHAR(50)               NOT NULL,
    `unit`          ENUM ('count', 'ml', 'g') NOT NULL
);

CREATE TABLE `recipes`
(
    `recipe_id`      INT UNSIGNED AUTO_INCREMENT
        PRIMARY KEY,
    `creator_id`     INT UNSIGNED NOT NULL,
    `category_id`    INT UNSIGNED NULL,
    `title`          VARCHAR(50)  NOT NULL,
    `description`    LONGTEXT     NOT NULL,
    `image`          VARCHAR(255) NOT NULL,
    `estimate_price` INT(6)       NOT NULL,
    `estimate_time`  INT(5)       NOT NULL,
    CONSTRAINT `recipes_accounts_account_id_fk`
        FOREIGN KEY (`creator_id`) REFERENCES `accounts` (`account_id`),
    CONSTRAINT `recipes_categories_category_id_fk`
        FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`)
            ON DELETE SET NULL
);

CREATE TABLE `recipe_ingredients`
(
    `recipe_id`     INT UNSIGNED NOT NULL,
    `ingredient_id` INT UNSIGNED NOT NULL,
    `amount`        DECIMAL      NOT NULL,
    PRIMARY KEY (`ingredient_id`, `recipe_id`),
    CONSTRAINT `recipe_ingredients_ingredients_ingredient_id_fk`
        FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`ingredient_id`),
    CONSTRAINT `recipe_ingredients_recipes_recipe_id_fk`
        FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`)
);

CREATE TABLE `recipe_likes`
(
    `recipe_id`  INT UNSIGNED                     NOT NULL,
    `account_id` INT UNSIGNED                     NOT NULL,
    `liked_at`   DATE DEFAULT current_timestamp() NOT NULL,
    PRIMARY KEY (`account_id`, `recipe_id`),
    CONSTRAINT `recipe_likes_accounts_account_id_fk`
        FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`),
    CONSTRAINT `recipe_likes_recipes_recipe_id_fk`
        FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`)
);

CREATE TABLE `fridge_ingredients`
(
    `account_id`    INT UNSIGNED NOT NULL,
    `ingredient_id` INT UNSIGNED NOT NULL,
    `amount`        DECIMAL      NOT NULL,
    PRIMARY KEY (`account_id`, `ingredient_id`)
);