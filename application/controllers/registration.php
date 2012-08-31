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
                $email->to(FormData::reg('transaction[customer][email]'))->send();

                
                // redirect to success page with the customer's site name.
                $site = URL::base();
                $site = str_replace('http://', 'https://' . FormData::reg('transaction[customer][website]') . '.', $site);
                $site = $site . '/login';
                return Redirect::to('registration-successful/?login_url=' . $site);


            // if any of the validations failed, show the regs form with errors.
            }else{
                
                return $this->action_show_form(FormData::reg('account[plan]'), $errors);

            }

        }



        // run the validation of registration form. 
        // return the errors if there are. return false if none.
        function run_validation(){

            // get the validation rules.
            $account_rules = $this->get_validation_rules('account');
            $customer_rules = $this->get_validation_rules('customer');
            $billing_rules = $this->get_validation_rules('billing');
            $credit_card_rules = $this->get_validation_rules('credit_card');
            
            // get the custom validation messages.
            $account_msg = $this->get_validation_messages('account');
            $customer_msg = $this->get_validation_messages('customer');
            $billing_msg = $this->get_validation_messages('billing');
            $credit_card_msg = $this->get_validation_messages('credit_card');
            
            // create validation objects.
            //$account_val = Validator::make($account_input, $account_rules, $account_msg);
            $account_val = Validator::make(FormData::reg('account'), $account_rules, $account_msg);
            $customer_val = Validator::make(FormData::reg('transaction[customer]'), $customer_rules, $customer_msg);
            $billing_val = Validator::make(FormData::reg('transaction[billing]'), $billing_rules, $billing_msg);
            $credit_card_val = Validator::make(FormData::reg('transaction[credit_card]'), $credit_card_rules, $credit_card_msg);
            
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
        function get_validation_messages($key = null){
            
            $msg['account']['username_required'] = 'Please Enter Your Username';
            $msg['account']['username_max'] = 'The Username must be less than :max characters';
            $msg['account']['password1_required'] = 'Please Enter Your Password';
            $msg['account']['password1_min'] = 'Password must be at lest :min characters';
            $msg['account']['password1_same'] = 'Your passwords don\'t match';
            $msg['account']['password2_required'] = 'Please Enter Your Password Confirmation';
            $msg['account']['password2_min'] = 'Password Confirmation must be at lest :min characters';
            
            $msg['customer']['first_name_required'] = 'Please Enter Your First Name';
            $msg['customer']['first_name_max'] = 'The First Name must be less than :max characters';
            $msg['customer']['last_name_required'] = 'Please Enter Your Last Name';
            $msg['customer']['last_name_max'] = 'The Last Name must be less than :max characters';
            $msg['customer']['email_required'] = 'Please Enter Your Email';
            $msg['customer']['email_max'] = 'The Email must be less than :max characters';
            $msg['customer']['company_required'] = 'Please Enter Your Company';
            $msg['customer']['company_max'] = 'The Company must be less than :max characters';
            $msg['customer']['website_required'] = 'Please Enter Your Site Address';
            $msg['customer']['website_max'] = 'The Site Address must be less than :max characters';
            
            $msg['billing']['first_name_required'] = 'Please Enter Your Billing First Name';
            $msg['billing']['last_name_required'] = 'Please Enter Your Billing Last Name';
            $msg['billing']['street_address_required'] = 'Please Enter Your Billing Address';
            $msg['billing']['locality_required'] = 'Please Enter Your Billing City';
            $msg['billing']['region_required'] = 'Please Enter Your Billing State';
            $msg['billing']['country_name_required'] = 'Please Enter Your Billing Country';
            $msg['billing']['country_name_exists'] = 'The Selected Billing Country is invalid';
            $msg['billing']['postal_code_required'] = 'Please Enter Your Billing Zip';
            
            $msg['credit_card']['number_required'] = 'Please Enter Your Credit Card Number';
            $msg['credit_card']['number_numeric'] = 'Credit Card Number must be numeric';
            $msg['credit_card']['expiration_month_required'] = 'Please Enter Expiry Month';
            $msg['credit_card']['expiration_month_in'] = 'The selected Expiry Month is invalid';
            $msg['credit_card']['expiration_year_required'] = 'Please Enter Expiry Year';
            $msg['credit_card']['expiration_year_in'] = 'The selected Expiry Year is invalid';
            $msg['credit_card']['cvv_required'] = 'Please Enter Your CVV';

            return $msg[$key];

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
