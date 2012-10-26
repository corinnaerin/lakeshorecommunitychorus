(function() {
    Handlebars.registerHelper('titleAndSequence', function(object) {
        if (object.sequence) {
            return object.title + " (" + object.sequence + ")";
        } else {
            return object.title;
        }
    });
    
    var part = logoutButton.getCookie('lcc-vocal-part');
    if (part) {
        jQuery('#user-filter').val(part);
    }

    tableData.init({
        reload: jQuery('.reload'),
        template: jQuery('#recording-tmpl').html(),
        container: jQuery('#recordings'),
        form: jQuery('#recordings-form'),
        ajaxURL: '/recordings.php',
        colspan: 4,
    });
})();