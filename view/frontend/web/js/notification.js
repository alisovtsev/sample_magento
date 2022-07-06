define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'domReady!'
    ],
    function (
        $,
        ko,
        Component
    ) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'LeSite_CustomBar/notification',
            },

            /**
             * Inits
             */
            initialize: function (config) {
                this.config = config;
                this.shouldShowBar = ko.observable(true);
                this._super();
            },

            getText: function()
            {
                return this.config.notification.text;
            },

            getBackgroundColor: function() {
                return this.config.notification.backgroundColor;
            },

            getTextColor: function() {
                return this.config.notification.textColor;
            },

            getFontSize: function() {
                return this.config.notification.fontSize;
            },

            closeBar: function()
            {
                this.shouldShowBar(false);
            }
        });
    }
);
