    // clear the error on input focus.
    $('input, select').focus(function(){
        
        if( $(this).is('.err-text') ){
            $(this).val('');
            $(this).removeClass('err-text');
        }
        
        if( $(this).is('input[type=password]') || $(this).is('select') ){
            $('span[name=' + $(this).attr('name') + ']').text('');
        }

        $('.reg-site-input').focus(function(){
            $("#site-name-error").hide();
        });

    });


    // validate form when submitted.
    $('#registration_form').submit(function(e){
        var registration_form = $(this);
        var registration_type = $("input[name='regtype']").val();
        // elements with their names in span array will have their errors displayed somewhere else. not in them.
        var span    = ['password', 'password_confirmation', 'billing_state', 'billing_country', 'expiration_month', 'expiration_year', 'site_name'];
        var errors  = '';
        var data    = {};


        // reset the err-text and error spans.
        $('span.err-text').text('');
        $('.err-text').val('');
        $('.err-text').removeClass('err-text');

        // do an ajax validation.
        $.ajax({
            async: false,
            type: 'post',
            data: registration_form.serialize(),
            url: '/registration/ajax_validation/'+registration_type,
            success: function(error_msg){
                
                // display errors if there are.
                if( error_msg != '' ){
                    
                    errors      = error_msg;
                    error_msg   = $.parseJSON(error_msg);
                    
                    // loop through error_msg to display each.
                    $.each(error_msg, function(name, msg){
                        
                        // if name is not in span array, display the error in the item.
                        if( span.indexOf(name) == -1 ){
                            
                            $('input[name=' + name + ']').val( msg );
                            $('input[name=' + name + ']').addClass('err-text');
                           
                        // if name is in span array, display the error in item's span.
                        }else{
                            
                            $('span[name=' + name + ']').text( msg );
                            $('span[name=' + name + ']').addClass('err-text');

                        }

                    });
                    
                }

            }

        });


        // if there are any errors in the form, don't submit it.
        if( errors != '' ){
            $('input[type=password]').val('');
            $('html, body').animate({
				scrollTop: $('.err-text').first().offset().top
			}, 200);
            return false;
        }else{
            return true;
        }
    });