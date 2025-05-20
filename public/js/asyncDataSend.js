async function sendData(json, url, method = 'POST') {
    const csrfToken = document.querySelector('input[name="_token"]').value;
    document.body.classList.add('cursor-wait');

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(json),
            credentials: 'same-origin'
        });

        const responseBody = await response.json();

        if (!response.ok) {
            throw { message: responseBody.message, errors: responseBody.errors };
        }

        document.body.classList.remove('cursor-wait');
        return responseBody;
    } catch (error) {
        document.body.classList.remove('cursor-wait');
        return error.errors;
    }
}