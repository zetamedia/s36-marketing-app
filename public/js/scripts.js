(function($, window, undefined, I){
    var FDBack = {
        elements: {},
        selectors: {
            body: 'body',
            benefitStars: '#benefit-stars',
            benefitMoney: '#benefit-money',
            benefitBars: '#benefit-bars',
            benefitBubbles: '#benefit-bubbles',
            contactForm: '#contact-form',
            lazyloadImages: 'img[data-original]',
            signupForm: '#signup-form',
            signupModalLinks: 'a[data-toggle="modal"]',
            sliders: '.css-slider',
            smoothscrollLinks: 'a.smooth-scroll'
        },
        _bindVendors: function() {
            var self = this;
            this.elements.signupForm.validator();
            this.elements.contactForm.validator();

            // CSS Sliders
            this.elements.sliders.cssSlider();

            // Add image lazyload
            this.elements.lazyloadImages.lazyload({
                threshold: 200,
                effect: "fadeIn",
                event: "scroll transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"
            });
        },

        _bindEvents: function() {
            var self = this;

            this.elements.body.on( 'click', this.selectors.smoothscrollLinks, function(event){
                event.preventDefault();
                var $el = $( $(this).attr('href') );
                var speed = 1000;
                var offset = 0;
                Impress.scrollTo( $el, speed, offset );
            });

            this.elements.signupModalLinks.on('click', function() {
                if( $(this).data('plan') != undefined ){
                    $('#signup-plan-type').val( $(this).data('plan') );
                }else{
                    $('#signup-plan-type').val('');
                }
            });
            this.elements.contactForm.on('submit', function(event) {
                event.preventDefault();
                if($(this).data('FormValidator').validate()) {
                    $.ajax({
                        async: false,
                        type: 'post',
                        data: $('#contact-form').serialize(),
                        url: '/contact',
                        success: function(result){
                            $('#contact-name').val('');
                            $('#contact-email').val('');
                            $('#contact-comment').val('');
                        }

                    });
                }
            })
            /*
            this.elements.signupForm.on('submit', function(event) {
                event.preventDefault();
                if($(this).data('FormValidator').validate()) {
                    return false;
                }
            })
            .on('keyup', '#signup-email-confirm', function(event){
                self.fieldConfirmation(document.getElementById('signup-email'), this);
            })
            .on('keyup', '#signup-email', function(event){
                self.elements.signupForm.data('FormValidator').options.required['email-confirmation'].algorithm = this.value;
            })
            .on('keyup', '#signup-password-confirm', function(event){
                self.fieldConfirmation(document.getElementById('signup-password'), this);
            })
            .on('keyup', '#signup-password', function(event){
                self.elements.signupForm.data('FormValidator').options.required['password-confirmation'].algorithm = this.value;
            });
            */
            this.elements.window.yAxis('attach', function(){
                var padding = 0;
                var offset = self.elements.benefitStars.offset().top - self.elements.window.height()/2;
                return offset - padding;
            }, function(){
                self.elements.benefitStars.addClass('visible');
            });

            this.elements.window.yAxis('attach', function(){
                var padding = 0;
                var offset = self.elements.benefitMoney.offset().top - self.elements.window.height()/2;
                return offset - padding;
            }, function(){
                self.elements.benefitMoney.addClass('visible');
            });

            this.elements.window.yAxis('attach', function(){
                var padding = 0;
                var offset = self.elements.benefitBars.offset().top - self.elements.window.height()/2;
                return offset - padding;
            }, function(){
                self.elements.benefitBars.addClass('visible');
            });

            this.elements.window.yAxis('attach', function(){
                var padding = 0;
                var offset = self.elements.benefitBubbles.offset().top - self.elements.window.height()/2;
                return offset - padding;
            }, function(){
                self.elements.benefitBubbles.addClass('visible');
            });
        },

        _getElements: function() {
            for( var key in this.selectors ) {
                this.elements[key] = $( this.selectors[key] );
            }
            this.elements.window = $(window);
        },

        fieldConfirmation: function(f1, f2) {
            var self = this;
            if (f1.value != f2.value || f1.value == '' || f2.value == '') {
                f2.setCustomValidity( $(f2).data('message') );
            } else {
                f2.setCustomValidity('');
                this.elements.signupForm.data('FormValidator').validateField(f2.name, true);
            }
        },

        initialize: function(){
            var self = this;
            this._getElements();
            this._bindVendors();
            this._bindEvents();
        }
    };

    // Send to global namespace
    window.FDBack = FDBack;

    // DOM Ready
    $(function(){
        FDBack.initialize();
    });

})(jQuery, window, null, Impress);
