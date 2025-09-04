
$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();
    
    $('.session-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });
    
    $('.session-card').on('click', function(e) {
        if (!$(e.target).closest('.btn').length) {
            window.location = $(this).find('a.btn-default').attr('href');
        }
    });
    
    window.showCinemaAlert = function(message, type = 'success') {
        const alert = $('<div class="alert alert-' + type + ' alert-dismissible fade show">' +
            '<button type="button" class="close" data-dismiss="alert">×</button>' +
            message +
            '</div>');
        
        $('.content').prepend(alert);
        
        setTimeout(function() {
            alert.alert('close');
        }, 5000);
    };
});