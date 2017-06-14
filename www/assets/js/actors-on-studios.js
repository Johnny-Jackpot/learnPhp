"use strict";

(function(){
    $(document).ready(function() {

        $('#actorsOnStudios').submit(function(event) {
            event.preventDefault();
        });

        $('#getStatistics').click(function(event) {
            event.preventDefault();
            var settings = {
                path: 'get_actors_statistics',
                container: '#statistics'
            };
            var app = new App(settings);
            app.run();
        });

        /**
         * Make AJAX and render statistics
         *
         * @param settings object
         *        settings.path string Request path
         *        settings.container string Selector of element where place statistics
         * @constructor
         */
        function App(settings) {
            this.path = settings.path || '';
            this.container = settings.container || '';
            this.requestUri = '';
        }

        /**
         *
         */
        App.prototype.run = function() {
            var url = this._getRequestUri();
            $.getJSON(url)
                .done(this._onSuccessedRequest.bind(this))
                .fail(this._onFailedRequest.bind(this));
        };

        /**
         *
         * @param data
         * @private
         */
        App.prototype._onSuccessedRequest = function (data) {
            this._renderData(data);
            // TODO this._updateUri();
        };

        /**
         *
         * @param jqxhr
         * @param textStatus
         * @param error
         * @private
         */
        App.prototype._onFailedRequest = function (jqxhr, textStatus, error) {
            console.dir('fail');
            console.dir(this);
        };

        /**
         *
         * @returns string
         * @private
         */
        App.prototype._getRequestUri = function() {
            this.requestUri = this.path + window.location.search;

            return this.requestUri;
        };

        /**
         *
         * @param data object
         * @privateCreating a new element with an attribute object.
         */
        App.prototype._renderData = function(data) {
            var statistics = data.actorsOnStudiosInfo;
            console.dir(statistics);

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

            //console.dir($(this.container));
        };

        App.prototype._updateUri = function() {
            // TODO
        };



    });
})();