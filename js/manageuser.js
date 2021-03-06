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

Handlebars.registerHelper('fullName', function(object) {
    return object.first_name + " " + object.last_name;
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
            jQuery.post('/roster.php', {user_id : self.config.userID, action : 'getUser'}, self.showModalWin);
        } else {
            manageUser.showModalWin("");
        }
    },
    
    removeUser: function() {
        var self = manageUser;
        var link = jQuery(this);
        self.config.userID = link.data('user-id')*1;
        if (self.config.userID > 0 && 
                confirm("Are you sure you want to delete " + link.data('name') + "? This action cannot be undone.")) {
            jQuery.post('/roster.php', {user_id : self.config.userID, action : 'removeUser'}, function(response) {
                if (response && response !== "0") {
                    console.log(response);
                } else {
                    self.config.updateResults.change();
                }
            });
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
            
            if (self.config.userID !== logoutButton.getCookie('lcc-user-id')*1) {
                jQuery('input[name$=password]').remove();
                jQuery('div.password').remove();
                if (self.config.userID === 0) {
                    jQuery('#user_id').val("0");
                }
            }
        } catch (err) {
            console.log(err.message + ": " + response);
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
                try {
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
                } catch (err) {
                    console.log(response);
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