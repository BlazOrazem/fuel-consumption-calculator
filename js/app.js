$(document).ready(function() {
    $('button[data-fuel]').click(function() {
        $('button[data-fuel]').removeClass('active');
        $(this).addClass('active');
        var el = $(this).data('fuel');
        $('input[name="fuel"]').each(function() {
            if ($(this).val() == el) {
                $(this).click();
            }
        });
    });
});