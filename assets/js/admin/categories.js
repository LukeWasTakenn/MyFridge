const utils = new Utils();

const editCategoryModalElement = document.getElementById('editCategoryModal');
const newCategoryModalElement = document.getElementById('newCategoryModal');

let editCategoryModal;
let newCategoryModal;

let editId = 0;

editCategoryModalElement.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const value = button.getAttribute('data-bs-value');
    editId = button.getAttribute('data-bs-id');

    const modalBodyInput = editCategoryModalElement.querySelector('.modal-body input');

    utils.resetErrors([
        "modal-new-name"
    ])

    utils.cancelSpinner(document.getElementById("modal-confirm-edit"), "Confirm");

    modalBodyInput.value = value

    editCategoryModal = bootstrap.Modal.getInstance(editCategoryModalElement);
})

newCategoryModalElement.addEventListener('show.bs.modal', e => {
    const modalBodyInput = newCategoryModalElement.querySelector('.modal-body input');
    modalBodyInput.value = "";

    utils.resetErrors([
        "category"
    ])

    newCategoryModal = bootstrap.Modal.getInstance(newCategoryModalElement);
})

async function handleCreateCategory() {
    const newCategory = document.getElementById("modal-edit-name").value;
    const error = document.getElementById("category-error");
    const button = document.getElementById("new-category-confirm")

    if (!newCategory) {
        error.innerHTML = "This field is required";

        return;
    }

    utils.createSpinner(button);
    const resp = await fetch('api/categories/create', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ newCategory })
    })

    if (resp.status !== 200) {
        return;
    }

    const data = await resp.json();

    if (!data.error) {
        newCategoryModal.hide();
    }

    utils.cancelSpinner(button, "Confirm");
    error.innerHTML = data.error;
}

async function handleEditCategory() {
    const id = editId;
    const newValue = document.getElementById("modal-new-name").value;

    const confirmButton = document.getElementById('modal-confirm-edit');

    utils.createSpinner(confirmButton);

    const resp = await fetch('api/categories/edit', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id, newValue })
    })

    if (resp.status !== 200) {
        return;
    }

    const data = await resp.json();

    if (data.error) {
        const errorElement = document.getElementById('modal-new-name-error');
        errorElement.innerHTML = data.error;
        utils.cancelSpinner(confirmButton, "Confirm");

        return;
    }

    const targetElement = document.querySelector(`#category-${id} > p`);
    targetElement.innerHTML = newValue;

    editCategoryModal.hide();
    document.getElementById(`button-modal-${id}`).setAttribute('data-bs-value', newValue)
}

async function handleDeleteCategory(id) {
    const el = document.getElementById(`category-${id}`);

    const resp = await fetch('api/categories/remove', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    })

    if (resp.status !== 200) {
        return;
    }

    el.remove();
}