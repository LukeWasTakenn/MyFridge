const utils = new Utils();

const ingredientCards = document.getElementById("ingredient-cards");
const autocomplete = document.getElementById('autocomplete')

fetchIngredients().then(resp => {
    const { ingredients } = resp;
    const dataset = ingredients.map(ingredient => ingredient.label);
    utils.createAutocomplete("modal-ingredient-name", "autocomplete", dataset);
})

fetchFridgeIngredients().then(resp => {
    const { ingredients } = resp;

    if (ingredients.length < 1) return;

    ingredients.forEach(ingredient => {
        ingredientCards.insertAdjacentHTML("beforeend", `
            <div id="ingredient-${ingredient.ingredient_id}" class="col-sm-6 col-md-4 align-items-stretch" style="margin-bottom: 24px">
                <div class="card border shadow-sm p-3 h-100">
                    <div>
                        <p class="text-secondary fs-7">Ingredient</p>
                        <p>${ingredient.label}</p>
                    </div>
                    <div>
                        <p class="text-secondary fs-7">Amount</p>
                        <p>${ingredient.amount}</p>
                    </div>
                    <div>
                        <p class="text-secondary fs-7">Unit</p>
                        <p>${utils.firstToUpper(ingredient.unit)}</p>
                    </div>
                    <button class="btn btn-danger align-self-end" onclick="handleRemoveIngredient(${ingredient.ingredient_id})">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        `)
    })

});


document.getElementById('add-ingredient-form').addEventListener('submit', async e => {
    e.preventDefault();

    let shouldSubmit = true;

    const formData = new FormData(e.target);
    const values = Object.fromEntries(formData.entries());
    const fields = Object.keys(values);

    utils.resetErrors(fields);
    utils.setError("form-error", "");

    fields.forEach(field => {
        if (!values[field]) {
            utils.setError(`${field}-error`, "Field required.");
            shouldSubmit = false;
        }
    })

    if (values.ingredientUnit === "-1") {
        utils.setError('ingredientUnit-error', "Must select an option.");
        shouldSubmit = false;
    }

    if (!+values.ingredientAmount) {
        shouldSubmit = false;
        utils.setError("ingredientAmount-error", "Amount must be a number.");
    }

    if (!shouldSubmit) return;

    const ingredient = {
        name: values.ingredientName,
        amount: values.ingredientAmount,
        unit: values.ingredientUnit
    }

    const resp = await fetch('api/my-fridge/insert-ingredient', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ ingredient })
    })

    if (resp.status !== 200) {
        return;
    }

    const data = await resp.json();

    if (data.error) {
        utils.setError("form-error", data.error);
        return;
    }

    const ingredientId = data.id;

    ingredientCards.insertAdjacentHTML('beforeend', `
        <div id="ingredient-${ingredientId}" class="col-sm-6 col-md-4 align-items-stretch" style="margin-bottom: 24px">
            <div class="card border shadow-sm p-3 h-100">
                <div>
                    <p class="text-secondary fs-7">Ingredient</p>
                    <p>${ingredient.name}</p>
                </div>
                <div>
                    <p class="text-secondary fs-7">Amount</p>
                    <p>${ingredient.amount}</p>
                </div>
                <div>
                    <p class="text-secondary fs-7">Unit</p>
                    <p>${utils.firstToUpper(ingredient.unit)}</p>
                </div>
                <button class="btn btn-danger align-self-end" onclick="handleRemoveIngredient(${ingredientId})">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
        </div>
    `)

    const modalEl = document.getElementById("addIngredientModal");
    const modal = bootstrap.Modal.getInstance(modalEl);

    e.target.reset();

    modal.hide();
})

async function handleRemoveIngredient(id) {
    const ingredient = document.getElementById(`ingredient-${id}`);
    ingredient.remove();
    await fetch('api/my-fridge/remove-ingredient', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    })
}

async function fetchFridgeIngredients() {
    const resp = await fetch('api/my-fridge/get-ingredients', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
    })

    if (resp.status !== 200) return;

    return await resp.json();
}

async function fetchIngredients() {
    const resp = await fetch('api/ingredients/get', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ search: "" })
    })

    if (resp.status !== 200) return;

    return await resp.json();
}