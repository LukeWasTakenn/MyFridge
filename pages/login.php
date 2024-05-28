<?php

require base_path('includes/header.php');

?>

<main class="container-fluid container-md min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex gap-3 flex-column rounded p-4 shadow border w-100" style="max-width: 524px">
        <div>
            <h2 class="mb-0">Login</h2>
            <p class="text-secondary fs-7 m-0">Start exploring your favourite recipes today</p>
        </div>
        <form id="login-form" class="d-flex flex-column gap-3">
            <div>
                <label for="email">Email</label>
                <input id="email" name="email" class="form-control"/>
                <p id="email-error" class="text-danger error"></p>
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" name="password" type="password" class="form-control"/>
                <p id="password-error" class="text-danger error"></p>
            </div>
            <a class="primary-link fs-7 text-align-right"
               href="#"
            >
                Forgot password?
            </a>
            <button id="login-form-submit" class="btn btn-primary">
                Login
            </button>
        </form>
        <div class="fs-7 text-align-center">Don't have an account? <a class="primary-link" href="<?=BASE_URL?>/sign-up"
            >
                Sign up
            </a>
        </div>
    </div>
</main>

<script src="<?=BASE_URL . "/assets/js/utils.js"?>"></script>
<script src="<?=BASE_URL . "/assets/js/login.js"?>"></script>

<?php

require base_path('includes/footer.php');