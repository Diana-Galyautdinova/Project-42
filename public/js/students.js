jQuery(function ($) {
    $('#addStudent')
        .on('submit', function (e) {
            e.preventDefault();

            var $form = $(e.currentTarget);

            $
                .ajax({
                    method: 'POST',
                    url: $form.attr('action'),
                    dataType: 'json',
                    data: $form.serialize(),
                    success: function (data) {
                        if (data.response) {
                            $('.list-group.list-group-flush')
                                .append(
                                    $('<li>')
                                        .addClass('list-group-item')
                                        .addClass('d-flex')
                                        .addClass('justify-content-between')
                                        .addClass('align-items-center')
                                        .text(data.response.id + '. ' + data.response.firstname + ' ' + data.response.lastname + ' - ' + data.response.averageMark)
                                );
                            $('#addStudent')
                                .find('input')
                                .val('');
                        }
                    }
                });
        });

    $('.js-delete')
        .on('click', function (e) {
            var $button = $(e.currentTarget);

            $
                .ajax({
                    method: 'POST',
                    url: $button.data('url'),
                    data: {
                        id: $button.data('id'),
                    },
                    success: (function (_$button) {
                        $button = _$button;

                        return function (data) {
                            console.log(data);
                            if (data.response) {
                                $button
                                    .closest('li')
                                    .remove();
                            }
                        }
                    })($button)
                })
        })
});
