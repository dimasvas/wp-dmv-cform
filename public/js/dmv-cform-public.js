(function ($) {
    $(function () {
        $('#dmv-contact-form').submit(function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                action: 'dmv_handle_ajax_request',
                data: {
                    form: $(this).serialize(),
                    action: "dmv_handle_ajax_request",
                },
                success: function (response) {
                    clear_inputs();
                }
            })
        });
    });

    function clear_inputs() {
        $('#name, #email, #subject, #message').val("");
        $('#success-msg').css('visibility', 'visible');
    }
}(jQuery));
