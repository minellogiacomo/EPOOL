/**
 * @param: object obj
 * @param: integer time
 */
function toggleTree(obj, time) {
    var count = $(obj).find('li:visible').length;
    if (count == 0) {
        count = $(obj).find('.narrow li:hidden').length + $(obj).find('> ul > li:hidden').length;
    }

    var duration = count * time;
    if (duration > 600) {
        duration = 600;
    }

    $(obj).find('> ul').stop().slideToggle({

        'duration': duration,
        'easing': 'linear'

    });

    $(obj).toggleClass('narrow').toggleClass('expand');
}

function showTree(obj, time) {
    var count = $(obj).find('li:visible').length;
    if (count == 0) {
        count = $(obj).find('.narrow li:hidden').length + $(obj).find('> ul > li:hidden').length;

        var duration = count * time;
        if (duration > 600) {
            duration = 600;
        }

        $(obj).find('> ul').stop().slideDown({
            'duration': duration,
            'easing': 'linear'
        });

        $(obj).addClass('narrow').removeClass('expand');
    }
}


/**
 * Attach event
 */
$('<ul class="tree"><li class="expand narrow"><a href="#"></a></li></ul>').appendTo('#binding').hide(0);

// Expanding tree
$(document).on('click', '.expand, .narrow', function (e, data) {
    var x = e.pageX - $(this).offset().left;
    var y = e.pageY - $(this).offset().top;

    if ((x <= 25 && y <= 25) || (data && data.search)) {
        if ($(this).hasClass('expand') && $(this).find('> a:hidden').length == 1) {
            $(this).find('> a:hidden').click();
        }
        else {
            toggleTree(this, 20);
        }

        var isSearchInputEmpty = $('.search-input').val().length === 0;
        if (typeof window.sessionStorage === 'object' && isSearchInputEmpty) {
            var href = $(this).find('> a.ajax').attr('href');
            if (href != undefined) {
                var items = JSON.parse(window.sessionStorage.getItem('ExpandedTreeItems')) || {};

                if ($(this).hasClass('narrow')) items[href] = true;
                else delete items[href];

                window.sessionStorage.setItem('ExpandedTreeItems', JSON.stringify(items));
            }
        }
    }
});

$(document).on('expandAll', '#left .tree', function (e) {
    var li = $('#left .tree li.expand');
    li.addClass('narrow').removeClass('expand');
    li.children('ul').show();
});

$(document).on('narrowAll', '#left .tree', function (e) {
    var li = $('#left .tree li.narrow');
    li.addClass('expand').removeClass('narrow');
    li.children('ul').hide();
});

$(document).on('restoreState', '#left .tree', function (e, time) {
    $(this).trigger('narrowAll');
    if (typeof window.sessionStorage === 'object') {
        var items = JSON.parse(window.sessionStorage.getItem('ExpandedTreeItems')) || {};

        for (var href in items) {
            var node = $('#left .tree a.ajax[href="' + href + '"]').parent('li.expand');
            showTree(node, time || 0);
        }
    }

    var parents = $('#left .tree a.ajax.clicked').parents('li.expand');
    $.each(parents, function (i, parent) {
        showTree(parent, time || 0);
    });
});

// Recover tree state
$(function () {
    if (typeof window.sessionStorage === 'object') {
        var items = JSON.parse(window.sessionStorage.getItem('ExpandedTreeItems')) || {};
        var li = $('#left .tree > li > ul > li');
        if (jQuery.isEmptyObject(items) && li.length === 1) {
            var href = li.find('a.ajax:first').attr('href');

            items[href] = true;
            window.sessionStorage.setItem('ExpandedTreeItems', JSON.stringify(items));
        }
    }

    $('#left .tree').trigger('restoreState');
});

/* ================================================================== */

$(document).on('click', 'a.ajax-tree', function (event) {

    event.preventDefault();

    // Execute event on object
    if ($(this).data('target')) {

        var targetStr = $(this).data('target').replace(/\s+/g, ' ');
        var target = parseObject(this, targetStr);

    }

    // Loader
    var parent = $(this).parent();
    $(parent).toggleClass('narrow').toggleClass('expand').find('i').addClass('icon-loader');

    $(this).remove();

    // Execute query
    $.ajax({
        url: $(this).attr('href'),
        cache: false,
    }).done(function (html) {
        // No data - disable extending tree node
        if (html.length == 0) {

            $(parent).removeClass('narrow').removeClass('expand').find('i').removeClass('icon-loader');

        }

        // Show up data
        else {
            if ($(parent).hasClass('narrow')) {
                $(parent).find('ul').append(html);
                toggleTree(parent, 20);
            }
            else {
                $(parent).find('ul').append(html);
                toggleTree(parent, 0);
            }

            $(parent).toggleClass('narrow').toggleClass('expand').find('i').removeClass('icon-loader');
        }
    }).fail(function (data) {
        $(parent).removeClass('narrow').removeClass('expand').find('i').removeClass('icon-loader').addClass('icon-error');
    });

});
