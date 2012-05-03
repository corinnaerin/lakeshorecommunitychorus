var tableData = {
    init: function(config) {
        this.config = config;
        this.config.template = Handlebars.compile(this.config.template);
        this.config.reload.on('change', this.fetchData);
        this.fetchData();
    },

    fetchData: function() {
        var self = tableData;
        jQuery.post(self.config.ajaxURL, self.config.form.serialize(), function(results) {
            self.config.container.empty();
            try {
                results = jQuery.parseJSON(results);
                if (results[0]) {
                    self.config.container.append(self.config.template(results));
                    self.config.callback();
                } else {
                    self.config.container.append('<tr><td colspan="' + self.config.colspan + '">No results found.</td></tr>');
                }
            } catch (err) {
                console.log(results);
            }
        });
    }
}
