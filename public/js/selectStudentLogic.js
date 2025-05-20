$(function() {
    $('#select2Select').select2({
        color: 'black',
        placeholder: '',
        ajax: {
            url: routes.students,
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
                    text: item.name + ' ' + item.surname,
                    name: item.name,
                    surname: item.surname,
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
        templateResult: function (user) {
            if (user.loading) return user.text;
            if (!user) return user.text;
        
            return $(`<div><h4>${user.name} ${user.surname}</h4></div>`);
        },
        
        templateSelection: function (user) {
            if (!user || !user.name || !user.surname) return 'Wybierz użytkownika';
            return $('<span id="elementOption" data-element-id="' + user.id + '">' + user.name + ' ' + user.surname + '</span>');
        }
    });
});