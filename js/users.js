tableData.init({
    reload: jQuery('.reload'),
    template: jQuery('#user-tmpl').html(),
    container: jQuery('#roster'),
    form: jQuery('#user-form'),
    ajaxURL: '/roster.php',
    colspan: 8
});

Handlebars.registerHelper('date', function(dateStr) {
    if (dateStr) {
        var date = new Date(dateStr.substr(5));
        if (date.getDate() > 0){
            return (date.getMonth()+ 1) + "/" + date.getDate();
        }
    } 
    return "";
});

Handlebars.registerHelper('selected', function(value, option) {
    if (value && option && value === option) {
        return "selected"
    }
    return "";
});

Handlebars.registerHelper('integer', function(value) {
    if (value === "0") {
        return "";
    }
    return value;
});

manageUser = {
    init: function(config) {
        this.config = config;
        this.config.addLink.on('click', this.showModalWin);
        this.config.template = Handlebars.compile(this.config.template);
    },
    
    showModalWin: function() {
        var self = manageUser;
        var userID = jQuery(this).data('user-id')*1;
//        jQuery.post('/roster.php', jQuery(this).data('user-id'), function(response) {
            var template = modalWin.show(self.config.template({}));
            
            jQuery('#saveUser', template).on('click', self.saveUser);
            self.config.form = jQuery('#manageUser', template).on('submit', self.saveUser);
            self.config.resultsMsgDiv = jQuery('#results_message', template);
            
            if (userID === 0) {
                jQuery('input[name$=password]').remove();
                jQuery('div.password').remove();
                jQuery('#user_id').val("0");
            }
//        });
    },
    
    saveUser: function(e) {
        var self = manageUser;
        e.preventDefault();
        jQuery.post('/roster.php', self.config.form.serialize(), function(response) {
            if (!response) {
                jQuery('input[type!=submit], select', self.config.form).val("");
                self.config.resultsMsgDiv.text('Save successful');
                self.config.updateResults.change();
            } else {
                response = jQuery.parseJSON(response);
                if (response[0] === "23000") {
                    //Duplicate username
                    self.config.resultsMsgDiv.text('Duplicate username');
                } else {
                    self.config.resultsMsgDiv.text('Unexpected error: ' + response[2]);
                }
            }
        });
    }
};

manageUser.init({
    template: jQuery('#manage-user-tmpl').html(),
    addLink: jQuery('#addUser'),
    modifyLinks: jQuery('.modifyUser'),
    updateResults: jQuery('.reload')
});

modalWin.init({
    width: 800
});