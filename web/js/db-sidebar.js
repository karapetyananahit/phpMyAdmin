let lastClickedDb = null;

$(document).on('click', '.db-link-hover', function(event) {
    event.preventDefault();
    var dbName = $(this).text().trim();
    let url = $(this).data('url');

    if (dbName === lastClickedDb) {
        return;
    }
    lastClickedDb = dbName;
    $.ajax({
        url: url,
        type: 'GET',
        data: { db: dbName },
        success: function(response) {
            $('.content-with-sidebar').html(response);
            history.pushState(null, '', url + '&db=' + encodeURIComponent(dbName));
        },
        error: function(xhr) {
            console.error('AJAX error:', xhr.responseText);
        }
    });
});
