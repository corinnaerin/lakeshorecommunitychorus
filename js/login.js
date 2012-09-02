var loginForm = {
    config: {
        speed: 300,
        effect: 'slideToggle'
    },

    init: function(config) {
        jQuery.extend(this.config, config);
        
        if (Modernizr.rgba) { //If supported, make the background transparent
            this.config.$form.css('background', 'rgba(86, 86, 86, 0.7)');
        }
        
        this.config.$form.on('submit', this.submit).hide();
        this.config.$openButton.on('click', this.toggle);
        this.config.$closeButton.on('click', this.toggle);
    },
    
    toggle: function() {
        var config = loginForm.config,
            $form = loginForm.config.$form;
        $form[config.effect](config.speed); //Execute the effect
        loginForm.config.$openButton.fadeToggle(config.speed);
        loginForm.config.$closeButton.fadeToggle(config.speed);
        loginForm.config.$errorDiv.fadeOut(config.speed);
    },
    
    submit: function(e) {
        var $form = jQuery(this);
        e.preventDefault();
        
        //If supported, the browser will enforce our "required attributes", so this code will never execute
        if (!Modernizr.input.required) {
            jQuery('input[required]', $form).each(function() {
                jQuery(this).removeAttr('required').addClass("required " + this.getAttribute('type'));
            });
            $form.validate();
        }
        
        jQuery.post('/recordings.php', $form.serialize(), function(response) {
            if (response.length < 2) {
                window.location.href = '/calendar.php';
            } else {
                loginForm.config.$errorDiv.html(response).slideDown(300);
            }
        });
    }
}

loginForm.init({
    $form: jQuery('#login-win'),
    $openButton: jQuery('#login-open'),
    $closeButton: jQuery('#login-close'),
    $errorDiv: jQuery("#login-error")
});