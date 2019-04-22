jQuery(function ($) {
    $('.test_tag_link')
        .on('click', function (e) {
            e.preventDefault();
            var $link = $(e.currentTarget);
            $
                .ajax({
                    method: 'POST',
                    url: $link.attr('href'),
                    data: {
                        name: $link.attr('name')
                    }
                })
                .done(console.log);
        });
});
