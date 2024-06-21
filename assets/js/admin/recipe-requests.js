function handleDenyRecipe() {

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

    document.getElementById(`recipe-${recipeId}`).remove();
}