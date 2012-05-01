var modalWin = {
    init: function(config) {
        this.config = config;
    },

    show: function(html) {
        this.config.divs = jQuery([]);
        var win = jQuery('<div></div>').addClass("modal").html(html).css({
            left: ((window.innerWidth - this.config.width) / 2) - 10,
        }).appendTo('body').fadeIn(300);
        this.config.divs.push(win);
        
        this.config.divs.push(jQuery('<div></div>').addClass("modal_bkgd")
            .appendTo('body').fadeIn(300).on('click', this.hide));
        
        jQuery('div.modal_header', win).prepend(
            jQuery('<div><div>').text('X').attr('id', 'user-close').on('click', this.hide)
        );
        
        return win;
    },
    
    hide: function() {
        modalWin.config.divs.each(function() {
            this.fadeOut(300, this.remove);
        });
    }
}