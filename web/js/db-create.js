$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('submit', '#create-db-form', function(e) {
        e.preventDefault();
        let form = $(this);
        $.post(form.attr('action'), form.serialize(), function(response) {
            let result = $('#db-create-result');
            if (response.success) {
                result.html('<div class="alert alert-success">' + response.message + '</div>');
                form[0].reset();

                if (response.newDbHtml) {
                    $('.sidebar-fixed ul').append(response.newDbHtml);
                }
            } else {
                result.html('<div class="alert alert-danger">' + response.message + '</div>');
            }
        });
    });

});