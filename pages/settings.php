<?php

require base_path('includes/header.php');

$user = $_SESSION['user'];

?>

<main id="container" class="container-fluid container-md min-vh-100 pt-4 d-flex flex-column">
    <h2 class="mb-5">Settings</h2>

    <div class="d-flex flex-column gap-4">
        <form id="profile-form" class="d-flex flex-column gap-4 shadow-sm p-4 border rounded">
            <h4>Profile</h4>
            <div class="d-flex flex-column justify-content-between">
                <label for="first-name">First name</label>
                <input id="first-name" name="firstName" class="form-control" value="<?=$user->first_name?>"/>
                <span id="firstName-error" class="text-danger error"></span>
            </div>
            <div class="d-flex flex-column justify-content-between">
                <label for="last-name">Last name</label>
                <input id="last-name" name="lastName" class="form-control" value="<?=$user->last_name?>"/>
                <span id="lastName-error" class="text-danger error"></span>
            </div>
            <div class="d-flex flex-column justify-content-between">
                <label for="phone-number">Phone number</label>
                <input id="phone-number" name="phoneNumber" class="form-control" value="<?=$user->phone_number?>"/>
                <span id="phoneNumber-error" class="text-danger error"></span>
            </div>
            <button id="profile-form-submit" class="btn btn-primary" style="width: fit-content">
                Update profile
            </button>
            <span id="profile-form-error"></span>
        </form>

        <form id="account-form" class="d-flex flex-column gap-4 shadow-sm rounded p-4 border">
            <h4>Account</h4>
            <div class="d-flex flex-column gap-4">
                <div class="d-flex flex-column justify-content-between">
                    <label for="current-password">Current password</label>
                    <input id="current-password" type="password" name="currentPassword" class="form-control"/>
                    <span id="currentPassword-error" class="text-danger error"></span>
                </div>
                <div class="d-flex flex-column justify-content-between">
                    <label for="new-password">New password</label>
                    <input id="new-password" type="password" name="password" class="form-control"/>
                    <span id="password-error" class="text-danger error"></span>
                </div>
                <div class="d-flex flex-column justify-content-between">
                    <label for="confirm-new-password">Confirm password</label>
                    <input id="confirm-new-password" type="password" name="confirmPassword" class="form-control"/>
                    <span id="confirmPassword-error" class="text-danger error"></span>
                </div>
                <button id="account-form-submit" class="btn btn-primary" style="width: fit-content">
                    Update password
                </button>
                <span id="account-form-error"></span>
            </div>
        </form>

    </div>
</main>

<script src="<?=BASE_URL . "/assets/js/utils.js"?>"></script>
<script src="<?=BASE_URL . "/assets/js/settings.js"?>"></script>


<?php

require base_path('includes/footer.php');
