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
            	<?= Form::open('registration/' . $plan, 'POST'); ?>
                <?= Form::hidden('account[plan]', $plan); ?>
                <div class="leftcontentblock">
                	<h2><span>1.</span> Create your <span>36</span>Stories Account</h2>
                    <table>
                    	<tr><td class="label">First Name : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'transaction[customer][first_name]',
                                        ! is_null($err) ? ($err['customer']->first('first_name') != '' ? $err['customer']->first('first_name') : FormData::reg('transaction[customer][first_name]')) : '',
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['customer']->first('first_name') != '' ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Last Name : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'transaction[customer][last_name]',
                                        ! is_null($err) ? ($err['customer']->first('last_name') != '' ? $err['customer']->first('last_name') : FormData::reg('transaction[customer][last_name]')) : '',
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['customer']->first('last_name') != '' ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Email : </td>
                        	<td>
								<?=
                                    Form::text(
                                        'transaction[customer][email]',
                                        ! is_null($err) ? ($err['customer']->first('email') != '' ? $err['customer']->first('email') : FormData::reg('transaction[customer][email]')) : '',
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['customer']->first('email') != '' ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Company : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'transaction[customer][company]',
                                        ! is_null($err) ? ($err['customer']->first('company') != '' ? $err['customer']->first('company') : FormData::reg('transaction[customer][company]')) : '',
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['customer']->first('company') != '' ? 'err-text' : '') : '') )
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
                                        'account[username]',
                                        ! is_null($err) ? ($err['account']->first('username') != '' ? $err['account']->first('username') : FormData::reg('account[username]')) : '',
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['account']->first('username') != '' ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                                <br /><small>This is what you'll use to sign in.</small>
                            </td>
                        </tr>
                        <tr><td class="label">Password : </td>
                        	<td>
                                <?=
                                    Form::password(
                                        'account[password1]',
                                        array('class' => 'reg-text')
                                    ); 
                                ?>
								<br /><small>6 characters or longer with at least one number is safest.</small>
                            </td>
                        </tr>
                        <tr><td class="label" valign="middle">Confirm Password : </td>
                        	<td>
                                <?=
                                    Form::password(
                                        'account[password2]',
                                        array('class' => 'reg-text')
                                    ); 
                                ?><br/>
                                <span name="account[password1]" class="err-text err-span">
                                    <?= (! is_null($err) ? ($err['account']->first('password1') != '' ? $err['account']->first('password1') : '') : ''); ?>
                                </span><br/>
                                <span name="account[password2]" class="err-text err-span">
                                    <?= (! is_null($err) ? ($err['account']->first('password2') != '' ? $err['account']->first('password2') : '') : ''); ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="leftcontentblock">
                	<h2><span>3.</span> Create your <span>36</span>Stories site address</h2>
                    <p>Every EngageBox site has its own web address. For example, if you want <br />your Basecamp site to be at http://acme.36stories.com you'd enter acme <br /> in the field below. Letters and Numbers only.</p>
                    <p>
                        <span style="font-size:13px;">http://</span>
                        <?=
                            Form::text(
                                'transaction[customer][website]',
                                ! is_null($err) ? ($err['customer']->first('website') != '' ? $err['customer']->first('website') : FormData::reg('transaction[customer][website]')) : '',
                                array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['customer']->first('website') != '' ? 'err-text' : '') : '') )
                            ); 
                        ?>
                        .36Stories.com
                    </p>
                </div>
                <div class="leftcontentblock">
                	<h2><span>4.</span> Enter your Billing Information</h2>
                    <table>
                    	<tr><td class="label">First Name : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'transaction[billing][first_name]',
                                        ! is_null($err) ? ($err['billing']->first('first_name') != '' ? $err['billing']->first('first_name') : FormData::reg('transaction[billing][first_name]')) : '',
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['billing']->first('first_name') != '' ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Last Name : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'transaction[billing][last_name]',
                                        ! is_null($err) ? ($err['billing']->first('last_name') != '' ? $err['billing']->first('last_name') : FormData::reg('transaction[billing][last_name]')) : '',
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['billing']->first('last_name') != '' ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Billing Address : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'transaction[billing][street_address]',
                                        ! is_null($err) ? ($err['billing']->first('street_address') != '' ? $err['billing']->first('street_address') : FormData::reg('transaction[billing][street_address]')) : '',
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['billing']->first('street_address') != '' ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Billing City : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'transaction[billing][locality]',
                                        ! is_null($err) ? ($err['billing']->first('locality') != '' ? $err['billing']->first('locality') : FormData::reg('transaction[billing][locality]')) : '',
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['billing']->first('locality') != '' ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Billing State : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'transaction[billing][region]',
                                        ! is_null($err) ? ($err['billing']->first('region') != '' ? $err['billing']->first('region') : FormData::reg('transaction[billing][region]')) : '',
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['billing']->first('region') != '' ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                        </tr>
                        <tr><td class="label">Billing Country : </td>
                        	<td>
                                <select name="transaction[billing][country_name]" class="reg-select medium">
                                    <option value=""></option>
                                    <?php foreach( $country_names as $name ): ?>
                                        <option value="<?php echo $name; ?>" <?= ($name == FormData::reg('transaction[billing][country_name]') ? 'selected' : ']'); ?> >
                                            <?php echo $name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select><br/>
                                <span name="transaction[billing][country_name]" class="err-text err-span">
                                    <?= ! is_null($err) ? ($err['billing']->first('country_name') != '' ? $err['billing']->first('country_name') : '') : '' ?>
                                </span>
						    </td>
                        </tr>
                        <tr><td class="label">Billing ZIP : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'transaction[billing][postal_code]',
                                        ! is_null($err) ? ($err['billing']->first('postal_code') != '' ? $err['billing']->first('postal_code') : FormData::reg('transaction[billing][postal_code]')) : '',
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['billing']->first('postal_code') != '' ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                                <small>(or Postal Code If not in the USA)</small>
                            </td>
                        </tr>
                        <tr><td class="label">Card Number : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'transaction[credit_card][number]',
                                        ! is_null($err) ? ($err['credit_card']->first('number') != '' ? $err['credit_card']->first('number') : FormData::reg('transaction[credit_card][number]')) : '',
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['credit_card']->first('number') != '' ? 'err-text' : '') : '') )
                                    ); 
                                ?>
                            </td>
                            <td valign="middle">
								<strong class="secure-ico">Secure</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Expiry Date : </td>
                            <td>
                                <select name="transaction[credit_card][expiration_month]" class="reg-select medium">
                                    <? for( $a = 1; $a <= 12; $a++ ): ?>
                                        <option value="<?= substr('0' .$a, -2); ?>" <?= ($a == FormData::reg('transaction[credit_card][expiration_month]') ? 'selected' : ']'); ?> >
                                            <?= date('F', mktime(0, 0, 0, $a)); ?>
                                        </option>
                                    <? endfor; ?>
                                </select>
                                <select name="transaction[credit_card][expiration_year]" class="reg-select small">
                                    <? for( $a = date('Y'); $a <= date('Y') + 5; $a++ ): ?>
                                        <option value="<?= $a; ?>" <?= ($a == FormData::reg('transaction[credit_card][expiration_year]') ? 'selected' : ']'); ?> >
                                            <?= $a; ?>
                                        </option>
                                    <? endfor; ?>
                                </select>
                                <span name="transaction[credit_card][expiration_month]" class="err-text err-span">
                                    <?= ! is_null($err) ? ($err['credit_card']->first('expiration_month') != '' ? $err['credit_card']->first('expiration_month') : '') : '' ?>
                                </span><br/>
                                <span name="transaction[credit_card][expiration_year]" class="err-text err-span">
                                    <?= ! is_null($err) ? ($err['credit_card']->first('expiration_year') != '' ? $err['credit_card']->first('expiration_year') : '') : '' ?>
                                </span>
                             </td>
                             <td><?=HTML::image('img/cards.jpg','Credit Cards')?></td>
                        </tr>
                        <tr><td class="label">CVV : </td>
                        	<td>
                                <?=
                                    Form::text(
                                        'transaction[credit_card][cvv]',
                                        ! is_null($err) ? ($err['credit_card']->first('cvv') != '' ? $err['credit_card']->first('cvv') : FormData::reg('transaction[credit_card][cvv]')) : '',
                                        array('class' => 'reg-text ' . ( ! is_null($err) ? ($err['credit_card']->first('cvv') != '' ? 'err-text' : '') : '') )
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
                    <p>By clicking Create Account you agree to the <?=HTML::link('/tac', 'Terms and Conditions', array('class' => 'navy'))?>, <?=HTML::link('/privacy', 'Privacy', array('class' => 'navy') )?>, and <a class="navy" href="#">Refund policies</a></p>
                </div>
                <input type="submit" name="submit" value="" class="create-account-btn" />
                <?=Form::close()?>
            </div>
            <div id="rightcontents">
            	<div class="gray-box">
                	<h1>Thank you for choosing 36Stories!</h1>
                    <h3>Your're in good hands <br /> when you use  36Stories.</h3>
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

    // remove the red text in input.
    $('input').keydown(function(){
        $(this).removeClass('err-text');
    });


    // validate form when submitted.
    $('input[type=submit]').click(function(e){
        
        // disable this for a while.
        // problem: fields with two pairs of brackets can't be recognized in selector.
        // ex: $('input[name=account[username]] => recognized.
        // ex: $('input[name=transaction[customer][first_name]] => not recognized.
        //return;


        // elements with their names in span array will have their errors displayed somewhere else. not in them.
        var span = ['account[password1]', 'account[password2]', 'transaction[billing][country_name]', 'transaction[credit_card][expiration_month]', 'transaction[credit_card][expiration_year]'];
        var errors = '';
        var data = '';

        
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
                    $.each(error_msg, function(k, v){
                        
                        // maybe it won't hurt to do another loop here.
                        $('input, select, .err-span').each(function(){
                            
                            // this will be our way of selecting the field with error
                            // because we're having trouble with selecting fields with names
                            // that contain two pairs of square bracket.
                            if( $(this).attr('name') == k ){
                                
                                // if k is not in span array, display the error in the item.
                                if( span.indexOf(k) == -1 ){
                                    
                                    $(this).val( v );
                                    $(this).addClass('err-text');
                                   
                                // if k is in span array, display the error in item's span.
                                }else{
                                    
                                    $(this).text( v );

                                }        

                            }

                        });

                    });

                }

            }

        });


        // if there are any errors in the form, don't submit it.
        if( errors != '' ){
            
            e.preventDefault();
            
            // scroll to the top of the form.
            $('html, body').animate({
				scrollTop: $("#leftcontents").offset().top
			}, 200);

        }

    });

</script>
