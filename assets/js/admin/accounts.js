const utils = new Utils();

const banUserModalElement = document.getElementById("ban-user-modal");

let banUserModal;
let banUserAccountId;

banUserModalElement.addEventListener('show.bs.modal', e => {
    const button = e.relatedTarget;
    banUserAccountId = button.getAttribute('data-bs-accountId');


    banUserModal = bootstrap.Modal.getInstance(banUserModalElement);
})

function handlePromoteUser(userId) {

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