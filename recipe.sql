CREATE TABLE `accounts`
(
    `account_id`                 INT UNSIGNED AUTO_INCREMENT
        PRIMARY KEY,
    `first_name`                 VARCHAR(50)                                                               NOT NULL,
    `last_name`                  VARCHAR(50)                                                               NOT NULL,
    `email`                      VARCHAR(60)                                                               NOT NULL,
    `password`                   VARCHAR(60)                                                               NOT NULL,
    `phone_number`               VARCHAR(10)                                                               NULL,
    `role`                       ENUM ('user', 'admin') DEFAULT 'user'                                     NULL,
    `registration_token`         CHAR(40)                                                                  NOT NULL,
    `registration_expires`       DATETIME               DEFAULT (current_timestamp() + INTERVAL 15 MINUTE) NULL,
    `forgotten_password_token`   CHAR(40)                                                                  NULL,
    `forgotten_password_expires` DATETIME                                                                  NULL,
    `is_verified`                TINYINT                DEFAULT 0                                          NULL,
    `is_banned`                  TINYINT(1)             DEFAULT 0                                          NOT NULL,
    CONSTRAINT `accounts_pk`
        UNIQUE (`email`)
);

CREATE TABLE `categories`
(
    `category_id` INT UNSIGNED AUTO_INCREMENT
        PRIMARY KEY,
    `label`       VARCHAR(255) NOT NULL,
    `value`       VARCHAR(255) NOT NULL
);

CREATE TABLE `ingredients`
(
    `ingredient_id` INT UNSIGNED AUTO_INCREMENT
        PRIMARY KEY,
    `label`         VARCHAR(50) NOT NULL,
    `value`         VARCHAR(50) NOT NULL
);

CREATE TABLE `fridge_ingredients`
(
    `account_id`    INT UNSIGNED NOT NULL,
    `ingredient_id` INT UNSIGNED NOT NULL,
    `amount`        DECIMAL      NOT NULL,
    PRIMARY KEY (`account_id`, `ingredient_id`),
    CONSTRAINT `fridge_ingredients_accounts_account_id_fk`
        FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`),
    CONSTRAINT `fridge_ingredients_ingredients_ingredient_id_fk`
        FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`ingredient_id`)
);

CREATE TABLE `recipes`
(
    `recipe_id`      INT UNSIGNED AUTO_INCREMENT
        PRIMARY KEY,
    `creator_id`     INT UNSIGNED         NOT NULL,
    `category_id`    INT UNSIGNED         NULL,
    `title`          VARCHAR(50)          NOT NULL,
    `description`    LONGTEXT             NOT NULL,
    `image`          VARCHAR(255)         NOT NULL,
    `estimate_price` INT(6)               NOT NULL,
    `estimate_time`  INT(5)               NOT NULL,
    `is_pending`     TINYINT(1) DEFAULT 1 NOT NULL,
    `is_denied`      TINYINT(1) DEFAULT 0 NOT NULL,
    CONSTRAINT `recipes_accounts_account_id_fk`
        FOREIGN KEY (`creator_id`) REFERENCES `accounts` (`account_id`),
    CONSTRAINT `recipes_categories_category_id_fk`
        FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`)
            ON DELETE SET NULL
);

CREATE TABLE `recipe_bookmarks`
(
    `recipe_id`     INT UNSIGNED           NOT NULL,
    `account_id`    INT UNSIGNED           NOT NULL,
    `bookmarked_at` DATE DEFAULT curdate() NULL,
    PRIMARY KEY (`recipe_id`, `account_id`),
    CONSTRAINT `recipe_bookmarks_accounts_account_id_fk`
        FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`),
    CONSTRAINT `recipe_bookmarks_recipes_recipe_id_fk`
        FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`)
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

