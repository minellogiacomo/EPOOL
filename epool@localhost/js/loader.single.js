var loaderTimeOut;
var RESOURCE_TIMESTAMP_TAG = '20150703'

function expandBreadcrumbPath() {
    $("#breadcrumb a:not(:last)").each(function (i, el) {
        var href = $(el).attr('href');
        var tree_node = $("#left .tree").find("a[href='" + href + "']").parent();
        showTree(tree_node, 20);
    });
}

/**
 * Ajax handler
 * 
 * @param: object obj
 * @param: object target
 */
var stickyHeader = null;
function doAjax(obj, target, clicked) {

    var ajaxTime = new Date().getTime();
    $(target).stop().fadeOut(200, 'linear');

    // wyślij zapytanie
    var contentUrl = window.location.hash.replace(/\#(.*)$/, '').split('/');
    contentUrl.pop();
    contentUrl.push($(obj).attr('href').substr(1));
    contentUrl = contentUrl.join('/');

    var anchor = window.location.hash.substr(1);
    if (anchor.indexOf('%') < 0)
        anchor = encodeURI(anchor);

    // aktualizacja linku
    var relativeUrl = $(obj).attr('href').replace(/\.html$/, '').substr(1);
    if (anchor != relativeUrl && relativeUrl !== 'home') {
        window.location.href = window.location.href.replace(/(\?|\#)(.*)/, '') + "#" + relativeUrl;
        return;
    }

    if (clicked == clickedStatus) {

        var totalTime = new Date().getTime() - ajaxTime;
        if (totalTime < 200) totalTime = 200 - totalTime;
        else totalTime = 0;

        setTimeout(function () {

            // Get element id to which we'll be scrolled
            var pageSourceTag = $('[data-page="' + decodeURI(contentUrl) + '"]');
            if (pageSourceTag.length === 0) {
                var pageSourceTag = $('[data-page="' + contentUrl + '"]');
            }

            var parts = $(pageSourceTag.html()).removeAttr('data-page');
            var rowNumber = null
            if (anchor !== undefined) {
                for (var i = 0; i < parts.length; i++) {
                    if ($(parts[i]).attr("id") == anchor) {
                        rowNumber = i;
                    }
                }
            }
            response = parts;

            if (stickyHeader !== null) stickyHeader.destroy();

            $(window).scrollTop(0);
            $(target).html(response).fadeIn(200, 'linear');
            stickyHeader = window.Sticky(target.find('.sticky-header'));
            $(window).trigger('content-reloaded');

            // Scroll if anchor is set
            if (rowNumber !== null) {
                $('.resizable-right').animate({ scrollTop: (Math.floor($(response[rowNumber]).offset().top) - 40) }, 800);
            }

            expandBreadcrumbPath();

            // Hide menu on mobile
            $('#aside').hide();


        }, totalTime);

    }
}


/**
 * Ajax url parser
 */
function parseObject(from, objStr) {

    var object;
    var objectString = new Array();

    objectString = objStr.split(' ');
    $(objectString).each(function (index, element) {
        if (!$(object).length) {
            if (element == 'this') object = $(from);
            else object = $(element);
        }
        else {
            if (element == 'parent') object = $(object).parent();
            else object = $(object).find(element);
        }
    });

    return object;
}



/**
 * Attach event
 */
var clickedStatus;

$('<a class="ajax">').appendTo('#binding').hide(0);
$('<a class="ajax-tree">').appendTo('#binding').hide(0);

$(document).on('click', 'a.ajax, g.node[href]', function (event) { // g.node[href] - erd link

    event.preventDefault();
    clickedStatus = Math.floor(Math.random() * 1000);

    // Hide element
    if ($(this).data('clear')) {
        var clear = new Array();
        clear = $(this).data('clear').replace(/\s+/g, ' ').split(',');

        $(clear).each(function (index, objStr) {
            $(parseObject(this, objStr)).stop().slideUp(200);
        });
    }

    // Execute event on element
    if ($(this).data('target')) {

        var targetStr = $(this).data('target').replace(/\s+/g, ' ');
        var target = parseObject(this, targetStr);

    }

    // Execute request
    doAjax(this, target, clickedStatus);

    // For direct links
    var url = window.location.href;
    url = url.split("?");
    if (url[1]) {
        directLink();
        history.replaceState(null, "", "?");
    }

});

/**
 * Load properly content when we past direct link in the browser.
 */
function directLink() {
    category = getUrlVars()["c"];
    file = getUrlVars()["f"];
    archon = getUrlVars()["a"];

    target = $("#right");
    clickedStatus = Math.floor(Math.random() * 1000);
    if ((category !== undefined) && (file !== undefined)) {
        redirectUrl = "content/" + category + "/" + file + ".html";
        if (archon !== undefined) {
            redirectUrl += "#" + archon;
        }

        var obj = {
            "href": redirectUrl
        }

        doAjax(obj, target, clickedStatus);

        // Extend menu tree to make visible current link
        $("#tree_" + category).toggleClass('narrow').toggleClass('expand');
        $("#tree_" + category).children("ul").css("display", "block");
        var hrefs = $("#tree_" + category).children("ul").children().children("a");
        if (file != "index") { // Mark properly branch
            for (var i = 0; i < hrefs.length; i++) {
                temp = $(hrefs[i]).attr("href");

                temp = temp.split("/");
                temp = $(temp).last();
                temp = temp[0];
                temp = temp.split(".");
                temp = temp[0];

                n = temp.indexOf(file);
                if (n > -1) {
                    $(hrefs[i]).addClass("clicked");
                    $(hrefs[i]).addClass("first");
                }
            }
        } else {
            $("#tree_" + category).children("a").addClass("clicked");
            $("#tree_" + category).children("a").addClass("first");
        }
    } else if (file !== undefined) {
        redirectUrl = "content/" + file + ".html";

        var obj = {
            "href": redirectUrl
        }

        doAjax(obj, target, clickedStatus);

        $("#tree_" + file).children("a").addClass("clicked");
        $("#tree_" + file).children("a").addClass("first");
    }
};

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
        vars[key] = value;
    });
    return vars;
}


/* ================================================================== */


/**
 * Show up message about invalid request execution.
 */
function showActionError() {

    $('#popup-error')
        .fadeTo(600, 0.8)
        .click(hideActionError);

    window.clearTimeout(loaderTimeOut);
    loaderTimeOut = setTimeout("hideActionError()", 7500);

}


/**
 * Hide message about invalid request execution.
 */
function hideActionError() {

    window.clearTimeout(loaderTimeOut);
    $('#popup-error').stop().fadeTo(300, 0.0);

}