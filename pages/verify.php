<?php
declare(strict_types=1);

require base_path('includes/header.php');

global $pdo;

$token = $_GET['token'] ?? "";
$isActivated = false;
$accountToken = "";
$isExpired = true;

if ($token !== "") {
    $stmt = $pdo->prepare("SELECT (`registration_expires` < NOW()) AS isExpired, `registration_token` FROM `accounts` WHERE `registration_token` = ? AND `is_verified` = ?");
    $stmt->execute([$token, false]);

    if (count($data = $stmt->fetchAll(PDO::FETCH_OBJ)) > 0) {
        $data = $data[0];
        $isExpired = (boolean) $data->isExpired;
        $accountToken = $data->registration_token;
    }

    if (!$isExpired && $accountToken !== "") {
        try {
            $stmt = $pdo->prepare("UPDATE `accounts` SET `is_verified` = ?, `registration_token` = ?, `registration_expires` = ? WHERE `registration_token` = ? ");
            $stmt->execute([true, "", null, $token]);
            $isActivated = true;
        } catch (PDOException $exception) {
            dd($exception->getMessage());
        }
    }
}


?>

<main class="container-fluid container-md min-vh-100 d-flex">
    <?php
        if ($isActivated) echo "<p>Your account has been successfully activated.</p>";
        if ($token === "" || $accountToken === "") echo "<p>No account with such activation token found.</p>"
    ?>
</main>

<?php

require base_path('includes/footer.php');

