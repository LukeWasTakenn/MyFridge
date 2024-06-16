async function handleLogout() {
    const resp = await fetch('api/logout', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        }
    })

    if (resp.status !== 200) {
        return;
    }

    const data = await resp.json();

    if (!data.success) return;

    window.location.href = './';
}