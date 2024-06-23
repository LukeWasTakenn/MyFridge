function handleRemoveBookmark(id) {
    const el = document.getElementById(`recipe-${id}`);
    el.remove();

    fetch('api/bookmark/delete', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id })
    }).then();
}