async function getData(url) {    
    document.body.classList.add('cursor-wait');
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 5000);

    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        clearTimeout(timeoutId);

        const json = response.json();
        document.body.classList.remove('cursor-wait');

        return json;
    } catch (error) {
        document.body.classList.remove('cursor-wait');
        return { error: true, message: 'An error occurred while retrieving the data. Please try again later.' };
    }
}