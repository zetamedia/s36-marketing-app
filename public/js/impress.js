/*!
 * Impress Support Library
 *
 * @author digital-telepathy
 * 
 * Copyright (C) 2013 digital-telepathy  (http://www.dtelepathy.com/)
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

// ----------------------------------------------------------
// A short snippet for detecting versions of IE in JavaScript
// without resorting to user-agent sniffing
// ----------------------------------------------------------
// If you're not in IE (or IE version is less than 5) then:
//     ie === undefined
// If you're in IE (>=5) then you can determine which version:
//     ie === 7; // IE7
// Thus, to detect IE:
//     if (ie) {}
// And to detect the version:
//     ie === 6 // IE6
//     ie > 7 // IE8, IE9 ...
//     ie < 9 // Anything less than IE9
// ----------------------------------------------------------

// UPDATE: Now using Live NodeList idea from @jdalton

var ie = (function(){
    var undef,
        v = 3,
        div = document.createElement('div'),
        all = div.getElementsByTagName('i');
    while (
        div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->',
        all[0]
    );
    return v > 4 ? v : undef;
}());


/*
 * jQuery throttle / debounce - v1.1 - 3/7/2010
 * http://benalman.com/projects/jquery-throttle-debounce-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function(b,c){var $=b.jQuery||b.Cowboy||(b.Cowboy={}),a;$.throttle=a=function(e,f,j,i){var h,d=0;if(typeof f!=="boolean"){i=j;j=f;f=c}function g(){var o=this,m=+new Date()-d,n=arguments;function l(){d=+new Date();j.apply(o,n)}function k(){h=c}if(i&&!h){l()}h&&clearTimeout(h);if(i===c&&m>e){l()}else{if(f!==true){h=setTimeout(i?k:l,i===c?e-m:e)}}}if($.guid){g.guid=j.guid=j.guid||$.guid++}return g};$.debounce=function(d,e,f){return f===c?a(d,e,false):a(d,f,e!==false)}})(this);

/*!
 * Impress Core Support Utilities
 * 
 * Copyright 2012 digital-telepathy
 */
var Impress = {
    // Computed prefixes
    computedPrefixes: ['Moz', 'ms', 'O', 'Webkit', 'Khtml'],
    
    // Cached elements
    elements: {},

    namespace: "impress",
    
    // Browser prefixes
    prefixes: ['moz', 'ms', 'o', 'webkit'],
    
    // Browser support
    support: {}
};

