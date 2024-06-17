<?php

global $pdo;

$tab = $_GET['tab'] ?? "";



$stmt = $pdo->prepare("SELECT * FROM `accounts` WHERE `is_banned` = ?");
$stmt->execute([$tab === "" ? 0 : 1]);

$accounts = $stmt->fetchAll(PDO::FETCH_OBJ);

$user = $_SESSION['user'];


?>

<div class="d-flex gap-2 flex-column">
    <h2>Accounts</h2>

    <div class="d-flex gap-4 flex-column">
        <div class="d-flex flex-column-reverse flex-lg-row justify-content-lg-between gap-2 align-items-lg-center">
            <input id="categories-search" class="form-control" placeholder="Search..." style="flex: 0.3"/>
            <div class="d-flex align-items-center border rounded">
                <a href="./admin?page=accounts" class="btn flex-fill <?=$tab === '' ? 'btn-primary' : ''?>" style="border-top-right-radius: 0; border-bottom-right-radius: 0">
                    <i class="ti ti-users"></i>
                    All accounts
                </a>
                <a href="./admin?page=accounts&tab=banned" class="btn flex-fill <?=$tab === 'banned' ? 'btn-primary' : ''?>" style="border-top-left-radius: 0; border-bottom-left-radius: 0">
                    <i class="ti ti-ban"></i>
                    Banned accounts
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" style="vertical-align: middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone number</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($accounts as $account) :?>
                        <tr>
                            <td><?=$account->first_name?> <?=$account->last_name?></td>
                            <td><?=$account->email?></td>
                            <td><?=$account->phone_number?></td>
                            <td><?=$account->role?></td>
                            <td>
                                <?php if ($tab === "") : ?>
                                    <button class="btn btn-danger btn-icon" <?=($user->id === $account->account_id || $account->role === 'admin') ? 'disabled=\'true\'' : ''?> data-bs-toggle="modal" data-bs-target="#ban-user-modal" data-bs-accountId="<?=$account->account_id?>">
                                        <i class="ti ti-ban"></i>
                                    </button>
                                <?php else :?>
                                    <button class="btn btn-secondary btn-icon" onclick="handleUnbanUser(<?=$account->account_id?>);">
                                        <i class="ti ti-eraser"></i>
                                    </button>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="ban-user-modal" tabindex="-1" aria-labelledby="confirmBanUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="confirmBanUserModalLabel">Ban account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-secondary">Are you sure you want to ban this account?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="ban-user-confirm" type="submit" class="btn btn-primary" onclick="handleBanUser();">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=BASE_URL?>/assets/js/utils.js"></script>
<script src="<?=BASE_URL?>/assets/js/admin/accounts.js"></script>