define([
    'ko',
    'uiComponent',
    'underscore',
    'Magento_Checkout/js/model/step-navigator',
    'Magento_Customer/js/model/customer',
    'mage/url',
    'jquery'
], function (
    ko,
    Component,
    _,
    stepNavigator,
    customer,
    url,
    $
) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Hikmadh_DocUploader/check-login'
        },

        isVisible: ko.observable(true),
        isLogedIn: customer.isLoggedIn(),
        stepCode: 'isLogedCheck',
        stepTitle: 'Upload Document',

        initialize: function () {
            this._super();
            stepNavigator.registerStep(
                this.stepCode,
                null,
                this.stepTitle,
                this.isVisible,
                _.bind(this.navigate, this),
                15
            );

            return this;
        },

        navigate: function () {
            // Reset the file input value when navigating to the step
            var fileInput = document.getElementById('Document');
            if (fileInput) {
                fileInput.value = '';
            }
        },

        navigateToNextStep: function () {
            var formKey = window.checkoutConfig.formKey;
            var uploadUrl = url.build('hikmadh_DocUploader/index/submit');

            // Check if a file is uploaded
            var fileInput = document.getElementById('Document');
            if (!fileInput || fileInput.files.length === 0) {
                // No file selected, display an error message
                alert('Please select a file to upload.');
                return;
            }

            // Validate the file type
            var file = fileInput.files[0];
            if (file.type !== 'application/pdf' && !file.name.endsWith('.txt')) {
                alert('Only text-based PDF or text files are allowed.');
                return;
            }

            // Prepare form data
            var formData = new FormData();
            formData.append('form_key', formKey);
            formData.append('Document', file);

            // Perform AJAX request
            $.ajax({
                url: uploadUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    // Show loading indicator or disable the button if needed
                },
                success: function (response) {
                    // Handle success response
                    // You can display a success message and move to the next step
                    stepNavigator.next();
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    // You can display an error message and handle the error accordingly
                },
                complete: function () {
                    // Clean up or hide the loading indicator if needed
                }
            });
        }
    });
});
