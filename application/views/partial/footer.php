<!-- start of blue strip -->
<div class="blue-dash"></div>
<div id="bluestripwrapper">
	<div id="bluestripcontent">
    	<div class="strip-box">
        	<div class="bubble-icon">It's great feedback, made even better.</div>
        </div>
        <div class="strip-box dark">
        	<div class="chat-icon left-adjust">Get powerful, authentic<br /> endorsements. Everyday.</div>
        </div>
        <div class="strip-box light">
        	<div class="dollar-icon">Instantly boost buyer confidence and profits.</div>
        </div>
    </div>
</div>
<div class="blue-dash"></div>
<!-- end of blue strip -->
<!-- start of link blocks -->
<div id="linkblockwrapper">
    <div id="linkblockcontents">
    	<div class="link-block">
        	<h2>ABOUT US</h2>
            <ul>
            	<li><a href="javascript:;">Blog</a></li>
                <li><a href="javascript:;">The Team</a></li>
                <!--<li><a href="#">Investors</a></li>
                <li><a href="#">Jobs</a></li>-->
                <li><a href="<?//= URL::to('contact'); ?>">Contact Us</a></li>
            </ul>
        </div>
        <div class="link-block">
        	<h2>SUPPORT</h2>
            <ul>
            	<li><a href="javascript:;" target="_blank">Help Center</a></li>
                <!--<li><a href="#">Community</a></li>-->
                <!--<li><a href="#">Quick Start Guide</a></li>-->
            </ul>
        </div>
        <div class="link-block">
        	<h2>COMMUNITY</h2>
            <ul>
            	<li><a href="https://facebook.com/36Stories" target="_blank">Facebook</a></li>
            	<li><a href="https://Twitter.com/36Stories" target="_blank">Twitter</a></li>
            </ul>
        </div>
        <!--
        <div class="link-block">
            <h2>PARTNERS</h2>
            <ul>
            	<li><a href="#">Developer API</a></li>
                <li><a href="#">App Directory</a></li>
                <li><a href="#">Affiliate Program</a></li>
                <li><a href="#">Partner</a></li>
                <li><a href="#">Others</a></li>
            </ul>
        </div>
        -->
        <div class="link-block">
        	<!--
            <h2>SERVICES</h2>
            <ul>
            	<li><a href="#">Blog</a></li>
                <li><a href="#">Press Releases</a></li>
                <li><a href="#">Press Information</a></li>
                <li><a href="#">Management</a></li>
                <li><a href="#">Board of Directors</a></li>
                <li><a href="#">Investors</a></li>
                <li><a href="#">Jobs</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
            -->
        </div>
        
        
        
        <div class="link-block">
        	<!--
            <h2>FAQ</h2>
            <ul>
            	<li><a href="#">Help Center</a></li>
                <li><a href="#">Community</a></li>
                <li><a href="#">Quick Start Guide</a></li>
                <li><a href="#">Video Tutorials</a></li>
            </ul>
            -->
        </div>
        
        <div class="contact-info">
        	<h2>CONTACT US</h2>
        	<ul>
            	<!--<li class="telephone">1-8000-12345678</li>
                <li class="mobile">1-8000-12345678</li>-->
                <li class="email"><strong>Drop us an email</strong></li>
            </ul>
            <div class="bottom-logo"><img src="img/36-storieslogo.png"/></div>
        </div>
        <br class="clear" />
	</div><!-- end of link block contents -->
</div>
<!-- end of link blocks -->
<div id="footerwrapper">
    <div id="footercontents">
    	<div class="copyright">
    		<span>© 2011 36Stories Inc. All Rights Reserved.</span>  <?=HTML::link_to_secure('/tac', 'Terms')?>  | <?=HTML::link_to_secure('/privacy', 'Privacy')?>
        </div>
        <div class="socialicons">
        	<div class="text">Stay in touch</div>
            <ul>
                <li><a href="https://facebook.com/36Stories" title="Facebook Page" target="_blank"><img src="img/ico-fb.png"/></a></li>
                <li><a href="https://Twitter.com/36Stories" title="Twitter Page" target="_blank"><img src="img/ico-twitter.png"/></a></li>
                <!--this is a comment
                <li><a href="#"><?=HTML::image('img/ico-tumblr.png')?></a></li>
                <li><a href="#"><?=HTML::image('img/ico-youtube.png')?></a></li>
                <li><a href="#"><?=HTML::image('img/ico-flickr.png')?></a></li>
                    Dan is gay-->
            </ul>
        </div>
        <br class="clear" />
    </div>
</div>
</div>
</body>
</html>
