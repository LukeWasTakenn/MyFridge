async function handleDeleteRecipe(id) {
    const resp = await fetch('api/recipe/delete', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    })

    if (resp.status !== 200) {
        return;
    }

    const data = await resp.json();

    if (data.error) return;

    const el = document.getElementById(`recipe-${id}`);
    el.remove();
}