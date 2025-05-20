document.addEventListener('DOMContentLoaded', () => {
    const tables = document.querySelectorAll('.dataTable');
    if (tables) {
        for (let table of tables) {
            try {
                const datatable = new DataTable(table, {
                    paging: true,
                    perPage: 5,
                    sortable: true,
                });

                const wrapper = table.closest('.datatable-wrapper');
                const container = wrapper?.querySelector('.datatable-container');
                const selector = wrapper?.querySelector('.datatable-selector');
                
                const applyCustomStyles = () => {
                    if (wrapper) wrapper.classList.add('flex', 'flex-col', 'flex-1', 'min-h-0', 'rounded', 'w-full');
                    if (container) container.classList.add('px-2','overflow-y-auto');
                    if (selector) selector.classList.add('w-[60px]');

                    for (const element of table.querySelectorAll('*')) {
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
    }
});