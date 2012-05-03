function cleanUserData() {
    var resultsTable = jQuery("table.resultsTable");
    if (logoutButton.getCookie('lcc-admin')) {
        jQuery('a.modifyUser', resultsTable).on('click', manageUser.loadUser);
    } else {
        jQuery('a.modifyUser', resultsTable).remove();
        jQuery('a.removeUser', resultsTable).remove();
    }
    jQuery('a.email[id=""]', resultsTable).remove();
}

tableData.init({
    reload: jQuery('.reload'),
    template: jQuery('#user-tmpl').html(),
    container: jQuery('#roster'),
    form: jQuery('#user-form'),
    ajaxURL: '/roster.php',
    colspan: 8,
    callback: cleanUserData
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

Handlebars.registerHelper('phoneNbr', function(value) {
    if (value) {
        return value.substr(0,3) + "-" + value.substr(3,3) + "-" + value.substr(6,4);
    }
    return "";
});

manageUser = {
    init: function(config) {
        this.config = config;
        this.config.addLink.on('click', this.loadUser);
        this.config.modifyLinks.on('click', this.loadUser);
        this.config.template = Handlebars.compile(this.config.template);
    },
    
    loadUser: function() {
        var self = manageUser;
        self.config.userID = jQuery(this).data('user-id')*1;
        if (self.config.userID > 0) {
            jQuery.post('/roster.php', {get_user_id : self.config.userID}, self.showModalWin);
        } else {
            manageUser.showModalWin("");
        }
    },
    
    showModalWin: function(response) {
        var self = manageUser;
        try {
            data = jQuery.parseJSON(response);
            var template = modalWin.show(self.config.template(data ? data[0] : {}));
            
            jQuery('#saveUser', template).on('click', self.saveUser);
            self.config.form = jQuery('#manageUser', template).on('submit', self.saveUser);
            self.config.resultsMsgDiv = jQuery('#results_message', template);
            
            if (self.config.userID === 0) {
                jQuery('input[name$=password]').remove();
                jQuery('div.password').remove();
                jQuery('#user_id').val("0");
            }
        } catch (err) {
            console.log(response);
        }
        
    },
    
    saveUser: function(e) {
        var self = manageUser;
        e.preventDefault();
        self.config.resultsMsgDiv.text('');
        jQuery.post('/roster.php', self.config.form.serialize(), function(response) {
            if (!response || response === "0") {
                jQuery('input[type!=submit], select', self.config.form).val("");
                self.config.resultsMsgDiv.text('Save successful');
                self.config.updateResults.change();
            } else {
                response = jQuery.parseJSON(response);
                if (response[0] === "1") {
                   //Mismatching passwords
                    self.config.resultsMsgDiv.text(response[1]);
                } else if (response[0] === "23000") {
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