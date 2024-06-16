const utils = new Utils();

const editCategoryModalElement = document.getElementById('editCategoryModal');
const newCategoryModalElement = document.getElementById('newCategoryModal');

let editCategoryModal;
let newCategoryModal;

editCategoryModalElement.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const recipient = button.getAttribute('data-bs-value');

    const modalBodyInput = editCategoryModalElement.querySelector('.modal-body input');

    modalBodyInput.value = recipient;
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

async function handleEditCategory(id) {

}

async function handleDeleteCategory(id) {
    const el = document.getElementById(`category-${id}`);

    const resp = await fetch('api/categories/remove', {
        method: 'POST',
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