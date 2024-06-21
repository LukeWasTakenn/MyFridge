const utils = new Utils();

const denyRecipeModalElement = document.getElementById("denyRecipeModal");

let recipeId;
let denyRecipeModal;

denyRecipeModalElement.addEventListener('show.bs.modal', e => {
    const button = e.relatedTarget;
    recipeId = button.getAttribute("data-bs-recipeId");

    document.getElementById("input-reason").value = "";

    denyRecipeModal = bootstrap.Modal.getInstance(denyRecipeModalElement);
})

async function handleDenyRecipe() {
    const reason = document.getElementById("input-reason").value;

    if (!reason) {
        utils.setError("reason-error", "Reason is required.");
        return;
    }

    const button = document.getElementById("submit-button");

    utils.createSpinner(button);

    const resp = await fetch("api/recipe/deny-recipe", {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ recipeId, reason })
    })

    if (resp.status !== 200) {
        utils.cancelSpinner(button, "Confirm")
        return;
    }

    const data = await resp.json();

    if (data.error) return;

    document.getElementById(`recipe-${recipeId}`).remove();

    denyRecipeModal.hide();
}

async function handleAcceptRecipe(recipeId) {
    const resp = await fetch('api/recipe/approve-recipe', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ recipeId })
    })

    if (resp.status !== 200) {
        return;
    }

    const data = await resp.json();

    if (data.error) return;

    document.getElementById(`recipe-${recipeId}`).remove();
}