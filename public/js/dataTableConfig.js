document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('#dataTable');
    if (table) {
        try {
            const datatable = new DataTable("#dataTable", {
                paging: true,
                perPage: 5,
                sortable: true,
            });

            const applyCustomStyles = () => {
                document.querySelector('.datatable-wrapper').classList.add('flex', 'flex-col', 'flex-1', 'min-h-0', 'rounded', 'w-full');
                document.querySelector('.datatable-container').classList.add('px-2','overflow-y-auto');
                document.querySelector('.datatable-selector').classList.add('w-[60px]');
                for (const element of document.querySelectorAll('.datatable-table *')) {
                    element.classList.add('p-1', '!align-middle');
                }
            };

            datatable.on('datatable.init', applyCustomStyles);
            datatable.on('datatable.page', applyCustomStyles);
            datatable.on('datatable.sort', applyCustomStyles); // optional
            datatable.on('datatable.update', applyCustomStyles);

            // Run once on first load
            applyCustomStyles();
            table.classList.remove('hidden');
        } catch (error) {
            console.error('Error initializing DataTable:', error);
        }
    }
});