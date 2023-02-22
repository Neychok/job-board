$(document).ready(function(){
    $('.approve-button').on('click', (e) => {
        e.preventDefault();

        $e = $(e.target);
        console.log($e.next())

        $.ajax({
            url: "admin-post.php",
            type: 'POST',
            data: {
                'action': 'approve',
                'job': $e.data('id')
            },
            success: function(){
                $e.hide();
                $e.next().show();
            }
        });

    })
    $('.reject-button').on('click', (e) => {
        e.preventDefault();

        $e = $(e.target);

        $.ajax({
            url: "admin-post.php",
            type: 'POST',
            data: {
                'action': 'reject',
                'job': $e.data('id')
            },
            success: function(){
                $e.hide();
                $e.prev().show();
            }

        });
    })
    $('.delete-button').on('click', (e) => {
        e.preventDefault();

        $e = $(e.target);

        $.ajax({
            url: "admin-post.php",
            type: 'POST',
            data: {
                'action': 'delete',
                'job': $e.data('id')
            },
            success: function(){
                $e.closest('.job-card').slideUp(600);
            }

        });
    })
    $('.delete-submission-button').on('click', (e) => {
        e.preventDefault();

        $e = $(e.target);

        $.ajax({
            url: "admin-post.php",
            type: 'POST',
            data: {
                'action': 'delete-submission',
                'application': $e.data('id'),
            },
            success: function(){
                $e.closest('.job-card').slideUp(600);
            }

        });
    })
});