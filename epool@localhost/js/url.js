/**
 * To proper functioning module requires a meta tag
 * which shows how deep the root directory is located:
 * <meta name="_root" content="../../../">
 */
var $url = (function () {

    /**
     * Location displayed in address bar
     * at the beginning after opening the page.
     */
    var initial = window.location.href;

    /**
     * Current location displayed in address bar.
     *
     * @return {string}
     */
    var current = function () {
        return window.location.href;
    }

    /**
     * Get how deep root folder relative to initial location.
     *
     * @return {string} Multiple of '../'.
     */
    var deep = function () {
        return $('meta[name="_root"]').attr('content') || '';
    }

    /**
     * Converts any mixin of the relative url and absolute url
     * (i.e. absolute url with multiple '../' at the beggining)
     * to valid url relative to the current location.
     *
     * Use case: you loaded dynamically part of the site
     * which contains relative urls. They are invalid
     * unless you normalize them, which is equal to chaging
     * the amount of the '../' at the beginning.
     *
     * @param {string} url
     */
    var normalize = function (url) {
        var ldeep = deep();
        if (ldeep.length === 0) {
            // Single-file template
            // (skip normalization).
            return url;
        }

        // Remove beginning '#' symbol.
        if (url[0] === '#') {
            url = url.substr(1);
        }

        // Remove current dir indicator.
        while (url.indexOf('./') === 0) {
            url = url.substr(2);
        }

        // Append .html extension if not exists.
        if (url.slice(-5) !== '.html') {
            url += '.html';
        }

        // Remove beginning parent jumps.
        while (url.indexOf('../') === 0) {
            url = url.substr(3);
        }

        // Append new parent jumps.
        var prefix = '';
        var parentJumps = (ldeep.match(/..\//g) || []).length;
        for (var i = 0; i < parentJumps; ++i) {
            url = '../' + url;
        }

        if (url.indexOf('../') !== 0) {
            url = './' + url;
        }

        return url;
    }

    return {
        current: current,
        normalize: normalize,
    };

})();