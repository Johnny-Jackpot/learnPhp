"use strict";

(function(){
    $(document).ready(function() {

        /**
         *
         * @param settings                object
         *        settings.path           string    Pathname for AJAX requests
         *        settings.tableContainer string    ID of div that contain table
         *        settings.table          string    ID of table element where stats placed
         *        settings.form           string    ID of Form element
         *        settings.submitButton   string    ID of submit button for attaching event handlers
         * @constructor
         */
        function App(settings) {
            this.path = settings.path || '';
            this.tableContainer = settings.tableContainer || '';
            this.table = settings.table || '';
            this.form = settings.form || '';
            this.submitButton = settings.submitButton || '';
            this.search = '';
            this.requestUri = '';
        }

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
        };

        /**
         *
         */
        App.prototype._updateStatistics = function(url, updateUri) {
            var studio = this._getStudio();
            var url = url ? url : this._getRequestUri(studio);
            this._loadStatistics(url, updateUri);
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
         * @param data object
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
            $(window).bind('popstate', function() {
                var url = this.path + window.location.search;
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

            if (!statistics.length) {
                this._updateTable('');
                var message = 'No data for this studio. Please check URL.'
                this._renderAlert(this.tableContainer, message);
                return;
            }

            var rows = '<tr><th>Studio</th><th>Actor</th><th>Films</th></tr>';
            rows += this._generateRows(statistics);
            this._updateTable(rows);
        };

        /**
         *
         * @param target string ID of element where prepend alert
         * @param message string Alert message
         * @private
         */
        App.prototype._renderAlert = function(target, message) {
            if ($('#noData')[0]) return;

            $(target).prepend(
                '<div id="alert" class="alert alert-danger" role="alert">'
                + message
                + '</div>');
            setTimeout(function () {
                $('#alert').remove();
            }, 5000);
        };

        App.prototype._generateRows = function(statistics) {
            var rows = '';
            $(statistics).each(function(index, element) {
                var row = "<tr><td>:studio</td><td>:actor</td><td>:films</td></tr>";
                row = row.replace(':studio', element.studio);
                row = row.replace(':actor', element.actor_full_name);
                row = row.replace(':films', element.number_of_films);
                rows += row;
            });

            return rows;
        };

        App.prototype._updateTable = function(rows) {
            $(this.table).html($('<tbody/>', {
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
            tableContainer: '#statistics-container',
            form: '#actors-on-studios',
            submitButton: '#get-statistics',
            table: '#statistics',
            select: '#actors-on-studios-select'
        };
        var app = new App(settings);
        app.run();
    });
})();