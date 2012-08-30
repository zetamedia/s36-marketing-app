<?php
    
    class Registration_Controller extends Base_Controller{
        
        // show the registration form.
        function action_show_form($plan = null, $errors = null){
            
            // get the valid plans.
            $valid_plans = array_map('strtolower', Plan::get_all_names());

            // redirect to plan selection if the selected plan is not valid.
            if( ! in_array($plan, $valid_plans) ) return Redirect::to('pricing');
            

            $data['plan'] = $plan;
            $data['country_names'] = Country::get_all_names();
            $data['err'] = $errors;
            $data['input'] = Input::get();
            
            return View::of('layout')->nest('contents', 'home.registration', $data);

        }



        // do all the process in registration.
        function action_process(){
            
            // get the inputs.
            $input = Input::get('transaction');
            $account_input = Input::get('account');
            $customer_input = $input['customer'];
            $billing_input = $input['billing'];
            $credit_card_input = $input['credit_card'];
            

            // run the validation and get the errors if there are. 
            $errors = $this->run_validation();

            // do the registration processing if no errors.
            if( empty($errors) ){
                
                // save customer account in db.
                $dbaccount = new DBAccount();
                $dbaccount->create_account();


                // send email to customer.
                $email = new S36Email();
                $email->create_new_account_email();
                $email->to($customer_input['email'])->send();

                
                // redirect to success page with the customer's site name.
                $site = URL::base();
                $site = str_replace('http://', 'https://' . $customer_input['website'] . '.', $site);
                $site = $site . '/login';
                return Redirect::to('registration-successful/?login_url=' . $site);

                //$site = 'https://' . $customer_input['website'] . '.36storiesapp.com/login';
                //return Redirect::to('registration-successful/?login_url=' . $site);


            // if any of the validations failed, show the regs form with errors.
            }else{
                
                return $this->action_show_form($account_input['plan'], $errors);

            }

        }



        // run the validation of registration form. 
        // return the errors if there are. return false if none.
        function run_validation(){
            
            // get the inputs.
            $input = Input::get('transaction');
            $account_input = Input::get('account');
            $customer_input = $input['customer'];
            $billing_input = $input['billing'];
            $credit_card_input = $input['credit_card'];

            // get the validation rules.
            $account_rules = $this->get_validation_rules('account');
            $customer_rules = $this->get_validation_rules('customer');
            $billing_rules = $this->get_validation_rules('billing');
            $credit_card_rules = $this->get_validation_rules('credit_card');

            // create validation objects.
            $account_val = Validator::make($account_input, $account_rules);
            $customer_val = Validator::make($customer_input, $customer_rules);
            $billing_val = Validator::make($billing_input, $billing_rules);
            $credit_card_val = Validator::make($credit_card_input, $credit_card_rules);
            
            // run the validations.
            $account_val->passes();
            $customer_val->passes();
            $billing_val->passes();
            $credit_card_val->passes();
            
            // get the errors from validations.
            $errors['account'] = $account_val->errors;
            $errors['customer'] = $customer_val->errors;
            $errors['billing'] = $billing_val->errors;
            $errors['credit_card'] = $credit_card_val->errors;


            // return the errors if there are. return false if none.
            if( empty($account_val->errors->messages) && 
            empty($customer_val->errors->messages) && 
            empty($billing_val->errors->messages) && 
            empty($credit_card_val->errors->messages) ){
                
                return false;

            }

            return $errors;

        }



        // set and return the validation rules.
        function get_validation_rules($key = null){
            
            $rules['account']['username'] = 'required|max:45';
            $rules['account']['password1'] = 'required|min:6|same:password2';
            $rules['account']['password2'] = 'required|min:6';
            $rules['account']['plan'] = 'required|exists:Plan,name';

            $rules['customer']['first_name'] = 'required|max:24';
            $rules['customer']['last_name'] = 'required|max:24';
            $rules['customer']['email'] = 'required|email|max:45';
            $rules['customer']['company'] = 'required|max:45|unique:Company,name';
            $rules['customer']['website'] = 'required|max:100|match:/^[\w*\d*]+(-*_*\.*)?[\w*\d*]+$/';
            
            $rules['billing']['first_name'] = 'required';
            $rules['billing']['last_name'] = 'required';
            $rules['billing']['street_address'] = 'required';
            $rules['billing']['locality'] = 'required';
            $rules['billing']['region'] = 'required';
            $rules['billing']['country_name'] = 'required|exists:Country,name';
            $rules['billing']['postal_code'] = 'required';
            
            $rules['credit_card']['number'] = 'required|numeric';
            $rules['credit_card']['expiration_month'] = 'required|in:01,02,03,04,05,06,07,08,09,10,11,12';
            $rules['credit_card']['expiration_year'] = 'required|in:' . implode(',', range(date('Y'), date('Y') + 5) );
            $rules['credit_card']['cvv'] = 'required';
            
            return $rules[$key];

        }



        // set and return the custom validation messages.
        function get_validation_messages(){
            
            $msg['transaction[customer][first_name]_required'] = 'Please Enter Your First Name';
            $msg['transaction[customer][last_name]_required'] = 'Please Enter Your Last Name';
            $msg['transaction[customer][email]_required'] = 'Please Enter Your Email';
            $msg['transaction[customer][company]_required'] = 'Please Enter Your Company';
            $msg['username_required'] = 'Please Enter Your Username';
            $msg['password1_required'] = 'Please Enter Your Password';
            $msg['password1_min'] = 'Password must be at lest :min characters';
            $msg['password1_same'] = 'Your passwords don\'t match';
            $msg['password2_required'] = 'Please Enter Your Password Confirmation';
            $msg['password2_min'] = 'Password Confirmation must be at lest :min characters';
            $msg['transaction[customer][website]_required'] = 'Please Enter Your Site Address';
            $msg['transaction[billing][first_name]_required'] = 'Please Enter Your Billing First Name';
            $msg['transaction[billing][last_name]_required'] = 'Please Enter Your Billing Last Name';
            $msg['transaction[billing][street_address]_required'] = 'Please Enter Your Billing Address';
            $msg['transaction[billing][locality]_required'] = 'Please Enter Your Billing City';
            $msg['transaction[billing][region]_required'] = 'Please Enter Your Billing State';
            $msg['transaction[billing][country_name]_required'] = 'Please Enter Your Billing Country';
            $msg['transaction[billing][country_name]_exists'] = 'The Selected Billing Country is invalid';
            $msg['transaction[billing][postal_code]_required'] = 'Please Enter Your Billing Zip';
            $msg['transaction[credit_card][number]_required'] = 'Please Enter Your Credit Card Number';
            $msg['transaction[credit_card][number]_numeric'] = 'Credit Card Number must be numeric';
            $msg['transaction[credit_card][expiration_month]_required'] = 'Please Enter Expiry Month';
            $msg['transaction[credit_card][expiration_month]_in'] = 'The selected Expiry Month is invalid';
            $msg['transaction[credit_card][expiration_year]_required'] = 'Please Enter Expiry Year';
            $msg['transaction[credit_card][expiration_year]_in'] = 'The selected Expiry Year is invalid';
            $msg['transaction[credit_card][cvv]_required'] = 'Please Enter Your CVV';

            return $msg;

        }



        // function that makes an ajax validation.
        function action_ajax_validation($key = null){
            
            // run the validation and get errors if there are.
            $errors = $this->run_validation();

            // check if there returned errors.
            if( ! empty($errors) ){
                
                // var to hold the json.
                $err_json = array();
                
                // loop through the field sections.
                foreach( $errors as $section => $section_errors ){
                    
                    // format the field name to be like their name in form.
                    $name = $section;
                    $name = ( $name != 'account' ? 'transaction[' . $name . ']' : $name );

                    foreach( $section_errors->messages as $field_name => $error_msg ){
                        
                        // part of formatting the field name to be like their name in form.
                        $final_name = $name . '[' . $field_name . ']';

                        // collect the field names and errors.
                        $err_json[$final_name] = $error_msg[0];

                    }

                }

                // now format the field name and error msg as json.
                return json_encode($err_json);
                
            }

        }

    }

?>
