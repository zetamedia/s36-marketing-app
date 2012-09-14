<?php
    
    class Registration_Controller extends Base_Controller{
        
        // show the registration form.
        function action_show_form($plan = null, $errors = null){
            
            // get the valid plans.
            $valid_plans = array_map('strtolower', DBPlan::get_all_names());

            // add "secret" to valid plans.
            $valid_plans[] = 'secret';

            // redirect to plan selection if the selected plan is not valid.
            if( ! in_array($plan, $valid_plans) ) return Redirect::to('pricing');
            

            // if plan is secret, treat it as basic.
            $data['plan'] = ($plan == 'secret' ? 'basic' : $plan);
            $data['country_names'] = DBCountry::get_all_names();

            // if $errors is object, it's an error from form validation.
            $data['err'] = ( is_object($errors) ? $errors : null );

            // if $errors is not object, it's a string error from braintree.
            $data['braintree_err'] = ( is_object($errors) ? null : $errors );
            
            return View::of('layout')->nest('contents', 'home.registration', $data);

        }



        // do all the process in registration.
        function action_process(){
            
            // run the form validation.
            $validation = Validator::make(Input::get(), $this->get_validation_rules(), $this->get_validation_messages());
            
            // if there are form validation errors, show the regs form with errors.
            if( $validation->fails() ) return $this->action_show_form(URI::segment(2), $validation->errors);

            
            // if creating secret account, need not to do braintree stuffs.
            if( URI::segment(2) != 'secret' ){
                
                // create braintree account and get the result.
                $result = S36Braintree::create_account();

                // if braintree account creation didn't succeed, show the regs form with errors.
                if( ! $result['success'] ) return $this->action_show_form(URI::segment(2), $result['message']);

            }

            // if creating secret account, set customer_id to blank.
            $result['customer_id'] = (URI::segment(2) != 'secret' ? $result['customer_id'] : '');

            
            // do the registration processing if form validation and braintree succeeds.
            
            // save customer account in db.
            $dbaccount = new DBAccount();
            $dbaccount->create_account($result['customer_id']);


            // send email to customer.
            $email = new S36Email();
            $email->create_new_account_email();
            $email->to(Input::get('email'))->send();
            
            
            // redirect to success page with the customer's site name.
            $site = URL::base();
            $tld = ( strrpos($site, '.') !== false ? substr($site, strrpos($site, '.')) : '' );
            $host = str_replace('http://', '', $site);
            $host = str_replace($tld, '', $host);
            $host = substr($host, strrpos($host, '.'));
            $host = str_replace('.', '', $host);
            $site = 'https://' . Input::get('site_name') . '.' . $host . $tld . '/login';
            return Redirect::to('registration-successful/?login_url=' . $site);

        }



        // set and return the validation rules.
        function get_validation_rules(){
            
            // let's define a custom validation for expiration month.
            // this is actually a validation for expiration date in a sense.
            Validator::register('future', function($attr, $val, $param){
                
                // if expiration year is not valid, skip on this validation rule
                // so the validation of expiration year will execute first.
                if( ! in_array(Input::get('expiration_year'), range(date('Y'), date('Y') + 5) ) ) return true;

                // expiration month or year must be in future.
                return ($val > date('m') || Input::get('expiration_year') > date('Y'));

            });

            $rules['plan'] = 'required|exists:Plan,name';
            $rules['first_name'] = 'required|max:24';
            $rules['last_name'] = 'required|max:24';
            $rules['email'] = 'required|email|max:45';
            $rules['company'] = 'required|max:45|unique:Company,name';
            $rules['username'] = 'required|max:45';
            $rules['password'] = 'required|min:6|same:password_confirmation';
            $rules['password_confirmation'] = 'required|min:6';
            $rules['site_name'] = 'required|max:100|match:/^\w+[\w\-\_]*$/|unique:Company,name'; 
            
            if( URI::segment(2) != 'secret' && URI::segment(3) != 'secret' ){
                $rules['billing_first_name'] = 'required';
                $rules['billing_last_name'] = 'required';
                $rules['billing_address'] = 'required';
                $rules['billing_city'] = 'required';
                $rules['billing_state'] = 'required';
                $rules['billing_country'] = 'required|exists:Country,name';
                $rules['billing_zip'] = 'required';
                $rules['card_number'] = 'required|numeric';
                $rules['expiration_month'] = 'required|in:01,02,03,04,05,06,07,08,09,10,11,12|future';
                $rules['expiration_year'] = 'required|in:' . implode(',', range(date('Y'), date('Y') + 5) );
                $rules['cvv'] = 'required';
            }

            return $rules;

        }



        // set and return the custom validation messages.
        function get_validation_messages(){
            
            $msg['first_name_required'] = 'Please Enter Your First Name';
            $msg['first_name_max'] = 'The First Name must be less than :max characters';
            $msg['last_name_required'] = 'Please Enter Your Last Name';
            $msg['last_name_max'] = 'The Last Name must be less than :max characters';
            $msg['email_required'] = 'Please Enter Your Email';
            $msg['email_max'] = 'The Email must be less than :max characters';
            $msg['company_required'] = 'Please Enter Your Company';
            $msg['company_max'] = 'The Company must be less than :max characters';
            $msg['username_required'] = 'Please Enter Your Username';
            $msg['username_max'] = 'The Username must be less than :max characters';
            $msg['password_required'] = 'Please Enter Your Password';
            $msg['password_confirmation_min'] = 'Password must be at lest :min characters';
            $msg['password_same'] = 'Your passwords don\'t match';
            $msg['password_confirmation_required'] = 'Please Enter Your Password Confirmation';
            $msg['password_confirmation_min'] = 'Password Confirmation must be at lest :min characters';
            $msg['site_name_required'] = 'Please Enter Your Site Address';
            $msg['site_name_max'] = 'The Site Address must be less than :max characters';
            $msg['billing_first_name_required'] = 'Please Enter Your Billing First Name';
            $msg['billing_last_name_required'] = 'Please Enter Your Billing Last Name';
            $msg['billing_address_required'] = 'Please Enter Your Billing Address';
            $msg['billing_city_required'] = 'Please Enter Your Billing City';
            $msg['billing_state_required'] = 'Please Enter Your Billing State';
            $msg['billing_country_required'] = 'Please Enter Your Billing Country';
            $msg['billing_country_exists'] = 'The Selected Billing Country is invalid';
            $msg['billing_zip_required'] = 'Please Enter Your Billing Zip';
            $msg['card_number_required'] = 'Please Enter Your Credit Card Number';
            $msg['card_number_numeric'] = 'Credit Card Number must be numeric';
            $msg['expiration_month_required'] = 'Please Enter Expiry Month';
            $msg['expiration_month_in'] = 'The selected Expiry Month is invalid';
            $msg['expiration_year_required'] = 'Please Enter Expiry Year';
            $msg['expiration_year_in'] = 'The selected Expiry Year is invalid';
            $msg['cvv_required'] = 'Please Enter Your CVV';
            $msg['future'] = 'Expiry Date must be a future date';  // custom error msg for expiration date.

            return $msg;
            
        }



        // function that makes an ajax validation.
        function action_ajax_validation(){
            
            $validation = Validator::make(Input::get(), $this->get_validation_rules(), $this->get_validation_messages());
            
            if( $validation->fails() ){
                
                $err_arr = array();

                foreach( $validation->errors->messages as $name => $msg ){
                    
                    $err_arr[$name] = $msg[0];

                }

                return json_encode($err_arr);

            }
            
        }

    }

?>
