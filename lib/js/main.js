jQuery(document).ready(function(){
 
    /* Backtop
     ---------------------------------------------------------------*/
    jQuery("#back-top").hide();
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 100) {
            jQuery('#back-top').fadeIn(100);
        } else {
            jQuery('#back-top').fadeOut(100);
        }
    });
    jQuery('#back-top a').click(function () {
        jQuery('body,html').animate( { scrollTop: 0 }, 800 );
        return false;
    });

    /* Owl Carousel
     ---------------------------------------------------------------*/
    if ( jQuery().owlCarousel ) {
        var owl = jQuery(".owl-carousel");
        owl.each(function(){
            var items    = jQuery(this).data('item'),
                margin   = jQuery(this).data('margin'),
                items_md = jQuery(this).data('md'),
                items_sm = jQuery(this).data('sm'),
                items_xs = jQuery(this).data('xs'),
                dots     = jQuery(this).data('dots'),
                nav      = jQuery(this).data('nav');
            jQuery(this).owlCarousel({
                items: items,
                margin: margin,
                loop: true,
                autoplay: true,
                autoplaySpeed: 2000,
                // autoplayHoverPause: false,
                nav: nav,
                navText: [
                    '<div><i class="fa fa-angle-left"></i></div>',
                    '<div><i class="fa fa-angle-right"></i></div>'
                ],
                dots: dots,
                lazyLoad: true,
                lazyContent: true,
                responsive: {
                    320: {
                        items: items_xs
                    },
                    480: {
                        items: items_xs
                    },
                    768: {
                        items: items_sm
                    },
                    992: {
                        items: items_md
                    },
                    1200: {
                        items: items
                    }
                },
            });
        });
    }

    /* Mobile Menu
     ---------------------------------------------------------------*/
    jQuery('#showmenu').click(function(){
        jQuery('#mobilenav').toggleClass('opened');
        jQuery('.panel-overlay').toggleClass('active');
        jQuery('.hamburger',this).toggleClass('is-active');
    });

    jQuery('.panel-overlay').click(function(){
        jQuery('#mobilenav').toggleClass('opened');
        jQuery(this).removeClass('active');
        jQuery('#showmenu .hamburger').removeClass('is-active');
    });

    jQuery("#mobilenav ul.sub-menu").before('<span class="arrow"></span>');

    jQuery("body").on('click','#mobilenav .arrow', function(){
        jQuery(this).parent('li').toggleClass('open');
        jQuery(this).parent('li').find('ul.sub-menu').slideToggle( "normal" );
    });

});