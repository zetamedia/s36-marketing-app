<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<style type="text/css">

</style>
<body bgcolor="#dde0e3" style="padding:0;margin:0;font-size:14px;font-family:Arial, Helvetica, sans-serif;">
<table bgcolor="#dde0e3" width="716" cellpadding="0" cellspacing="0">
	<tr>
    	<td style="padding:30px 30px 10px;">
        	<table bgcolor="white" style="background:#FFF" cellpadding="0" cellspacing="0">
            	<tr><td style="padding:20px;" cellpadding="0" cellspacing="0">
                	<table width="616" cellpadding="0" cellspacing="0">
                    	<!-- header -->
                        <tr>
                        	<td width="33.33%"><img src="<?= URL::base(); ?>/img/36-storieslogo.png" /></td><td width="33.33%"></td><td width="33.33%" align="right"></td>
                        </tr>
                        <tr height="20">
                        	<td colspan="3"></td>
                        </tr>
                        <tr height="1" bgcolor="#e7e9eb">
                        	<td colspan="3"></td>
                        </tr>
                        <tr height="20">
                        	<td colspan="3"></td>
                        </tr>
                        
                        <!-- end of header -->
                        <!-- contents -->
                        <tr>
                        	<td colspan="3" style="padding-right:140px;line-height:20px;color:#464646;">
                                
                                Hi <b><?= ucfirst($firstname); ?></b>,<br/><br/>

                                Thank you for registering with us. Please click the link below and use the following username and password to log in to your account backend.<br/><br/>
                                Username: <?= $username; ?><br/>
                                Password: <?= $password; ?><br/><br/><br/>
                           
                            	<a href="<?= $account_login_url; ?>" style="padding:15px 20px;color:#0d8eae;background:#c2dcc9;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;"><?= $account_login_url; ?></a>
                            	<br /><br /><br /><br/>
								
                            </td>
                        </tr>
                        <!-- end of contents -->
                        
                        <!-- sig -->
                        <tr>
                        	<td colspan="3">
                            				Thanks, <br />
											The fdback team
                            </td>
                        </tr>
                        <tr height="20">
                        	<td colspan="3"></td>
                        </tr>
                        <tr height="20">
                        	<td colspan="3"></td>
                        </tr>
                        
                        <!-- end sig -->
                    </table>
                </td></tr>
            </table>
        </td>
    </tr>
    <!-- footer -->
    <tr>
        <td style="font-size:10px;padding:0px 30px;line-height:16px;">
            This message was intended for <?= $customer_email; ?>.  <br />
            36Stories Inc 340 Lemon Ave #6168 Walnut CA, 91789 United States
       </td>
    </tr>
    <!-- end footer -->    
</table>
</body>
</html>
