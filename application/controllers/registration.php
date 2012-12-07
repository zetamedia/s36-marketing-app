<?php
    
    use Account\Entities\FormData;
    use Account\Repositories\DBAccount;
    use Account\Services\AccountService;
    
    class Registration_Controller extends Base_Controller{
        
        // show the registration form.
        function action_show_form($plan = null, $errors = null){
            
            $form_data = new FormData( (object)Input::get() );
            
            // redirect to plan selection if the selected plan is not valid.
            if( ! in_array($plan, $form_data->get_valid_plans()) ) return Redirect::to('pricing');
            
            
            // if plan is secret, treat it as premium.
            $data['plan'] = ($plan == 'secret' ? 'premium' : $plan);
            $data['country_names'] = DBCountry::get_all_names();
            $data['us_states'] = ReservedData::get('us_states');
            $data['no_billing_plans'] = ReservedData::get('no_billing_plans');
            
            // if $errors is object, it's an error from form validation.
            $data['err'] = ( is_object($errors) ? $errors : null );
            
            // if $errors is not object, it's an array error from braintree.
            $data['braintree_err'] = ( is_object($errors) ? null : $errors );
            
            return View::of('layout')->nest('contents', 'home.registration', $data);
            
        }



        // do all the process in registration.
        function action_process(){
            
            $form_data = new FormData( (object)Input::get() );
            $account_service = new AccountService();
            $db_account = new DBAccount();
            $s36_email = new S36Email();
            
            
            // run the form validation and show errors in form if there are.
            if( ! $account_service->validate_form($form_data) ){
                
                return $this->action_show_form(URI::segment(2), $account_service->get_form_errors());
                
            }
            
            
            // if selected plan is a no billing plan, need not to do braintree stuffs.
            if( ! in_array(URI::segment(2), ReservedData::get('no_billing_plans')) ){
                
                // create braintree account and get the result.
                $result = S36Braintree::create_account();
                
                // if braintree account creation didn't succeed, show the regs form with errors.
                if( ! $result['success'] ) return $this->action_show_form(URI::segment(2), $result['message']);

            }
            
            // if selected plan is a no billing plan, set customer_id to blank.
            $result['customer_id'] = ( in_array(URI::segment(2), ReservedData::get('no_billing_plans')) ? '' : $result['customer_id'] );

            
            // do the registration processing if form validation and braintree succeeds.
            
            // save customer account in db.
            $db_account->create_account($result['customer_id']);
            
            // send email to customer.
            $s36_email->create_new_account_email()->to( $form_data->get()->email )->send();
            
            // redirect to success page with the customer's site name.
            return Redirect::to('registration-successful/?login_url=' . $account_service->create_account_url( $form_data->get()->site_name ));
            
        }
        
        
        
        // function that makes an ajax validation.
        function action_ajax_validation(){
            
            $form_data = new FormData( (object)Input::get() );
            $account_service = new AccountService();
            
            if( ! $account_service->validate_form($form_data) ){
                
                $err_arr = array();

                foreach( $account_service->get_form_errors()->messages as $name => $msg ){
                    
                    $err_arr[$name] = $msg[0];

                }

                return json_encode($err_arr);
                
            }
            
        }

    }

?>
