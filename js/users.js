function cleanUserData() {
    var resultsTable = jQuery("table.resultsTable");
    if (logoutButton.getCookie('lcc-admin')) {
        jQuery('a.modifyUser', resultsTable).on('click', manageUser.loadUser);
        jQuery('a.removeUser', resultsTable).on('click', manageUser.removeUser);
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

