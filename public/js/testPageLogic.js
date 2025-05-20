document.addEventListener('DOMContentLoaded', () => {
    for (expandButton of document.querySelectorAll('.expandButton')) {
        expandButton.addEventListener('click', (event) => {
            const tableContainer = event.target.closest('.tableContainer');
            const tableContent = tableContainer.querySelector('.datatable-wrapper');

            if (event.target.innerText == 'expand_more') {
                tableContent.classList.remove('hidden');
                event.target.innerText = 'expand_less';
            } else {
                tableContent.classList.add('hidden');
                event.target.innerText = 'expand_more';
            }
        });
    }
});