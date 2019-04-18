$(function () {

    function clickableUrls() {
        $('.user-description').each(function () {
            var html = $(this).html();
            if (html.indexOf('<a href="') >= 0) {
                // Prevents from double replacing.
                return;
            }

            if ($(this).is(':not(.html)')) {
                var regex =
                    '(' +
                    '((http|https|ftp|ftps)\\:\\/\\/[a-zA-Z0-9\\-\\.]+\\.[a-zA-Z]{2,3}(\\/\\S*)?)' + // Full address (e.g. https://dataedo.com)
                    '|(www\\.[a-zA-Z0-9\\-\\.]+\\.[a-zA-Z]{2,3}[a-zA-Z\.]*(\\/\\S*)?)' + // Address starting with www. (e.g. www.dataedo.com)
                    '|([a-zA-Z0-9\\-\\.]+\\.(pl|us|uk|il|au|de|fi|fr|jp|kr|nl|se|com|org|net|edu|gov|mil|live|tv)(\\/\\S*)?)' + // Address with popular domains (e.g. dataedo.com)
                    ')';

                html = html
                    .replace(new RegExp(regex, 'g'), '<a href="$&">$&</a>')
                    .replace(/<a href="((?:http|https|ftp|ftps)\:\/\/|)(.*?)">/g, function (href, protocol, site) {
                        return '<a href="' + (protocol || 'http://') + site + '">';
                    }); // add http:// to urls without http[s]://

            }

            $(this).html(html);
        });
    }

    $(window).bind('content-reloaded', clickableUrls);
    clickableUrls();

});