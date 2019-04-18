function expand(element, isFromUserCall) {
    var rowElement = $(element).closest('tr');

    // Expand when action is called by user or row is marked as expanded.
    if (isFromUserCall || $(rowElement).data('is-expanded') == 'true') {
        // Change buttons.
        $(element).hide();
        $(element).parent().find('.collapse').show();

        // Set properties.
        $(rowElement).data('is-expanded', 'true');

        // Check children for expanding.
        $(rowElement).parent().find('[data-parent-node-id="' + $(rowElement).data('node-id') + '"]').each(function () {
            if($(this).is('tr')) {
                $(this).css('display', 'table-row');
            } else {
                $(this).show();
            }
            
            expand($(this).find('.expand'));
        });
    }
}

function collapse(element, isFromUserCall) {
    var rowElement = $(element).closest('tr');

    // Change buttons.
    $(element).hide();
    $(element).parent().find('.expand').show();

    // Set properties.
    if (isFromUserCall) { $(rowElement).data('is-expanded', 'false'); }

    // Check children for narrowing.
    $(rowElement).parent().find('[data-parent-node-id="' + $(rowElement).data('node-id') + '"]').each(function () {
        if($(this).is('tr')) {
            $(this).css('display', 'none');
        } else {
            $(this).hide();
        }

        collapse($(this).find('.collapse'));
    });
}