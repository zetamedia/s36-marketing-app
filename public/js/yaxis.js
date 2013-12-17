/*!
 * Y-Axis Animations jQuery plugin
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
var YAxis = function( el, params ) {
    // Array of animations to run at certain coordinates
    this.animations = [];

    // Direction of scroll
    this.direction = "down";

    // Cached elements
    this.elements = {};

    // Height of the context
    this.height = 0;

    // Is the scrolling context the window itself?
    this.isWindow = true;
    
    // Class namespace
    this.namespace = "yaxis";
    
    this.options = {
        method: "css",
        counter: "." + this.namespace + "-counter"
    };
    
    // Current scrolled position
    this.scrollTop = 0;

    // Selectors for elements used by this Class instance
    this.selectors = {
        body: 'body',
        window: window
    };
    
    this.initialize( el, params );
};
( function( $, window, undefined, I ) {
    /**
     * Bind all events related to this YAxis 
     */
    YAxis.prototype._bindEvents = function() {
        var self = this;

        if( this.isWindow ) {
            this.context.on( 'scroll', function( event ) {
                self.update( event );
            } );
        } else {
            this.context.on( 'mousewheel', function( event, delta, deltaX, deltaY ) {
                self.update( event, delta, deltaX, deltaY );
            } );
        }

        // Update the cache height when resizing the browser window
        this.elements.window.on( 'resize', function() {
            self.height = self.context.outerHeight();
        } );
    };

    /**
     * Build elements and structures related to this YAxis 
     */
    YAxis.prototype._build = function() {
        // Check to see if we are attaching to the window itself
        if( this.context[0] != window ) {
            this.isWindow = false;
        }

        // If the yAxis animation was attached to the window, force allowing of scrolling
        if( this.isWindow ) this.options.preventScroll = false;

        // Cache the height
        this.height = this.context.outerHeight();

        this.elements.counter = $( this.options.counter, this.context );
    };
    
    /**
     * Method for doing actions passed to an instantiated slider
     * 
     * Takes multiple arguments:
     * 
     * @param action string The action to run
     * @param args mixed Optional arguments which may or may not be required by a method
     */
    YAxis.prototype._run = function() {
        var arguments_array = [];
        for( var i = 0; i < arguments.length; i++ ) {
            arguments_array.push( arguments[i] );
        }
        
        var action = arguments_array[0];
        var args = arguments_array.length > 1 ? arguments_array.slice( 1 ) : [];
        
        if( typeof( this[action] ) == 'function' ) {
            return this[action].apply( this, args );
        } else if( typeof( this[action] ) != 'undefined' ) {
            return this[action];
        }
    };

    /**
     * Attach a function to the YAxis animation queue
     * 
     * Pass a vertical offset to run the callback at. Callback can be
     * passed as a single function or an object with an "on" and "off"
     * pair of functions to run when the user scrolls down past ("on") the
     * offset and when a user scrolls back up past ("off") the offset.
     * 
     * @param integer offset Vertical offset to run the callback
     * @param object|function callback A function or pair of functions to run
     */
    YAxis.prototype.attach = function( offset, callback ) {
        if( !callback ) {
            console.error( "A callback is required for YAxis attachments", callback );
            return false;
        }

        var on = function(){};
        var off = false;

        if( typeof( callback ) == 'function' ) {
            on = callback;
        } else {
            on = callback.on;
            if( callback.off ) off = callback.off;
        }

        this.animations.push( {
            offset: offset,
            on: on,
            off: off
        } );
    };
        
    YAxis.prototype.initialize = function( el, options ) {
        // Merge options for this instance with defaults
        this.options = $.extend( this.options, arguments[1][0] || {}, $( el ).data() );
        
        // Fall back to jQuery Animation if the browser doesn't support CSS Transitions
        if( !I.supports( 'cssanimations' ) ) {
            this.options.method = "animate";
        }
        
        // Cache elements used by this instance
        this.elements = I.getElements( this.selectors );
        
        this.context = this.elements.context = $( el );

        // Build elements
        this._build();
        
        // Bind events
        this._bindEvents();
    };

    /**
     * Set or get an option value
     * 
     * Sets the requested instance's option to a particular value. If no value is
     * passed it just returns the current option's value. Always returns the set
     * value of the requested option.
     * 
     * @param string key The option key to get or set
     * @param mixed val Optional value to set the option to
     * 
     * @return mixed
     */
    YAxis.prototype.option = function( key, val ) {
        if( val != undefined )
            this.options[key] = val;
        
        return this.options[key];
    };

    /**
     * Update the current scroll position
     * 
     * @param object event The mousewheel event
     * @param float delta The mousewheel delta of the event
     * @param float delta The mousewheel deltaX of the event
     * @param float delta The mousewheel deltaY of the event
     */
    YAxis.prototype.update = function( event, delta, deltaX, deltaY ) {
        if( this.isWindow ) {
            this.previousPosition = this.scrollTop;
            this.scrollTop = this.elements.window.scrollTop();
            this.direction = this.previousPosition < this.scrollTop ? "down" : "up";
        } else {
            this.scrollTop = this.scrollTop - delta;
            this.direction = delta < 0 ? "down" : "up";
        }
        
        this.scrollTop = Math.round( Math.max( 0, this.scrollTop ) );

        for( var a in this.animations ) {
            var animation = this.animations[a];
            var offset = typeof( animation.offset ) == 'function' ? animation.offset() : animation.offset;

            if( this.scrollTop >= offset && !animation.hasRun ) {
                this.animations[a].hasRun = true;
                animation.on();
            }
            if( this.scrollTop < offset && animation.hasRun && animation.off !== false ) {
                this.animations[a].hasRun = false;
                animation.off();
            }
        }

        this.elements.counter.text( this.scrollTop );
    };
    
    $.extend( $.fn, {
        yAxis: function(){
            var options = action = arguments;
            var _return = this;
            
            this.each( function( ind ) {
                // Look up if an instance already exists
                var _YAxis = $.data( this, 'YAxis' );
                
                // Else create one and store it
                if( !_YAxis ) {
                    _YAxis = new YAxis( this, options );
                    $.data( this, 'YAxis', _YAxis );
                }
                
                // Act upon it
                if( action.length > 0 ) {
                    var _do = _YAxis._run.apply( _YAxis, action );
                    if( typeof( _do ) != 'undefined' ) {
                        _return = _do;
                    }
                }
            } );
            
            return _return;
        }
    });
} )( jQuery, window, null, Impress );
