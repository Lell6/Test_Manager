$(function() {
    $('#select2Select').select2({
        color: 'black',
        placeholder: '',
        ajax: {
            url: routes.groups,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                const items = data.map(item => ({
                    id: item.id,
                    text: item.name,
                    name: item.name,
                }));

                return {
                    results: items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            }
        },
        minimumInputLength: 3,
        language: {
            inputTooShort: function (args) {
                var remaining = args.minimum - args.input.length;
                return 'Minimalna długość: ' + remaining + ' znaków';
            }
        },
        templateResult: function (name) {
            if (name.loading) return name.text;
            if (!name) return name.text;
        
            return $(`<div><h4>${name.name}</h4></div>`);
        },
        
        templateSelection: function (name) {
            if (!name || !name.name) return 'Wybierz klasę';
            return $('<span id="elementOption" data-element-id="' + name.id + '">' + name.name + '</span>');
        }
    });
});