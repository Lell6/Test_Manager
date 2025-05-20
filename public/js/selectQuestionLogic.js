$(function() {
    $('#select2Select').select2({
        color: 'black',
        placeholder: '',
        ajax: {
            url: routes.questions,
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
                    text: item.question,
                    question: item.question,
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
        templateResult: function (question) {
            if (question.loading) return question.text;
            if (!question) return question.text;
        
            return $(`<div><h4>${question.question}</h4></div>`);
        },
        
        templateSelection: function (question) {
            if (!question || !question.question) return 'Wybierz pytanie';
            return $('<span id="elementOption" data-element-id="' + question.id + '">' + question.question + '</span>');
        }
    });
});