$(function () {

    var settings = {
        highlightMatches: true,
        dropdownAnimTime: 200,
        searchIn: ['full-name']
    }

    var classes = {
        input: 'search-input',
        hidden: 'search-item-hidden',
        match: 'search-item-match'
    }

    var urlPrefix = '#';

    /**
     * Prepend selectors with given scope:
     * scope.find(...)
     */
    var scope = $('#left .tree');

    var cache = {};

    var json = window._search;

    function init() {
        resetSearchOptionsState();

        // Cache HTML tags.
        cache.li = scope.find('li');
        cache.ajax = scope.find('li > .ajax');
        cache.input = $('.' + classes.input);
        cache.dropdownBtn = $('.search-options-btn');
        cache.dropdown = $('.search-options-dropdown');
        cache.icon = $('.search-icon');
        cache.box = $('.search-box');
        cache.page = $('#right');

        cache.links = {};
        $.each(cache.ajax, function (i, link) {
            var href = $(link).attr('href');
            href = $url.normalize(href);
            cache.links[href] = $(link);
        });

        // Listen for user actions.
        cache.input.keydown($.debounce(250, onInputKeyDown));
        cache.dropdownBtn.click(onDropdownBtnClick);
        cache.icon.click(onSearchClick);
        $('input[data-search]').change(onOptionsCheckboxChange);
        $(document).click(onDocumentClick);
        $(window).bind('content-reloaded', searchInPage);
    }

    /**
     * Add specified string in text at given index.
     *
     * @param {!string} str String to add.
     * @param {!string} text Text to modify.
     * @param {!number} index Index at which add string.
     * @return {!string}
     */
    function insertStrToStrAt(str, text, index) {
        text = text.split('');
        text.splice(index, 0, str);
        return text.join('');
    }

    /**
     * Bold selected indices in string.
     *
     * @param {!Object} tag The jQuery object.
     * @param {!Array} indices List of indices in ascending order, e.q. [[0,4], [6,8], ...].
     */
    function boldMatches(tag, indices) {
        var text = $(tag).text().trim().replace(/[\s]+/g, ' ');
        indices = indices.reverse();

        $.each(indices, function (i, index) {
            text = insertStrToStrAt('</span>', text, index[1] + 1);
            text = insertStrToStrAt('<span class="' + classes.match + '">', text, index[0]);
        });

        $(tag).html(text);
    }

    /**
     * Remove all bolds added via boldMatches method.
     */
    function unboldMatches() {
        var links = cache.ajax;
        $.each(links, function (i, link) {
            $(link).find('.' + classes.match).contents().unwrap();
        });

        cache.page.find('[rel="column-full-name"]').each(function (i, tag) {
            $(tag).find('.' + classes.match).contents().unwrap();
        });
    }

    /**
     * Show whole menu tree.
     */
    function showAll() {
        scope.trigger('restoreState');
        cache.li.removeClass(classes.hidden);
        if (settings.highlightMatches) {
            unboldMatches();
        }
    }

    /**
     * Show in tree only specified items.
     *
     * @param {!Array} results Fuse.js library result.
     */
    function showOnly(results) {
        // Hide all folders and links.
        cache.li.addClass(classes.hidden);
        if (settings.highlightMatches) {
            unboldMatches();
        }

        // Show only specified items and folders.
        $.each(results, function (i, result) {
            var url = urlPrefix + result.item.url;
            var link = cache.links[$url.normalize(url)];

            // Show link and all parent folders.
            if (link) {
                link.show();
                link.parentsUntil(scope).removeClass(classes.hidden);
                scope.trigger('expandAll');

                // Bold matches.
                if (settings.highlightMatches) {
                    $.each(result.matches, function (i, match) {
                        if (match.key === 'full-name') {
                            boldMatches(link, match.indices);
                        }
                    });
                }
            }
        });
    }

    /**
     * [
     *     {
     *         item: <source-data-object>,
     *         matches: [
     *             {
     *                 key: <key-from-item>,
     *                 indices: [[<from>, <to>], [4,6], ..]
     *             },
     *             ..
     *         ]
     *     },
     *     ..
     * ]
     */
    function searchJson(pattern) {
        var keys = settings.searchIn;

        var results = [];
        $.each(json, function (i, item) {
            var matches = [];
            $.each(keys, function (j, key) {
                var match = _searchItemKey(item, key, pattern);

                if (match !== null) {
                    matches.push(match);
                }
            });

            if (matches.length > 0) {
                results.push({
                    item: item,
                    matches: matches
                })
            }
        });

        return results;
    }

    function searchIn(pattern, subjects) {
        var parts = pattern.trim().toLowerCase().replace(/[\s]+/g, ' ').split(' ');
        var textArr = Array.isArray(subjects) ? subjects : [subjects];

        var indices = [];
        var foundInArrayOfText = false;
        $.each(textArr, function (_, text) {
            text = text.trim().toLowerCase().replace(/[\s]+/g, ' '); // Change multiple whitespaces to single space
            var cancelInnserSearch = false;
            $.each(parts, function (i, part) {
                var found = false;
                var from = 0;
                while (from !== -1) {
                    var from = text.indexOf(part, from);
                    var to = from + part.length - 1;

                    if (from >= 0) {
                        indices.push([from, to]);
                        from += 1;
                        found = true;
                    }
                }

                cancelInnserSearch |= !found;
            });

            if (!cancelInnserSearch) {
                foundInArrayOfText = true;
            }
        });

        if (!foundInArrayOfText) {
            return null;
        }

        return _normalizeIndices(indices);
    }

    function _searchItemKey(item, key, pattern) {
        var textArr = [];
        if (Array.isArray(item[key])) {
            $.each(item[key], function (_, s) {
                textArr.push(s.toLowerCase());
            });
        } else {
            textArr.push(String(item[key]).toLowerCase());
        }

        var indices = searchIn(pattern, textArr);
        if (indices === null) {
            return null;
        }

        return {
            key: key,
            indices: indices
        }
    }

    function _normalizeIndices(indices) {
        var tmp = indices;

        var positions = [];
        $.each(indices, function (i, indice) {
            for (var j = indice[0]; j <= indice[1]; ++j) {
                positions.push(j);
            }
        });

        // Get unique values and sort ascending.
        positions = positions.filter(function (value, index, self) {
            return self.indexOf(value) === index;
        }).sort(function (a, b) {
            return a - b;
        });

        var indices = [];
        var from = null;
        var to = null;
        for (var j = 0; j < positions.length; ++j) {
            if (from === null) {
                from = positions[j];
                to = positions[j];
                continue;
            }

            // If element continues group.
            if (to + 1 === positions[j]) {
                to = positions[j];
                continue;
            }

            if (to + 1 < positions[j]) {
                indices.push([from, to]);
                from = positions[j];
                to = positions[j];
                continue;
            }
        }

        if (from !== null) {
            indices.push([from, to]);
        }

        return indices;
    }

    /**
     * Filter menu tree using user pattern.
     *
     * Whole tree is displayed if pattern is an empty string or null.
     *
     * @param {?string} pattern User query string.
     */
    function search(pattern) {
        if (pattern === null || pattern.trim().length === 0) {
            showAll();
            return;
        }

        var results = searchJson(pattern);
        showOnly(results);
        searchInPage();
    }

    function onInputKeyDown() {
        var pattern = $(this).val();
        cache.box.toggleClass('-with-search-started', pattern.length > 0);
        search(pattern);
    }

    function toggleOptionsDropdown() {
        cache.dropdown.slideToggle(settings.dropdownAnimTime);
    }

    function hideOptionsDropdown() {
        cache.dropdown.slideUp(settings.dropdownAnimTime);
    }

    function onDropdownBtnClick() {
        toggleOptionsDropdown();
    }

    function onDocumentClick(e) {
        var btn = $(e.target).closest(cache.dropdownBtn);
        var menu = $(e.target).closest(cache.dropdown);
        if (btn.length === 0 && menu.length === 0) {
            hideOptionsDropdown();
        }
    }

    function onOptionChange(name) {
        if (getOption('columns', false)) {
            settings.searchIn = ['full-name', 'columns'];
        } else {
            settings.searchIn = ['full-name'];
        }
    }

    function getOption(name, defaultValue) {
        if (typeof window.sessionStorage !== 'object') {
            return defaultValue;
        }

        return JSON.parse(window.sessionStorage.getItem('search.options.' + name)) || defaultValue;
    }

    function setOption(name, value) {
        window.sessionStorage.setItem('search.options.' + name, JSON.stringify(value));
        onOptionChange(name);
    }

    function onOptionsCheckboxChange() {
        var name = $(this).data('search');
        var value = $(this).is(':checked');

        setOption(name, value);
        search(cache.input.val());
    }

    function resetSearchOptionsState() {
        var checkboxes = ['columns'];

        $.each(checkboxes, function (i, checkbox) {
            var value = getOption(checkbox, false);
            $('input[data-search="' + checkbox + '"]').prop('checked', value);
            onOptionChange(checkbox);
        });
    }

    function onSearchClick() {
        if (cache.input.val().length > 0) {
            cache.input.val('').keydown();
            hideOptionsDropdown();
            return false;
        }
    }

    function searchInPage() {
        var pattern = cache.input.val();
        if (pattern.length === 0) {
            return true;
        }

        if (settings.searchIn.indexOf('columns') >= 0) {
            cache.page.find('[rel="column-full-name"]').each(function (i, tag) {
                var indices = searchIn(pattern, $(tag).text());
                if (indices !== null) {
                    boldMatches(tag, indices);
                }
            });
        }
    }

    init();
});