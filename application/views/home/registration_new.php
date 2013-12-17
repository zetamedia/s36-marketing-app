        <div class="page-container">
            
            <div id="main-nav" class="wrapper section">
                <div class="container">
                    <span id="logo">fdback</span>
                    <nav>
                        <ul class="list-unstyled">
                             <li><a href="#benefits" class="smooth-scroll">Benefits</a></li>
                            <li><a href="#how-it-works" class="smooth-scroll">Features</a></li>
                            <li><a href="#plans" class="smooth-scroll">Pricing Plans</a></li>
                            <li><a href="#contact-us" class="smooth-scroll">Contact Us</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
             <div id="plans" class="wrapper section">
                <div class="container">
                    <h2>You’re just 60 seconds away from your new account.</h2>
                    <p>All plans come with a first <em><strong>30 days</strong></em>, no risk free trial</p>
                    <div id="registration-page" class="clearfix">
                        <div id="registration-form-box">
                        <form id="registration_form" method="post" action="/registration/secret" autocomplete="off">
                            <input name="plan" type="hidden" value="<?=$plan?>"/>
                            <input name="regtype" type="hidden" value="<?=URI::segment(2)?>"/>
                            <div id="registration-form">
                                <div class="reg-header">
                                    1. Create your fdback account
                                </div>
                                <div class="reg-input-block clearfix">
                                    <div class="label">First Name :</div>
                                    <div class="input">
                                        <input type="text" name="first_name"/>
                                    </div>
                                </div>
                                <div class="reg-input-block clearfix">
                                    <div class="label">Last Name :</div>
                                    <div class="input">
                                        <input type="text" name="last_name"/>
                                    </div>
                                </div>
                                <div class="reg-input-block clearfix">
                                    <div class="label">Email :</div>
                                    <div class="input">
                                        <input type="text" name="email"/>
                                    </div>
                                </div>
                                <div class="reg-input-block clearfix">
                                    <div class="label">Company :</div>
                                    <div class="input">
                                        <input type="text" name="company"/>
                                    </div>
                                </div>
                                <div class="reg-header">
                                    2. Now choose a username and password
                                </div>
                                <div class="reg-input-block clearfix">
                                    <div class="label">Username :</div>
                                    <div class="input">
                                        <input type="text" name="username" /><br />
                                        <p>This is what you'll use to sign in.</p>
                                    </div>
                                </div>
                                <div class="reg-input-block clearfix">
                                    <div class="label">Password :</div>
                                    <div class="input">
                                        <input type="password" name="password"/>
                                        <span name="password"></span>
                                        <p>6 characters or longer with at least one number is safest.</p>
                                    </div>
                                </div>
                                <div class="reg-input-block clearfix">
                                    <div class="label">Confirm Password :</div>
                                    <div class="input">
                                        <input type="password" name="password_confirmation"/>
                                        <span name="password_confirmation"></span>
                                    </div>
                                </div>
                                <div class="reg-header">
                                    3. Create your fdback site address
                                </div>
                                <div class="reg-text">
                                    <p>Every fdback account has its own web address. For example, if you want your fdback account to be at https://acme.fdback.com you'd enter acme in the field below. Letters and Numbers only.</p>
                                </div>
                                <div class="reg-input-block">
                                    <div class="input-whole">
                                        https://<input type="text" class="reg-site-input" name="site_name" />.fdback.com
                                        <p>Accepts only alphanumeric characters, dash, and underscore.</p>
                                    </div>
                                </div>
                                <div class="reg-text">
                                    <p>By clicking Sign Up you agree to the <a href="javascript:;">Terms and Conditions</a>, <a href="javascript:;">Privacy</a>, and <a href="javascript:;">Refund policies</a></p>
                                </div>
                                <div class="reg-input-block">
                                    <div class="submit"><input type="submit" name="submit" class="button" value="SIGN UP" /></div>
                                </div>
                            </div>
                        <?=Form::close()?>
                        </div>

                        <div id="registration-features">
                            <div id="reg-features">
                                <h2>Thank you for choosing fdback!</h2>
                                <div class="reg-feat-block clearfix">
                                    <div class="reg-feat-block-icon"><img src="/img/reg-feature-1.jpg" data-original="/img/reg-feature-1.jpg" /></div>
                                    <div class="reg-feat-text"><div class="title">You're in good hands when you use fdback.</div></div>
                                </div>
                                <div class="reg-feat-block clearfix">
                                    <div class="reg-feat-block-icon"><img src="/img/reg-feature-2.jpg" data-original="/img/reg-feature-2.jpg" /></div>
                                    <div class="reg-feat-text">
                                        <div class="title">Secure and reliable</div>
                                        <div class="subt-title">Our services are being accessed daily by over 100,000 users and growing</div>
                                    </div>
                                </div>
                                <div class="reg-feat-block clearfix">
                                    <div class="reg-feat-block-icon"><img src="/img/reg-feature-3.jpg" data-original="/img/reg-feature-3.jpg" /></div>
                                    <div class="reg-feat-text">
                                        <div class="title">Over 100,000 users</div>
                                        <div class="subt-title">Your data is backed up daily</div>
                                    </div>
                                </div>
                                <div class="reg-feat-block clearfix">
                                    <div class="reg-feat-block-icon"><img src="/img/reg-feature-4.jpg" data-original="/img/reg-feature-4.jpg" /></div>
                                    <div class="reg-feat-text">
                                        <div class="title">Great customer service</div>
                                        <div class="subt-title">Fast, speedy, and friendly help</div>
                                    </div>
                                </div>
                                <div id="gurantee">
                                    <img src="/img/blank.png" data-original="/img/badge-satisfaction-guaranteed.png" alt="">
                                    <h3>100% No-Risk Double-Gurantee</h3>
                                    <p>You are fully protected by our 100% No-Risk Double-Guarantee. If you don't increase your website's conversion rate or revenues over the next 60 days, just let us know and we'll send you a prompt refund. No questions asked.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- #plans -->

             <footer id="contact-us" class="wrapper section">
                <div class="container">
                    <h2>Got fdback?</h2>
                    <div class="row">
                        <div class="col-md-5">
                            <div id="contact-form-wrapper">
                                <form action="#" method="post" id="contact-form" class="validate" data-html5-validation="false" data-validate-fields="true">
                                    <fieldset>
                                        <div class="control-group text-field">
                                            <div class="controls name">
                                                <input id="contact-name" name="name" type="text" placeholder="First and last name" class="required" autocomplete="false" data-message="Please enter your full name">
                                            </div>
                                        </div>
                                        <div class="control-group text-field">
                                            <div class="controls email">
                                                <input id="contact-email" name="email" type="email" placeholder="Email" class="required" autocomplete="false">
                                            </div>
                                        </div>
                                        <div class="control-group comment-group">
                                            <div class="controls comment">
                                                <textarea id="contact-comment" name="comment" placeholder="Enter your comments" class="required" rows="5" autocomplete="false" data-message="Please leave a comment or question"></textarea>
                                                <button type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <div id="address">
                            <span>36Stories Inc</span>
                            <span>340 Lemon Ave #7585</span>
                            <span>Walnut, CA 91789, ISA</span>
                        </div>
                        <ul id="social-footer" class="list-unstyled">
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-facebook-square"></i></a></li>
                        </ul>
                    </div>
                </div>
            </footer> <!-- #contact-us -->

        </div>

        <div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="signup-modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Register your account</h3>
                    </div>
                    <div class="modal-body">
                        <div id="signup-form-wrapper">
                            <form action="#" method="post" id="signup-form" class="validate" data-html5-validation="false" data-validate-fields="true">
                                <fieldset>
                                    <div style="display: none;">
                                        <input type="hidden" name="plan" id="signup-plan-type">
                                    </div>
                                    <div class="control-group text-field">
                                        <div class="controls name">
                                            <input name="name" type="text" placeholder="First and last name" class="required" autocomplete="false" data-message="Please enter your full name">
                                        </div>
                                    </div>
                                    <div class="control-group text-field">
                                        <div class="controls company">
                                            <input name="company" type="text" placeholder="Company Name" class="required" autocomplete="false" data-message="Please enter your company name">
                                        </div>
                                    </div>
                                    <div class="control-group text-field">
                                        <div class="controls email">
                                            <input id="signup-email" name="email" type="email" placeholder="Email" class="required" autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="control-group text-field">
                                        <div class="controls email">
                                            <input id="signup-email-confirm" name="email-confirmation" type="email" placeholder="Confirm email" class="required" autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="control-group text-field">
                                        <div class="controls password">
                                            <input id="signup-password" name="password" type="password" placeholder="Pick a password" class="required" autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="control-group text-field">
                                        <div class="controls password">
                                            <input id="signup-password-confirm" name="password-confirmation" type="password" placeholder="Confirm password" class="required" autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="control-group submit">
                                        <button type="submit">Get Started</button>
                                    </div> 
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

