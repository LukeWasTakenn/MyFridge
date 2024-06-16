const utils = new Utils();

const editIngredientModalElement = document.getElementById('editIngredientModal');
const newIngredientModalElement = document.getElementById('newIngredientModal');

let editIngredientModal;
let newIngredientModal;

let editId = 0;

document.getElementById('ingredients-search').addEventListener('input', utils.debounce(e => fetchIngredients(e.target.value)));

editIngredientModalElement.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const value = button.getAttribute('data-bs-value');
    editId = button.getAttribute('data-bs-id');

    const modalBodyInput = editIngredientModalElement.querySelector('.modal-body input');

    utils.resetErrors([
        "modal-new-name"
    ])

    utils.cancelSpinner(document.getElementById("modal-confirm-edit"), "Confirm");

    modalBodyInput.value = value

    editIngredientModal = bootstrap.Modal.getInstance(editIngredientModalElement);
})

newIngredientModalElement.addEventListener('show.bs.modal', e => {
    const modalBodyInput = newIngredientModalElement.querySelector('.modal-body input');
    modalBodyInput.value = "";

    utils.resetErrors([
        "ingredient"
    ])

    newIngredientModal = bootstrap.Modal.getInstance(newIngredientModalElement);
})

async function fetchIngredients(search = "") {
    const ingredientsContainer = document.getElementById("ingredient-items");

    utils.createSpinner(ingredientsContainer, true);

    const resp = await fetch("api/ingredients/get", {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ search })
    })

    if  (resp.status !== 200) {
        return;
    }

    const { ingredients } = await resp.json();

    utils.cancelSpinner(ingredientsContainer, "");

    if (!ingredients || ingredients.length <= 0) {
        ingredientsContainer.innerHTML = '<p class="text-secondary">No ingredients found.</p>'

        return;
    }

    ingredients.forEach(ingredient => {
        ingredientsContainer.insertAdjacentHTML("beforeend", `
            <div id="ingredient-${ingredient.ingredient_id}" class="ingredient-card shadow-sm">
                <p>${ingredient.label}</p>
                <div class="d-flex gap-2 align-items-center">
                    <button id="button-modal-${ingredient.ingredient_id}" class="btn btn-secondary btn-icon" data-bs-toggle="modal" data-bs-target="#editIngredientModal" data-bs-value="${ingredient.label}" data-bs-id="${ingredient.ingredient_id}">
                        <i class="ti ti-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-icon" onclick="handleDeleteIngredient(${ingredient.ingredient_id})">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        `)
    })
}

async function handleDeleteIngredient(id) {
    const el = document.getElementById(`ingredient-${id}`);

    const resp = await fetch('api/ingredients/remove', {
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

document.getElementById('new-ingredient-form').addEventListener('submit', async e => {
    e.preventDefault();

    const newIngredient = document.getElementById("modal-new-name").value;
    const error = document.getElementById("ingredient-error");
    const button = document.getElementById("new-ingredient-confirm")

    if (!newIngredient) {
        error.innerHTML = "This field is required";

        return;
    }

    utils.createSpinner(button);
    const resp = await fetch('api/ingredients/create', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ newIngredient })
    })

    if (resp.status !== 200) {
        return;
    }

    const data = await resp.json();

    if (!data.error) {
        await fetchIngredients();
        newIngredientModal.hide();
        utils.cancelSpinner(button, "Confirm");

        return;
    }

    utils.cancelSpinner(button, "Confirm");
    error.innerHTML = data.error;
})

document.getElementById('edit-ingredient-form').addEventListener('submit', async e => {
    e.preventDefault();

    const id = editId;
    const newValue = document.getElementById("modal-edit-name").value;

    const confirmButton = document.getElementById('modal-confirm-edit');

    utils.createSpinner(confirmButton);

    const resp = await fetch('api/ingredients/edit', {
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

    const targetElement = document.querySelector(`#ingredient-${id} > p`);
    targetElement.innerHTML = newValue;

    editIngredientModal.hide();
    document.getElementById(`button-modal-${id}`).setAttribute('data-bs-value', newValue)
})

document.getElementById('ingredients-search').addEventListener('input', utils.debounce(e => fetchIngredients(e.target.value)));

fetchIngredients().then();