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
         * Retrieve the URL for the file based on the row data.
         *
         * @param {Object} row - Data row for the current record.
         * @returns {String} - URL of the file.
         */
        getFileUrl: function (row) {
            var filePath = row.Docription;
            var baseUrl = '/media/uploads/';

            return baseUrl + filePath;
        }
    });
});
