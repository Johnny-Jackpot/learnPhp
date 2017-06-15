"use strict";

(function(){
    $(document).ready(function() {

        function App(settings) {
            this.path = settings.path || '';
            this.container = settings.container || '';
            this.form = settings.form || '';
            this.submitButton = settings.submitButton || '';
            this.select = settings.select || '';
            this.search = '';
            this.requestUri = '';
        }

        /**
         * Initial load statistics
         */
        App.prototype.run = function() {
            this._init();
            this._setEventHandlers();
        };

        App.prototype._init = function() {
            var search = window.location.search;
            if (undefined === search || '' === search) {
                return;
            }
            this.search = search;
            var url = this.path + this.search;
            this._loadStatistics(url, false);
            this._updateSelectedStudio();
        };

        /**
         *
         */
        App.prototype._updateStatistics = function(url, updateUri) {
            var studio = this._getStudio();
            var url = url ? url : this._getRequestUri(studio);
            this._loadStatistics(url, updateUri);
            this._updateSelectedStudio();
        };

        /**
         * @param updateUri bool
         * @param url string
         * @private
         */
        App.prototype._loadStatistics = function(url, updateUri) {
            $.getJSON(url)
                .done(function(data) {
                    this._onSuccessedRequest(data);
                    if (updateUri) {
                        this._updateUri();
                    }
                }.bind(this))
                .fail(this._onFailedRequest.bind(this));
        };

        /**
         *
         * @param data
         * @private
         */
        App.prototype._onSuccessedRequest = function (data) {
            this._renderData(data);
        };

        /**
         *
         * @param jqxhr
         * @param textStatus
         * @param error
         * @private
         */
        App.prototype._onFailedRequest = function (jqxhr, textStatus, error) {
            alert('Cannot load statistics');
        };

        App.prototype._setEventHandlers = function() {
            this._setOnSubmitForm();
            this._setOnClickSubmitButton();
            this._setOnpopstate();
        };

        App.prototype._setOnSubmitForm = function() {
            $(this.form).submit(function(event) {
                event.preventDefault();
            });
        };

        App.prototype._setOnClickSubmitButton = function() {
            $(this.submitButton)
                .click(function(event) {
                    event.preventDefault();
                })
                .click(this._updateStatistics.bind(this, null, true));
        };

        App.prototype._setOnpopstate = function() {
            $(window).bind('popstate', function(event) {
                var url = this.path + event.originalEvent.state.search;
                this._updateStatistics(url, false);
            }.bind(this));
        };

        /**
         * @param studio string
         * @returns string
         * @private
         */
        App.prototype._getRequestUri = function(studio) {
            this.search = '?' + studio;
            this.requestUri = this.path + this.search;

            return this.requestUri;
        };

        /**
         *
         * @param data object
         * @privateCreating a new element with an attribute object.
         */
        App.prototype._renderData = function(data) {
            var statistics = data.actorsOnStudiosInfo;
            var rows = '<tr><th>Studio</th><th>Actor</th><th>Films</th></tr>';

            $(statistics).each(function(index, element) {
                var row = "<tr><td>:studio</td><td>:actor</td><td>:films</td></tr>";
                row = row.replace(':studio', element.studio);
                row = row.replace(':actor', element.actor_full_name);
                row = row.replace(':films', element.number_of_films);
                rows += row;
            });

            $(this.container).html($('<table/>', {
                html: rows
            }));
        };

        /**
         * Update url
         * @private
         */
        App.prototype._updateUri = function() {
            var url = window.location.pathname + this.search;
            history.pushState(this, url, url);
        };

        /**
         *
         * @returns {string}
         * @private
         */
        App.prototype._getStudio = function() {
            return $(this.form).serialize();
        };

        App.prototype._updateSelectedStudio = function() {
            var paramToSearch = 'studio_name';

            var studio = this._getQueryVar(paramToSearch);
            console.log(studio);
            var options = $(this.select).children();
            options.each(function(index, element) {
                $(element).removeAttr('selected');
            });
            options.each(function(index, element) {
                if ($(element).val() === studio) {
                    $(element).attr('selected','selected');
                }
            });
        };

        /**
         *
         * @param varName {string}
         * @returns {string}
         * @private
         */
        App.prototype._getQueryVar = function(varName) {
            var queryStr = decodeURI(window.location.search) + '&';
            var regex = new RegExp('.*?[&\\?]' + varName + '=(.*?)&.*');
            var val = queryStr.replace(regex, "$1");

            return queryStr === val ? '' : val;
        };

        /***********************************************/

        var settings = {
            path: 'get_actors_statistics',
            form: '#actorsOnStudios',
            submitButton: '#getStatistics',
            container: '#statistics',
            select: '#actorsOnStudiosSelect'
        };
        var app = new App(settings);
        app.run();



    });
})();