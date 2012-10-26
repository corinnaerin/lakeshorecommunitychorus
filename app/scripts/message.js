var contactForm = {
    init: function(config) {
    	this.config = config;
        this.config.form.on('submit', this.submit);
        this.config.msg.hide();
    },
    
    submit: function(e) {
    	var form = contactForm.config.form;
    	e.preventDefault();
    	contactForm.config.msg.slideUp();
    	
        //If supported, the browser will enforce our "required attributes", so this code will never execute
        if (!Modernizr.input.required) {
            jQuery('input[required]', form).each(function() {
                jQuery(this).removeAttr('required').addClass("required " + this.getAttribute('type'));
            });
            form.validate();
        }
        
        jQuery.post('contact.php', form.serialize(), function(response) {
        	contactForm.config.msg.html(response).slideDown();
        });
    }
}

contactForm.init({
	form: jQuery('#contactform'),
	msg: jQuery('#contactFormMessage')
});