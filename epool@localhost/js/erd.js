$(function () {

    var currFocus = null;

    $(document).click(function (e) {
        if ($(e.target).closest('[data-relation]').length === 0) {
            blurRelation(currFocus);
        }
    });

    $(document).on('click', '[data-relation]', function () {
        blurRelation(currFocus);
        focusRelation($(this));
    });

    function getRelationData(tag) {
        return {
            pk: {
                tableId: tag.data('relation-pk-table-id'),
                columnsId: tag.data('relation-pk-column-ids').toString().split(','),
            },
            fk: {
                tableId: tag.data('relation-fk-table-id'),
                columnsId: tag.data('relation-fk-column-ids').toString().split(','),
            },
        }
    }

    function styleRelationLine(tag, callback) {
        callback(tag.siblings());
    }

    function styleKeyColumn(tag, callback) {
        var data = getRelationData(tag);
        $.each(data.pk.columnsId, function (i, columnId) {
            var el = $('[data-table-id="' + data.pk.tableId + '"] [data-column-id="' + columnId + '"] foreignObject div');
            callback(el);
        });

        $.each(data.fk.columnsId, function (i, columnId) {
            var el = $('[data-table-id="' + data.fk.tableId + '"] [data-column-id="' + columnId + '"] foreignObject div');
            callback(el);
        });
    }

    function blurRelation(tag) {
        if (tag === null) {
            return;
        }

        styleRelationLine(tag, function (el) {
            el.attr('stroke', '#757575');
            el.attr('stroke-width', 1);
        });

        styleKeyColumn(tag, function (el) {
            el.css('background', 'white');
        });

        currFocus = null;
    }

    function focusRelation(tag) {
        currFocus = tag;

        styleRelationLine(tag, function (el) {
            el.attr('stroke', '#5382ca');
            el.attr('stroke-width', 1.5);
        });

        styleKeyColumn(tag, function (el) {
            el.css('background', '#d7e5f2');
        });
    }
});