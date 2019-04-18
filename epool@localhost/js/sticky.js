var stack = [];

window.Sticky = function (el, options) {

    var public = {};
    var private = {};

    var defaultOptions = {
        offset: 0,
        stackable: true,
        container: 'body'
    };

    var isPinned = false;
    var ghostTag = null;

    private.init = function () {
        el = $(el);
        options = $.extend({}, defaultOptions, options || {});
        $(document).bind('load resize scroll', private.recalc);

        if (options.stackable) {
            stack.push(public);
        }
    }

    private.recalc = function () {
        var basePos = 0;
        for (var i in stack) {
            var sticky = stack[i];
            if (sticky.isEqual(el)) {
                break;
            }

            if (sticky.isPinned()) {
                basePos += sticky.getOffset() + sticky.getHeight();
            }
        }

        if (private.getPosition() - basePos <= private.getScroll()) {
            private.pin();
        } else {
            private.unpin();
        }
    }

    private.getScroll = function () {
        return $(document).scrollTop();
    }

    private.getPosition = function () {
        if (!isPinned) {
            return el.offset().top;
        }

        return ghostTag.offset().top;
    }

    private.pin = function () {
        if (isPinned) {
            return;
        }

        isPinned = true;

        ghostTag = $('<div>').css({
            width: public.getWidth(),
            height: public.getHeight()
        });

        el.after(ghostTag);
        el.css({
            position: 'fixed',
            top: public.getOffset(),
            width: public.getWidth(),
        });
    }

    private.unpin = function () {
        if (!isPinned) {
            return;
        }

        el.attr('style', null);

        ghostTag.remove();
        ghostTag = null;

        isPinned = false;
    }

    public.getWidth = function () {
        return el.outerWidth();
    }

    public.getHeight = function () {
        return el.outerHeight(true);
    }

    public.isPinned = function () {
        return isPinned;
    }

    public.isEqual = function (other) {
        return $(other).is(el);
    }

    public.destroy = function () {
        private.unpin();
        $(document).unbind('load resize scroll', private.recalc);

        if (options.stackable) {
            stack.splice(stack.indexOf(public), 1);
        }
    }

    public.getOffset = function () {
        if (!options.stackable) {
            return options.offset;
        }

        var offset = options.offset;
        for (var i in stack) {
            var sticky = stack[i];
            if (sticky.isEqual(el)) {
                return offset;
            }

            if (sticky.isPinned()) {
                offset += sticky.getOffset() + sticky.getHeight();
            }
        }

        return offset;
    }

    private.init();
    return public;

};