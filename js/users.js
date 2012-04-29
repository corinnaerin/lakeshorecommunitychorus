tableData.init({
    reload: jQuery('.reload'),
    template: jQuery('#user-tmpl').html(),
    container: jQuery('#roster'),
    form: jQuery('#user-form'),
    ajaxURL: '/roster.php',
    colspan: 8
});

Handlebars.registerHelper( 'date', function(dateStr) {
    var date = new Date(dateStr.substr(5));
    return (date.getMonth()+ 1) + "/" + date.getDate() ;
});