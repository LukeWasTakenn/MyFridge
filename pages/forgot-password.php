<?php

require base_path('includes/header.php');

?>

<main class="container-fluid container-md min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex gap-3 flex-column rounded p-4 shadow border w-100" style="max-width: 524px">
        <div>
            <h2 class="mb-0">Forgot password</h2>
            <p class="text-secondary fs-7 m-0">Reset your password</p>
        </div>
        <form id="forgot-password-form" class="d-flex flex-column gap-3">
            <div>
                <label for="email">Email</label>
                <input id="email" name="email" class="form-control"/>
                <p id="email-error" class="text-danger error"></p>
            </div>
            <button id="form-confirm" class="btn btn-primary">
                Reset password
            </button>
            <span id="form-error" class="text-danger error"></span>
        </form>
    </div>
</main>

<script src="<?=BASE_URL . "/assets/js/utils.js"?>"></script>
<script src="<?=BASE_URL . "/assets/js/forgot-password.js"?>"></script>


<?php

require base_path('includes/footer.php');