<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="shortcut icon" href="/img/favicon.png">
		<link href="/css/s36style.css" media="all" type="text/css" rel="stylesheet"/> 
        <link href="/css/slider.css" media="all" type="text/css" rel="stylesheet"/>
      
        <script src="/js/jquery.js"></script>
        <script src="/js/slider.js"></script>
        <script src="/js/jquery.cycle.all.min.js"></script>
        <script src="/js/jquery.easing.js"></script>
</head>
<body>
<div id="the-main-content">
<!-- start header -->
<div id="headerwrapper">
	<div id="headersubwrapper">
    	<div id="headercontent">
        	<div id="mainlogo">
            <a href="<?php echo URL::base(); ?>">
                <img src="/img/36-storieslogo.png"/>
            </a>
            </div>
            <div id="top-nav">
            	<div id="nav-block">
                    <ul>
                        <li><?=HTML::link_to_secure('/', 'Home')?></li>
                        <li><?=HTML::link_to_secure('/tour', 'Tour')?></li>
                        <li><?=HTML::link_to_secure('/pricing', 'Pricing')?></li>
						<li><?=HTML::link_to_secure('/company', 'Company')?></li>
                    </ul>
                </div>
                <div id="login-block">
                	<?=HTML::link_to_secure('/login', 'LOGIN')?>
                </div>
                <div id="social-icon-block">
                    <a href="https://facebook.com/36Stories" title="Facebook Page" target="_blank"><img src="/img/head-fb-icon.png"/></a>
                    <a href="https://Twitter.com/36Stories" title="Twitter Page" target="_blank"><img src="/img/head-tw-icon.png"/></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end header -->
