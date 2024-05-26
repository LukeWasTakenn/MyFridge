<?php
require base_path('includes/header.php');
?>

<main class="container-fluid container-md min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex gap-3 flex-column rounded p-4 shadow border w-100" style="max-width: 524px;">
        <div>
            <h2 class="mb-0">Sign up</h2>
            <p class="text-secondary fs-7 m-0">Create an account</p>
        </div>
        <form class="d-flex flex-column gap-3" id="sign-up-form">
            <div class="d-flex gap-2">
                <div>
                    <label for="firstname">First name</label>
                    <input id="firstname" class="form-control" name="firstName"/>
                    <p id="firstName-error" class="text-danger error"></p>
                </div>
                <div>
                    <label for="lastname">Last name</label>
                    <input id="lastname" class="form-control" name="lastName"/>
                    <p id="lastName-error" class="text-danger error"></p>
                </div>
            </div>
            <div>
                <label for="email">Email</label>
                <input id="email" class="form-control" name="email"/>
                <p id="email-error" class="text-danger error"></p>
            </div>
            <div>
                <label for="phone-number">Phone number</label>
                <input id="phone-number" class="form-control" name="phoneNumber"/>
                <p id="phoneNumber-error" class="text-danger error"></p>
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control" name="password"/>
                <p id="password-error" class="text-danger error"></p>
            </div>
            <div>
                <label for="confirm-password">Confirm password</label>
                <input id="confirm-password" type="password" class="form-control" name="confirmPassword"/>
                <p id="confirmPassword-error" class="text-danger error"></p>
            </div>
            <button class="btn btn-primary" type="submit">
                Sign up
            </button>
            <p id="form-error" class="text-danger error"></p>
        </form>
        <div id="existing-account" class="fs-7 text-align-center">Already have an account? <a class="primary-link" href="<?=BASE_URL?>/login"
            >
                Log in
            </a>
        </div>
    </div>
</main>

<script src="<?=BASE_URL . "/assets/js/sign-up.js"?>"></script>

<?php

require base_path('includes/footer.php');
