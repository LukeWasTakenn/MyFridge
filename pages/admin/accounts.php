<?php

$tab = $_GET['tab'] ?? "";

?>

<div class="d-flex gap-2 flex-column">
    <h2>Accounts</h2>

    <div class="d-flex gap-4 flex-column">
        <div class="d-flex flex-column-reverse flex-lg-row justify-content-lg-between gap-2 align-items-lg-center">
            <input id="accounts-search" class="form-control" placeholder="Search..." style="flex: 0.3"/>
            <div class="d-flex align-items-center border rounded">
                <a href="./admin?page=accounts" class="btn flex-fill <?=$tab === '' ? 'btn-primary' : ''?>" style="border-top-right-radius: 0; border-bottom-right-radius: 0">
                    <i class="ti ti-users"></i>
                    Accounts
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
                <tbody id="accounts-table">

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