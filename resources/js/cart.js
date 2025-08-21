
(function ($) {

    $('.item-quantity').on('change', function (e) {

        $.ajax({
            url: "/cart/" + $($this).data('id'),
            method: 'put',
                headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
            data: {
                quantity: $(this).val(),
                // _token: csrf_token

            }
        });

    });
}(jquery));