( function( $, window, undefined ) {
    // Set some basic elements
    Impress.elements.window = $(window);
    Impress.elements.body = $('body');
    Impress.elements.html = $('html');

    // Check to see if the current browser supports CSS transitions
    Impress.supports = function( support ) {
        var $html = this.elements.html = this.elements.html || $('html');
        var supported = false;

        if( !this.support[support] ) {
            switch(support) {
                case "cssanimations":
                    var s = this.elements.body[0].style;
                    var p = 'transition';
                    if(typeof s[p] == 'string') { supported = true; }

                    // Tests for vendor specific prop
                    p = p.charAt(0).toUpperCase() + p.substr(1);
                    for(var i=0; i<this.computedPrefixes.length; i++) {
                        if(typeof s[this.computedPrefixes[i] + p] == 'string') { supported = true; }
                    }
                break;
            }

            this.support[support] = supported;
        }

        return this.support[support];
    };
    
    /**
     * Get jQuery extended elements
     * 
     * Iterates through an Object of selectors and retrieves the jQuery
     * extended objects of those selectors. Returns an Object of those
     * jQuery extended objects for caching.
     * 
     * @param {Object} selectors Object of selectors to retrieve and cache
     * @param {mixed} context jQuery extended Object, selector or DOM element to use as a context
     * @param {Boolean} cached Use Impress global cache or always query new 
     * 
     * @return {Object} Object of jQuery extended elements
     */
    Impress.getElements = function( selectors, context, cached ) {
        var cached = ( cached || false );
        var elements = {};
        var self = this;
        var $context = $( context || 'html' );
        
        $.each( selectors, function( key, value ) {
            if( $.inArray( key, [window, 'body', 'html'] ) != -1 ) elements[key] = self.elements[key];

            if( $.isPlainObject( value ) ) {
                elements[key] = elements[key] || {};
                $.each( value, function( key2, value2 ) {
                    elements[key][key2] = ( cached && self.elements[value2] ) ? self.elements[value2] : self.elements[value2] = $( value2, $context );
                } );
            } else {
                elements[key] = ( cached && self.elements[value] ) ? self.elements[value] : self.elements[value] = $( value, $context );
            }
        } );
        
        return elements;
    };
    
    /**
     * Get an element's CSS transition properties
     * 
     * Uses getComputedStyle() commands to read an element's transition properties
     * and returns an object with applied values.
     * 
     * @param {Object} el DOM element, selector or jQuery Object
     * 
     * @return {Object}  
     */
    Impress.getTransition = function( el, includePrefixes ) {
        if( !window.getComputedStyle ) return {};

        var $el = $( el );
        var includePrefixes = includePrefixes || false;
        var computed = window.getComputedStyle( $el[0] );
        var properties = {
            transitionProperty: 'transition-property', 
            transitionDuration: 'transition-duration', 
            transitionDelay: 'transition-delay', 
            transitionTimingFunction: 'transition-timing-function'
        };
        
        var css = {};
        for( property in properties ) {
            css[properties[property]] = computed[property] || "";
            
            if( includePrefixes ) {
                for( var p in this.computedPrefixes ) {
                    if( this.prefixes[p] ) {
                        var prefixKey = this.computedPrefixes[p] + property.charAt(0).toUpperCase() + property.substr(1);
                        css["-" + this.prefixes[p] + "-" + properties[property]] = computed[prefixKey];
                    }
                }
            }
        }
        
        return css;
    };

    /**
     * Build an object of browser prefixed CSS3 properties
     * 
     * Pass in the un-prefixed CSS3 property to apply (e.x. transition) and the
     * value to set to build an object of CSS properties that can be applied with
     * the jQuery .css() command.
     * 
     * @param {Object} properties Un-prefixed CSS3 property to set
     * @param {Boolean} prefixValue Set to boolean(true) to prefix the value as well
     * 
     * @return {Object} Object of prefixed CSS properties to be applied with $.css()
     */
    Impress.prefixCSS = function( properties, prefixValue ) {
        var prefixValue = prefixValue || false;

        if( ie && ie < 9 ) return properties;
        
        for( var property in properties ) {
            var value = properties[property];
            
            for( var p in this.prefixes ) {
                valuePrefix = prefixValue ? '-' + this.prefixes[p] + '-' : "";
                properties['-' + this.prefixes[p] + '-' + property] = valuePrefix + value;
            }
        }
        
        return properties;
    };
    
    /**
     * Smooth Scroll utility function
     * 
     * @param mixed $el Element to scroll to. Can be either a selector or DOM element.
     * @param speed integer Optional speed in milliseconds to scroll at (defaults to 500)
     * @param offset integer Optional offset for scroll
     * @param delay integer Optional delay in milliseconds for the scrollTo effect (useful when coupling with other actions, defaults to 0)
     */
    Impress.scrollTo = function( $el, speed, offset, delay ){
        // Set a speed if it isn't specified
        speed = speed || 500;
        // Set a delay if it isn't specified (default is 0)
        delay = delay || 0;

        // Numeric positioning
        var top = $el;

        // Handle DOM element calculated offsets
        if( isNaN($el) ) {
            top = $($el).offset().top;
        }

        top = top + ( parseInt( offset, 10 ) || 0 );
            
        $( 'html, body' ).delay( delay ).animate( {
            scrollTop: top
        }, {
            duration: speed,
            easing: "swing",
            complete: function() {
                // Enforce window scroll
                window.scrollTo( 0, top );
            }
        });
    };

} )( jQuery, window, null );
