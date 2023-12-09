define([
    'Magento_Ui/js/grid/columns/column'
], function (Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'ui/grid/cells/link',
            linkText: 'View',
            target: '_blank'
        },

        /**
         * Open the file when the link is clicked.
         *
         * @param {Object} row - Data row for the current record.
         * @param {Object} cell - Data cell for the current column.
         * @param {Object} event - Click event object.
         */
        handleClick: function (row, cell, event) {
            var filePath = row.Docription;
            var url = '/media/uploads/' + filePath;

            window.open(url, this.target);
        }
    });
});
