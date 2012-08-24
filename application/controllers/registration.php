<?php
    
    class Registration_Controller extends Base_Controller{
        
        // show the registration form.
        function action_show_form($plan = null, $errors = null){
            
            // get the valid plans.
            $valid_plans = array_map('strtolower', Plan::get_all_names());

            // redirect to plan selection if the selected plan is not valid.
            if( ! in_array($plan, $valid_plans) ) return Redirect::to('pricing');
            

            $data['creditcard'] = true;
            $data['plan'] = $plan;
            $data['country_names'] = Country::get_all_names();
            $data['errors'] = $errors;
            
            return View::of('layout')->nest('contents', 'home.registration', $data);

        }



        // do all the process in registration.
        function action_process(){
            
            // set the validation rules.
            $rules = $this->get_validation_rules();
            $messages = $this->get_validation_messages();
            $validation = Validator::make(Input::get(), $rules, $messages);
            

            // if the validation fails, show the regs form with errors.
            if( $validation->fails() ){
                
                return $this->action_show_form(Input::get('plan'), $validation->errors);

            
            // if validation succeeds, do the registration processing.
            }else{
                
                // create cc details obj.
                $cc_details = new CCDetails(Input::get());


                // save customer account in db.
                $dbaccount = new DBAccount();
                $dbaccount->create_account();


                // send email to customer.
                $email = new S36Email('new-account');
                $email->to(Input::get('email'))->send();

                
                // redirect to success page with the customer's site name.
                $site = 'https://' . Input::get('website') . '.36storiesapp.com/login';
                return Redirect::to('registration-successful/?login_url=' . $site);

            }

        }



        // set and return the validation rules.
        function get_validation_rules($key = null){
            
            $rules['firstname'] = 'required';
            $rules['lastname'] = 'required';
            $rules['email'] = 'required|email';
            $rules['company'] = 'required|unique:Company,name';
            $rules['username'] = 'required';
            $rules['password1'] = 'required|min:6';
            $rules['password2'] = 'required|min:6';
            $rules['website'] = 'required|match:/^[\w*\d*]+(-*_*\.*)?[\w*\d*]+$/';
            $rules['billingfirstname'] = 'required';
            $rules['billinglastname'] = 'required';
            $rules['billingaddress1'] = 'required';
            $rules['billingcity'] = 'required';
            $rules['billingstate'] = 'required';
            $rules['billingcountry'] = 'required|exists:Country,name';
            $rules['billingzip'] = 'required';
            $rules['cardnumber'] = 'required|numeric';
            $rules['expirymonth'] = 'required|in:01,02,03,04,05,06,07,08,09,10,11,12';
            $rules['expiryyear'] = 'required|in:' . implode(',', range(date('Y'), date('Y') + 5) );
            $rules['cvv'] = 'required';
            $rules['plan'] = 'required|exists:Plan,name';


            // if key is not given, add this to password1's rule.
            // this additional rule will validate the equality of password1 and password2 in server side.
            $rules['password1'] .= ( is_null($key) ? '|same:password2' : '' );
            
            
            // if key is given, return only the validation rule for that key.
            return ( ! is_null($key) ? array($key => $rules[$key]) : $rules );

        }



        // set and return the custom validation messages.
        function get_validation_messages(){
            
            $msg['firstname_required'] = 'Please Enter Your First Name';
            $msg['lastname_required'] = 'Please Enter Your Last Name';
            $msg['email_required'] = 'Please Enter Your Email';
            $msg['company_required'] = 'Please Enter Your Company';
            $msg['username_required'] = 'Please Enter Your Username';
            $msg['password1_required'] = 'Please Enter Your Password';
            $msg['password1_min'] = 'Password must be at lest :min characters';
            $msg['password1_same'] = 'Your passwords don\'t match';
            $msg['password2_required'] = 'Please Enter Your Password Confirmation';
            $msg['password2_min'] = 'Password Confirmation must be at lest :min characters';
            $msg['website_required'] = 'Please Enter Your Site Address';
            $msg['billingfirstname_required'] = 'Please Enter Your Billing First Name';
            $msg['billinglastname_required'] = 'Please Enter Your Billing Last Name';
            $msg['billingaddress1_required'] = 'Please Enter Your Billing Address';
            $msg['billingcity_required'] = 'Please Enter Your Billing City';
            $msg['billingstate_required'] = 'Please Enter Your Billing State';
            $msg['billingcountry_required'] = 'Please Enter Your Billing Country';
            $msg['billingcountry_exists'] = 'The Selected Billing Country is invalid';
            $msg['billingzip_required'] = 'Please Enter Your Billing Zip';
            $msg['cardnumber_required'] = 'Please Enter Your Credit Card Number';
            $msg['cardnumber_numeric'] = 'Credit Card Number must be numeric';
            $msg['expirymonth_required'] = 'Please Enter Expiry Month';
            $msg['expirymonth_in'] = 'The selected Expiry Month is invalid';
            $msg['expiryyear_required'] = 'Please Enter Expiry Year';
            $msg['expiryyear_in'] = 'The selected Expiry Year is invalid';
            $msg['cvv_required'] = 'Please Enter Your CVV';

            return $msg;

        }



        // function that validates a single field.
        function action_ajax_validation($key = null){
            
            // if the given key is not known to humanity, return no error.
            if( ! array_key_exists($key, $this->get_validation_rules()) ) return '';
            

            // get the validation rule of the single field. $key is the name of that field.
            $rules = $this->get_validation_rules($key);
            $messages = $this->get_validation_messages();
            $validation = new Validator(Input::get(), $rules, $messages);
            
            // if validation fails, return the error to be outputted.
            if( $validation->fails() ){
                
                return $validation->errors->first($key);

            }

        }

    }

?>
