const recipeForm = document.getElementById("recipe-form");
const ingredientFields = document.getElementById("ingredients-fields");

let ingredientCounter = 0;

function handleRemoveIngredient(position) {
    ingredientFields.removeChild(document.getElementById(`ingredient-${position}`));
}

function handleAddIngredient() {
    const elementStr = `
        <div class="d-flex gap-2 align-items-center" id="ingredient-${ingredientCounter}">
            <input class="form-control" placeholder="Ingredient..." name="ingredient[${ingredientCounter}][name]"/>
            <input class="form-control" placeholder="Amount..." name="ingredient[${ingredientCounter}][amount]"/>
            <select class="form-select" name="ingredient[${ingredientCounter}][unit]">
                <option selected value="-1">- Select a unit - </option>
                <option value="count">Count</option>
                <option value="gram">Gram</option>
                <option value="liter">Liter</option>
            </select>
            <button class="btn btn-danger" style="width: 38px; height: 38px" onclick="handleRemoveIngredient(${ingredientCounter});">
                <i class="ti ti-x"></i>
            </button>
        </div>
    `

    ingredientFields.insertAdjacentHTML("beforeend", elementStr);
    ingredientCounter++;
}

function handleAddImage() {

}

recipeForm.addEventListener('submit', e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const values = Object.fromEntries(formData.entries());

    console.log(values)

})