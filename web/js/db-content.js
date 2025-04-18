let columnIndex = 1;

$(document).on('click', '.add-column', function () {
    let newRow = `
    <div class="row mb-2">
        <div class="col-md-5">
            <input type="text" name="columns[${columnIndex}][name]" class="form-control" placeholder="Column name" required>
        </div>
        <div class="col-md-5">
            <select name="columns[${columnIndex}][type]" class="form-control">
                <option value="INT">INT</option>
                <option value="VARCHAR(255)">VARCHAR(255)</option>
                <option value="TEXT">TEXT</option>
                <option value="DATE">DATE</option>
                <option value="DATETIME">DATETIME</option>
                <option value="BOOLEAN">BOOLEAN</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger remove-column">−</button>
        </div>
    </div>`;
    $('#columns-container').append(newRow);
    columnIndex++;
});

$(document).on('click', '.remove-column', function () {
    $(this).closest('.row').remove();
});

$(document).on('click', '.structure-link', function(event) {
    event.preventDefault();
    var url = $(this).attr('href');

    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            $('.content-with-sidebar').html(response);
            history.pushState(null, '', url);
        },
        error: function(xhr) {
            console.error('AJAX error:', xhr.responseText);
        }
    });
});
$(document).on('click', '.browse-link', function(event) {
    event.preventDefault();
    const url = $(this).attr('href');

    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            $('.content-with-sidebar').html(response);
            history.pushState(null, '', url);
        },
        error: function(xhr) {
            console.error('AJAX error:', xhr.responseText);
        }
    });
});

$(document).on('click', '.drop-db-btn', function (e) {
    e.preventDefault();
    const url = $(this).attr('href');
    const dbName = $(this).data('db');

    if (!confirm(`Are you sure you want to drop the database "${dbName}"?`)) {
        return;
    }

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _csrf: yii.getCsrfToken(),
        },
        success: function (response) {
            if (response.success) {
                $(`#sidebar-db-${dbName}`).remove();

                sessionStorage.setItem('dropSuccessMessage', response.message);

                history.pushState(null, '', '/');

                $.ajax({
                    url: '/',
                    type: 'GET',
                    success: function (homeContent) {
                        $('.content-with-sidebar').html(homeContent);

                        const msg = sessionStorage.getItem('dropSuccessMessage');
                        if (msg) {
                            const $alert = $(`<div class="alert alert-success drop-msg">${msg}</div>`);
                            $('.content-with-sidebar').prepend($alert);
                            sessionStorage.removeItem('dropSuccessMessage');

                            setTimeout(function () {
                                $alert.fadeOut(500, function () {
                                    $(this).remove();
                                });
                            }, 3000);
                        }

                    },
                    error: function (xhr) {
                        console.error('Failed to load homepage:', xhr.responseText);
                        $('.content-with-sidebar').html('<div class="alert alert-danger">Failed to load homepage</div>');
                    }
                });

            } else {
                alert(response.message);
            }
        },
        error: function (xhr) {
            console.error('Drop DB AJAX error:', xhr.responseText);
        }
    });
});
