<title>Login | 36Stories</title>
<!-- start title of page -->
<div id="titlebarwrapper">
	<div id="subtitlebarwrapper">
    	<div id="titlebarcontent">
        	<h1>Login</h1>
            <p>Login with 36Stories Account or Register Now.</p>
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
		<div id="login">
        	<div id="login-box">
            <p id="error_msg" style="color: #7093b2; text-align: center;"></p>
            <form action="" method="post">
            	<table width="100%" align="center">
                	<tr><td>Username/email : </td><td class="inputs"><input type="text" name="username" id="username" class="login-text" value="danoliver" /></td></tr>
                    <tr><td>Password : </td><td class="inputs"><input type="password" name="password" id="password" class="login-text" value="password" /></td></tr>
                    <tr><td></td><td class="inputs"><input type="submit" value="Sign in" class="login-btn" /><a href="#">Forgot your password?</a></td></tr>
                    <tr><td></td><td class="inputs"	><input type="checkbox" checked /> Remember me?</td></tr>
                </table>
            </form>
            </div>
            <br />
            <p align="center"><strong>Not yet registered?</strong> <?=HTML::link('pricing','Sign Up')?> here!</p>
        </div>
    </div>
</div>
<!-- end of content -->
<script type="text/javascript">
    $('input[type=submit]').click(function(e){
        
        var error_msg = '';
        
        // validate user login.
        $.ajax({
            async: false,
            type: 'post',
            data: 'username=' + $('#username').val() + '&password=' + $('#password').val(),
            url: '<?php echo URL::base(); ?>/validate_login',
            success: function(result){
                error_msg = result;
            }
        });
        
        
        // show the validation error if there is.
        if( error_msg != '' ){
            $('#error_msg').html(error_msg);
            e.preventDefault();
        }
        
        
        // if no error is found, submit the user to app login.
        if( error_msg == '' ){
            $.ajax({
                async: false,
                type: 'post',
                data: 'username=' + $('#username').val(),
                url: '<?php echo URL::base(); ?>/get_app_login_url',
                success: function(result){
                    $('form').attr('action', result);
                }
            });
        }
        
    });
</script>