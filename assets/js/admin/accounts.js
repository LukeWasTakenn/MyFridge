const utils = new Utils();

const banUserModalElement = document.getElementById("ban-user-modal");

let banUserModal;
let banUserAccountId;

banUserModalElement.addEventListener('show.bs.modal', e => {
    const button = e.relatedTarget;
    banUserAccountId = button.getAttribute('data-bs-accountId');


    banUserModal = bootstrap.Modal.getInstance(banUserModalElement);
})

document.getElementById('accounts-search').addEventListener('input', utils.debounce(e => fetchAccounts(e.target.value)));

async function fetchAccounts(search) {
    const params = new URLSearchParams(window.location.search);
    const tab = params.get('tab');
    const isBannedAccounts = tab === 'banned';
    const accountsTableElement = document.getElementById('accounts-table');

    accountsTableElement.innerHTML = "";

    const resp =  await fetch('api/accounts/get', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ search, isBannedAccounts })
    })

    if (resp.status !== 200) {
        return;
    }

    const { accounts } = await resp.json();

    accounts.forEach(account => {
        const actionButton = isBannedAccounts ? `
            <button class="btn btn-secondary btn-icon" onclick="handleUnbanUser(${account.account_id});">
                <i class="ti ti-eraser"></i>
            </button>
        ` : `
            <button class="btn btn-danger btn-icon" data-bs-toggle="modal" data-bs-target="#ban-user-modal" data-bs-accountId="${account.account_id}">
                <i class="ti ti-ban"></i>
            </button>
        `

        accountsTableElement.insertAdjacentHTML('beforeend', `
            <tr>
                <td>${account.first_name} ${account.last_name}</td>
                <td>${account.email}</td>
                <td>${account.phone_number}</td>
                <td>${account.role}</td>
                <td>
                    ${actionButton}
                </td>
            </tr>
        `)
    });


}

async function handleBanUser() {
    const accountId = banUserAccountId;
    const button = document.getElementById("ban-user-confirm");

    utils.createSpinner(button);

    const resp = await fetch('api/accounts/ban', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ accountId })
    });

    if (resp.status !== 200) {
        utils.cancelSpinner(button, "Confirm");
        return;
    }

    banUserModal.hide();
    utils.cancelSpinner(button, "Confirm");
    location.reload();
}

async function handleUnbanUser(accountId) {
    const resp = await fetch('api/accounts/unban', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ accountId })
    })

    if (resp.status !== 200) {
        return;
    }

    location.reload();
}

fetchAccounts().then();