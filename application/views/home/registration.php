<title>Registration | 36Stories</title>
<!-- start title of page -->
<div id="titlebarwrapper">
	<div id="subtitlebarwrapper">
    	<div id="titlebarcontent">
        	<h1>You're just 60 seconds away from your new account.</h1>
            <p>All plans come with a first 30 days, no risk free trial</p>
        </div>
    </div>
</div>
<!-- end title of page -->
<!-- division -->
<div class="splitter"><div class="inner-split"></div></div>
<div class="shadow"><div class="inner-shadow"><div class="white-arrow-down"></div></div></div>
<!-- end of division -->
<!-- start content -->
<div id="mainbodywrapper">
	<div id="mainbodycontent">
		<div id="registration">
        	<div id="leftcontents">
            	<div>
					<?php
                    if($plan == "free"){
                        echo HTML::image('img/plan_free.png');
                    }elseif($plan == "basic"){
                        echo HTML::image('img/plan_basic.png');
                    }elseif($plan == "enhanced"){
                        echo HTML::image('img/plan_enhanced.png');
                    }elseif($plan == "premium"){
                        echo HTML::image('img/plan_premium.png');
                    }
                    ?>
                    <br /><br />                        
                </div> 
            	<?= Form::open(URL::current(), 'POST', array('autocomplete' => 'off')); ?>
                <?= Form::hidden('plan', $plan); ?>
                <div class="leftcontentblock">
                	<h2><span>1.</span> Create your <span>36</span>Stories Account</h2>
                    <table>
                    	<tr><td class="label">First Name : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'first_name',
                                        ! is_null($err) ? ($err->has('first_name') ? $err->first('first_name') : Input::get('first_name')) : Input::get('first_name'),
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('first_name') ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Last Name : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'last_name',
                                        ! is_null($err) ? ($err->has('last_name') ? $err->first('last_name') : Input::get('last_name')) : Input::get('last_name'),
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('last_name') ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Email : </td>
                        	<td>
								<?=
                                    Form::text(
                                        'email',
                                        ! is_null($err) ? ($err->has('email') ? $err->first('email') : Input::get('email')) : Input::get('email'),
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('email') ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Company : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'company',
                                        ! is_null($err) ? ($err->has('company') ? $err->first('company') : Input::get('company')) : Input::get('company'),
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('company') ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="leftcontentblock">
                	<h2><span>2.</span> Now choose a username and password</h2>
                    <table>
                    	<tr><td class="label">Username : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'username',
                                        ! is_null($err) ? ($err->has('username') ? $err->first('username') : Input::get('username')) : Input::get('username'),
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('username') ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                                <br /><small>This is what you'll use to sign in.</small>
                            </td>
                        </tr>
                        <tr><td class="label">Password : </td>
                        	<td>
                                <?=
                                    Form::password(
                                        'password',
                                        array('class' => 'reg-text')
                                    ); 
                                ?><br />
                                <span name="password" class="<?= (! is_null($err) ? ($err->has('password') ? 'err-text' : '') : ''); ?>">
                                    <?= (! is_null($err) ? ($err->has('password') ? $err->first('password') : '') : ''); ?>
                                </span>
                                <div><small>6 characters or longer with at least one number is safest.</small></div>
                            </td>
                        </tr>
                        <tr><td class="label" valign="middle">Confirm Password : </td>
                        	<td>
                                <?=
                                    Form::password(
                                        'password_confirmation',
                                        array('class' => 'reg-text')
                                    ); 
                                ?><br/>
                                <span name="password_confirmation" class="<?= (! is_null($err) ? ($err->has('password_confirmation') ? 'err-text' : '') : ''); ?>">
                                    <?= (! is_null($err) ? ($err->has('password_confirmation') ? $err->first('password_confirmation') : '') : ''); ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="leftcontentblock">
                	<h2><span>3.</span> Create your <span>36</span>Stories site address</h2>
                    <p>Every 36Stories account has its own web address. For example, if you want <br />your 36Stories account to be at https://acme.36storiesapp.com you'd enter acme <br /> in the field below. Letters and Numbers only.</p>
                    <p>
                        <span style="font-size:13px;">https://</span>
                        <?=
                            Form::text(
                                'site_name',
                                ! is_null($err) ? ($err->has('site_name') ? $err->first('site_name') : Input::get('site_name')) : Input::get('site_name'),
                                array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('site_name') ? 'err-text' : '') : '') )
                            ); 
                        ?>
                        .36Stories.com
                    </p>
                </div>

                <div class="leftcontentblock">
                <? if( URI::segment(2) != 'secret' ): ?>
                	<h2><span>4.</span> Enter your Billing Information</h2>
                    <table>
                    	<tr><td class="label">First Name : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'billing_first_name',
                                        ! is_null($err) ? ($err->has('billing_first_name') ? $err->first('billing_first_name') : Input::get('billing_first_name')) : Input::get('billing_first_name'),
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('billing_first_name') ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Last Name : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'billing_last_name',
                                        ! is_null($err) ? ($err->has('billing_last_name') ? $err->first('billing_last_name') : Input::get('billing_last_name')) : Input::get('billing_last_name'),
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('billing_last_name') ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Billing Address : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'billing_address',
                                        ! is_null($err) ? ($err->has('billing_address') ? $err->first('billing_address') : Input::get('billing_address')) : Input::get('billing_address'),
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('billing_address') ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Billing City : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'billing_city',
                                        ! is_null($err) ? ($err->has('billing_city') != '' ? $err->first('billing_city') : Input::get('billing_city')) : Input::get('billing_city'),
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('billing_city') ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Billing State : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'billing_state',
                                        ! is_null($err) ? ($err->has('billing_state') ? $err->first('billing_state') : Input::get('billing_state')) : Input::get('billing_state'),
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('billing_state') ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Billing Country : </td>
                        	<td>
                                <select name="billing_country" class="reg-select medium">
                                    <option value=""></option>
                                    <?php foreach( $country_names as $name ): ?>
                                        <option value="<?php echo $name; ?>" <?= ($name == Input::get('billing_country') ? 'selected' : ''); ?> >
                                            <?php echo $name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select><br/>
                                <span name="billing_country" class="<?= ! is_null($err) ? ($err->has('billing_country') ? 'err-text' : '') : '' ?>">
                                    <?= ! is_null($err) ? ($err->has('billing_country') ? $err->first('billing_country') : '') : '' ?>
                                </span>
						    </td>
                        </tr>
                        <tr><td class="label">Billing ZIP : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'billing_zip',
                                        ! is_null($err) ? ($err->has('billing_zip') ? $err->first('billing_zip') : Input::get('billing_zip')) : Input::get('billing_zip'),
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('billing_zip') ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                                <small>(or Postal Code If not in the USA)</small>
                            </td>
                        </tr>
                        <tr><td class="label">Card Number : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'card_number',
                                        ! is_null($err) ? ($err->has('card_number') ? $err->first('card_number') : Input::get('card_number')) : Input::get('card_number'),
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('card_number') ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                                <span class="err-text"><?= nl2br($braintree_err); ?></span>
                            </td>
                            <td valign="middle">
								<strong class="secure-ico">Secure</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Expiry Date : </td>
                            <td>
                                <select name="expiration_month" class="reg-select medium">
                                    <option value="">Month</option>
                                    <? for( $a = 1; $a <= 12; $a++ ): ?>
                                        <option value="<?= substr('0' .$a, -2); ?>" <?= ($a == Input::get('expiration_month') ? 'selected' : ''); ?> >
                                            <?= date('F', mktime(0, 0, 0, $a)); ?>
                                        </option>
                                    <? endfor; ?>
                                </select>
                                <select name="expiration_year" class="reg-select small">
                                    <option value="">Year</option>
                                    <? for( $a = date('Y'); $a <= date('Y') + 5; $a++ ): ?>
                                        <option value="<?= $a; ?>" <?= ($a == Input::get('expiration_year') ? 'selected' : ''); ?> >
                                            <?= $a; ?>
                                        </option>
                                    <? endfor; ?>
                                </select>
                                <span name="expiration_month" class="<?= ! is_null($err) ? ($err->has('expiration_month') ? 'err-text' : '') : '' ?>">
                                    <?= ! is_null($err) ? ($err->has('expiration_month') ? $err->first('expiration_month') : '') : '' ?>
                                </span><br/>
                                <span name="expiration_year" class="<?= ! is_null($err) ? ($err->has('expiration_year') ? 'err-text' : '') : '' ?>">
                                    <?= ! is_null($err) ? ($err->has('expiration_year') ? $err->first('expiration_year') : '') : '' ?>
                                </span>
                             </td>
                             <td><?=HTML::image('img/cards.jpg','Credit Cards')?></td>
                        </tr>
                        <tr><td class="label">CVV : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'cvv',
                                        ! is_null($err) ? ($err->has('cvv') ? $err->first('cvv') : Input::get('cvv')) : Input::get('cvv'),
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err->has('cvv') ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                    </table>
                    <p class="light-text">
                    	We don't accept POs, checks, or invoices to be paid at a later date.
                        <br />
                        We will email you a receipt each time your card is charged.
                    </p>
                <? endif; ?>
                    <div>By clicking Create Account you agree to the <?=HTML::link('/tac', 'Terms and Conditions', array('class' => 'navy'))?>, <?=HTML::link('/privacy', 'Privacy', array('class' => 'navy') )?>, and <a class="navy" href="#">Refund policies</a></div>
                </div>
                <input type="submit" name="submit" value="" class="create-account-btn" />
                <?=Form::close()?>
            </div>
            <div id="rightcontents">
            	<div class="gray-box">
                	<h1>Thank you for choosing 36Stories!</h1>
                    <h3>You're in good hands <br /> when you use  36Stories.</h3>
                    <h3>Secure and reliable</h3>
                    <p>Our services are being accessed daily by over 100,000 users and growing</p>
                    <h3>Over 100,000 users</h3>
                    <p>Your data is backed up daily</p>
                    <h3>Great customer service</h3>
                    <p>Fast, speedy, and friendly help</p>
                    <br /><br />
                </div>
                <div class="blue-box">
                	<div class="updated-ribbon"></div>
                	<h2>30 Day Free Trial</h2>
                    <p>You won't be billed unless you keep your account past the 30-day free trial.</p>
                    <p>We need your billing information to reduce fraud and verify you have a valid credit card should you keep your account open. This prevents any interruption in service.</p>
                </div>
            </div>
            <br class="clear" />
        </div>
    </div>
