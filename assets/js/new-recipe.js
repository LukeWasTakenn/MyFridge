const utils = new Utils();

const quill = new Quill('#editor', {
    theme: 'snow',
    bounds: document.getElementById("container")
})

const recipeForm = document.getElementById("recipe-form");
const ingredientFields = document.getElementById("ingredients-fields");

let recipeIngredients = [

]

let ingredientId = 0;

const autocomplete = document.getElementById('autocomplete')

fetchIngredients().then(resp => {
    const { ingredients } = resp;
    const dataset = ingredients.map(ingredient => ingredient.label);
    utils.createAutocomplete("modal-ingredient-name", "autocomplete", dataset);
});

document.getElementById('add-ingredient-form').addEventListener('submit', e => {
    e.preventDefault();

    let shouldSubmit = true;

    const formData = new FormData(e.target);
    const values = Object.fromEntries(formData.entries());
    const fields = Object.keys(values);

    utils.resetErrors(fields);

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

    recipeIngredients.push({
        ingredientId,
        ingredient: values.ingredientName,
        amount: values.ingredientAmount,
        unit: values.ingredientUnit
    })

    ingredientFields.insertAdjacentHTML('beforeend', `
        <div id="ingredient-${ingredientId}" class="d-flex p-3 border shadow-sm flex-column rounded gap-2">
            <div class="d-flex flex-column">
                <p class="fs-7 text-secondary">Ingredient</p>
                <p>${utils.firstToUpper(values.ingredientName)}</p>
            </div>
            <div class="d-flex flex-column">
                <p class="fs-7 text-secondary">Amount</p>
                <p>${values.ingredientAmount}</p>
            </div>
            <div class="d-flex flex-column">
                <p class="fs-7 text-secondary">Unit</p>
                <p>${utils.firstToUpper(values.ingredientUnit)}</p>
            </div>
            <div class="d-flex align-self-end gap-2">
                <button type="button" class="btn btn-secondary btn-icon">
                    <i class="ti ti-edit"></i>
                </button>
                <button type="button" class="btn btn-danger btn-icon" onclick="handleRemoveIngredient(${ingredientId});">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
        <div>
    `)
    ingredientId++;


    const modalEl = document.getElementById("addIngredientModal");
    const modal = bootstrap.Modal.getInstance(modalEl);

    console.log(modal);

    e.target.reset();

    modal.hide();
})

function handleRemoveIngredient(id) {
    const ingredient = document.getElementById(`ingredient-${id}`);
    ingredient.remove();

    recipeIngredients = recipeIngredients.filter(ing => ing.ingredientId !== id);
}


function handleAddImage() {

}

recipeForm.addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const values = Object.fromEntries(formData.entries());
    const fields = Object.keys(values);
    const ingredients = recipeIngredients;

    let shouldSubmit = true;

    utils.resetErrors(fields);
    utils.setError('ingredients-error', "");
    utils.setError("recipeDetails-error", "");
    utils.setError("recipe-form-error", "");

    fields.forEach(field => {
        if (!values[field]) {
            utils.setError(`${field}-error`, "Field required.");
            shouldSubmit = false;
        }
    })

    if (values.recipeCategory === "-1") {
        utils.setError("recipeCategory-error", "Must select category.");
        shouldSubmit = false;
    }

    if (quill.getText().length <= 1) {
        utils.setError("recipeDetails-error", "Details are required.");
        shouldSubmit = false;
    }

    console.log(ingredients.length)
    if (ingredients.length <= 0) {
        utils.setError("ingredients-error", "Ingredients must be added.");
        shouldSubmit = false;
    }

    if (!+values.costEstimate) {
        utils.setError("costEstimate-error", "Estimated cost must be a number.")
        shouldSubmit = false;
    }

    if (!+values.cookTime) {
        utils.setError("cookTime-error", "Cook time must be a number.");
        shouldSubmit = false;
    }

    if (!shouldSubmit) return;

    const recipe = {
        name: values.recipeName,
        category: values.recipeCategory,
        cookTime: values.cookTime,
        costEstimate: values.costEstimate,
        description: quill.getContents(),
        images: [],
        ingredients
    }

    const submitButton = document.getElementById("recipe-submit");

    utils.createSpinner(submitButton);

    const resp = await fetch('api/recipe/create', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ recipe })
    })

    if (resp.status !== 200) {
        utils.cancelSpinner(submitButton, `
            <i class="ti ti-send"></i>
            Submit recipe
        `)
        return;
    }

    const data = await resp.json();

    if (data.error) {
        utils.setError("recipe-form-error", data.error);
        utils.cancelSpinner(submitButton, `
            <i class="ti ti-send"></i>
            Submit recipe
        `)

        return;
    }

    // window.location.href = ...

    console.log('Ok!')

    return;
})

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