var modalWin = {
    init: function(config) {
        this.config = config;
        this.config.divs = {};
    },

    show: function(html) {
        if (!this.config.divs.win) {
            this.config.divs.win = jQuery('<div></div>').addClass("modal").css({
                left: ((window.innerWidth - this.config.width) / 2) - 10,
            }).appendTo('body');
        }
        this.config.divs.win.html(html).fadeIn(300);
        
        if (!this.config.divs.bkgd) {
            this.config.divs.bkgd = jQuery('<div></div>').addClass("modal_bkgd")
                .appendTo('body').on('click', this.hide);
        }
        this.config.divs.bkgd.fadeIn(300);
        jQuery('div#user-close').clone().prependTo('div.modal_header').show().on('click', this.hide);
        
        return this.config.divs.win;
    },
    
    hide: function() {
        jQuery.each(modalWin.config.divs, function() {
            this.fadeOut(300, this.remove);
        });
    }
}