</div>
<!-- end of content -->
<script type="text/javascript">

    // clear the error on input focus.
    $('input, select').focus(function(){
        
        if( $(this).is('.err-text') ){
            $(this).val('');
            $(this).removeClass('err-text');
        }

        if( $(this).is('input[type=password]') || $(this).is('select') ){
            $('span[name=' + $(this).attr('name') + ']').text('');
        }

    });


    // validate form when submitted.
    $('input[type=submit]').click(function(e){

        // elements with their names in span array will have their errors displayed somewhere else. not in them.
        var span = ['password', 'password_confirmation', 'billing_country', 'expiration_month', 'expiration_year'];
        var errors = '';
        var data = '';


        // reset the err-text and error spans.
        $('span.err-text').text('');
        $('.err-text').val('');
        $('.err-text').removeClass('err-text');

        
        // loop through inputs and selects and collect their names and values.
        $('input, select').each(function(){
            data += '&' + $(this).attr('name') + '=' + $(this).val();
        });

        
        // do an ajax validation.
        $.ajax({
            async: false,
            type: 'post',
            data: data,
            url: '<?= URL::base(); ?>/registration/ajax_validation/',
            success: function(error_msg){
                
                // display errors if there are.
                if( error_msg != '' ){
                    
                    errors = error_msg;
                    error_msg = $.parseJSON(error_msg);
                    
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
            
            e.preventDefault();

            // clear the passwords.
            $('input[type=password]').val('');
            
            // scroll to the first error the form.
            $('html, body').animate({
				scrollTop: $('.err-text').first().offset().top
			}, 200);

        }

    });

</script>
