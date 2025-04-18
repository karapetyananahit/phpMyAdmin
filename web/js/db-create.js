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
            let alertClass = response.success ? 'success' : 'danger';

            let $alert = $(`
                <div class="alert alert-${alertClass}">
                    ${response.message}
                </div>
            `);
            result.html($alert);

            setTimeout(function () {
                $alert.fadeOut(500, function () {
                    $(this).remove();
                });
            }, 3000);

            if (response.success) {
                form[0].reset();
                if (response.newDbHtml) {
                    $('.sidebar-fixed .db-list').append(response.newDbHtml);
                }
            }
        });
    });
});