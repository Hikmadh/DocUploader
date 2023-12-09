// File: Hikmadh/DocUploader/view/adminhtml/web/js/admin-popup.js

require(['jquery', 'jquery/ui'], function($) {
    function openPopup(event) {
        event.preventDefault();

        var url = $(event.target).attr('href');

        // Create the dialog
        $('<div>').dialog({
            modal: true,
            resizable: false,
            width: '80%',
            height: 'auto',
            title: 'Popup Title',
            open: function() {
                // Load the URL content into the dialog
                $(this).load(url);
            },
            buttons: {
                Close: function() {
                    $(this).dialog('close');
                }
            }
        });
    }

    // Attach the click event to the "View" link
    $(document).on('click', 'a.view-popup', openPopup);
});
