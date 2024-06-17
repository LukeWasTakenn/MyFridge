<?php

require base_path('includes/header.php');

global $pdo;

$token = $_GET['token'] ?? '';

$isValidToken = false;

if ($token) {
    $stmt = $pdo->prepare('SELECT 1 FROM `accounts` WHERE `forgotten_password_token` = ? AND `forgotten_password_expires` >= CURRENT_TIMESTAMP()');
    $stmt->execute([$token]);

    if ($stmt->fetchColumn(0)) $isValidToken = true;
}


?>

<main class="container-fluid container-md min-vh-100 d-flex align-items-center justify-content-center">
    <?php if(!$isValidToken) : ?>
        <p>Invalid token or token expired.</p>
    <?php else : ?>
        <div class="d-flex gap-3 flex-column rounded p-4 shadow border w-100" style="max-width: 524px">
            <div>
                <h2 class="mb-0">Reset password</h2>
                <p class="text-secondary fs-7 m-0">Reset your password</p>
            </div>
            <form id="reset-password-form" class="d-flex flex-column gap-3">
                <div>
                    <label for="new-password">New password</label>
                    <input id="new-password" type="password" name="password" class="form-control"/>
                    <p id="password-error" class="text-danger error"></p>
                </div>
                <div>
                    <label for="confirm-new-password">Confirm password</label>
                    <input id="confirm-new-password" type="password" name="confirmPassword" class="form-control"/>
                    <p id="confirmPassword-error" class="text-danger error"></p>
                </div>
                <button id="form-confirm" class="btn btn-primary">
                    Update password
                </button>
                <span id="form-error" class="text-danger error"></span>
            </form>
        </div>
    <?php endif;?>
</main>

<?php if ($isValidToken) : ?>
    <script src="<?=BASE_URL . "/assets/js/utils.js"?>"></script>
    <script src="<?=BASE_URL . "/assets/js/reset.js"?>"></script>
<?php endif;?>

<?php

require base_path('includes/footer.php');