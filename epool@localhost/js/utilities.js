$(function () {
    // Error for file protocol.
    if (location.protocol === 'file:') {
        var popup = $('#popup-error');
        popup.append(document.createElement("br"));
        popup.append(document.createElement("br"));
        popup.append('file:// protocol may not be supported by this browser.');
        popup.append(document.createElement("br"));
        popup.append('Please try using “Local disk (single file)” template for HTML export or use another browser.');
    }

    // #left resizable horizontaly
    var tmpWidth;
    $("#main .resizable-left").resizable({

        minWidth: 250,
        maxWidth: 600,
        handles: 'e',

        resize: function (event, ui) {

            $('.resizable-right').css('margin-left', $(this).width() + 1);

        },

    });

    // Ajax windows size
    var mainContentHeight = function () {
        var height = $(window).height();
        height -= $('#nav').is(':visible') ? $('#nav').outerHeight() : 0;
        height -= $('#footer').is(':visible') ? $('#footer').outerHeight() : 0;
        return height;
    }

    // #nav a - mark active bookmark
    $('#nav').on('click', 'a', function () {

        $('#nav a').removeClass('active');
        $(this).addClass('active');

    });

    // Mark active link
    var clicked_href = '';

    $(document).on('click', '[data-target="#right"]', function () {
        $('a[href].clicked').removeClass('clicked');

        clicked_href = $(this).attr('href');
        var root = $('meta[name="_root"]');
        if (root.length > 0) {
            clicked_href = $url.normalize(clicked_href);
        }

        $('a[href="' + clicked_href + '"]').addClass('clicked');
    });

    // Handle event which occurs when hash in the link change
    $(window).on('hashchange', function (e) {
        relativeUrl = null;

        var root = $('meta[name="_root"]');
        if (root.length > 0) {
            root = root.attr('content');
            var url = window.location.href.split('/');
            url.pop(); // Remove last element - the empty string or "*.html"

            var parentHops = (root.match(/..\//g) || []).length;
            for (var i = 0; i < parentHops; ++i) {
                url.pop();
            }

            var baseUrl = url.join('/') + '/';
            var relativeUrl = root + window.location.href.substr(baseUrl.length);

            selectNavTreeElemByHref(relativeUrl, false);
        } else {
            relativeUrl = window.location.hash;
            if (relativeUrl.indexOf('%') < 0)
                relativeUrl = encodeURI(relativeUrl);

            selectNavTreeElemByHref(relativeUrl, true);
        }
    });

    function selectNavTreeElemByHref(relativeUrl, emulateClick) {
        if (relativeUrl.length > 0) {
            var el = $('a[data-target="#right"][href="' + relativeUrl + '"]').first();
            if(emulateClick) {
                el.click();
            } else {
                el.addClass('clicked');
                $('#left .tree').trigger('restoreState');
            }
        }
        else if ($('#left ul.tree > li > ul > li').size() == 1) {
            var firstRepository = $('#left .tree a[data-target="#right"]').first();
            firstRepository.click();
            if (firstRepository.parent().siblings().length == 0) {
                firstRepository.siblings('ul').show();
                firstRepository.parent().addClass('narrow').removeClass('expand');
            }
        }
        else {
            $('a[href="#index"]').first().click();
        }
    }

    $(document).ready(function () {
        $(window).trigger('hashchange');
    });

    // Font size
    var fontSizeClassName = store.get('font-size', 'font-size-medium');
    $('body').removeClass('font-size-medium').addClass(fontSizeClassName);

    $(window).bind('content-reloaded', function () {
        $('#tools .font-size a').click(function () {
            var className = $(this).data('class');

            store.set('font-size', className);
            $('body').removeClass('font-size-small')
                .removeClass('font-size-medium')
                .removeClass('font-size-large')
                .addClass(className);
        });
    });

    // Reload page on popstate
    $(window).on("popstate", function (e) {
        var root = $('meta[name="_root"]');
        if (root.length > 0) {
            location.reload();
        }
    });
});