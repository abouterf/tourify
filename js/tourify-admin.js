jQuery(document).ready(function ($) {
    $('.test-api-connection').on('click', function (e) {
        e.preventDefault();

        const postType = $(this).data('post-type');

        $.ajax({
            url: tourifyAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'test_api_connection',
                post_type: postType,
                nonce: tourifyAdmin.nonce,
            },
            beforeSend: function () {
                alert('Testing connection for ' + postType + '...');
            },
            success: function (response) {
                if (response.success) {
                    alert(response.data.message);
                } else {
                    alert(response.data.message || 'An error occurred.');
                }
            },
            error: function () {
                alert('An error occurred while testing the connection.');
            }
        });
    });
});
