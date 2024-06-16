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

    console.log(modalBodyInput, value)

    utils.resetErrors([
        "modal-edit-name"
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

document.getElementById('categories-search').addEventListener('input', utils.debounce(e => fetchCategories(e.target.value)));

async function fetchCategories(search = "") {
    const categoriesContainer = document.getElementById("category-items");

    utils.createSpinner(categoriesContainer, true);

    const resp = await fetch("api/categories/get", {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ search })
    })

    if  (resp.status !== 200) {
        return;
    }

    const { categories } = await resp.json();

    utils.cancelSpinner(categoriesContainer, "");

    if (!categories || categories.length <= 0) {
        categoriesContainer.innerHTML = '<p class="text-secondary">No categories found.</p>';

        return;
    }

    categories.forEach(category => {
        categoriesContainer.insertAdjacentHTML("beforeend", `
            <div id="category-${category.category_id}" class="category-card shadow-sm">
                <p>${category.name}</p>
                <div class="d-flex gap-2 align-items-center">
                    <button id="button-modal-${category.category_id}" class="btn btn-secondary btn-icon" data-bs-toggle="modal" data-bs-target="#editCategoryModal" data-bs-value="${category.name}" data-bs-id="${category.category_id}">
                        <i class="ti ti-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-icon" onclick="handleDeleteCategory(${category.category_id})">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        `)
    })
}

async function handleCreateCategory(e) {
    e.preventDefault();

    const newCategory = document.getElementById("modal-new-name").value;
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
        await fetchCategories();
        utils.cancelSpinner(button, "Confirm");

        return;
    }

    utils.cancelSpinner(button, "Confirm");
    error.innerHTML = data.error;
}

async function handleEditCategory(e) {
    e.preventDefault();

    const id = editId;
    const newValue = document.getElementById("modal-edit-name").value;

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
        const errorElement = document.getElementById('modal-edit-name-error');
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

document.getElementById('edit-category-form').addEventListener('submit', handleEditCategory);
document.getElementById('new-category-form').addEventListener('submit', handleCreateCategory);

fetchCategories().then();