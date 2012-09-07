<?php
    
    class S36Braintree{
        
        private $company_id;
        private $customer_id;
        private $token;
        private $subscription_id;



        // set the braintree's config keys.
        private static function set_keys(){
            
            \Braintree_Configuration::environment('sandbox');
            \Braintree_Configuration::merchantId('nq9jcgbqntjg9ktd');
            \Braintree_Configuration::publicKey('2y99t792gdwy8bqz');
            \Braintree_Configuration::privateKey('0c410ba21ac3498d755c9fd6ad5cd491');

        }



        // create new braintree object using company id.
        function __construct($company_id){
            
            $company = DB::table('Company')->where('companyId', '=', $company_id)->get(array('companyId', 'bt_customer_id', 'bt_payment_token', 'bt_subscription_id'));
            
            $this->company_id = $company[0]->companyid;
            $this->customer_id = $company[0]->bt_customer_id;
            $this->token = $company[0]->bt_payment_token;
            $this->subscription_id = $company[0]->bt_subscription_id;

        }


        
        // create account with braintree.
        static function create_account(){
            
            self::set_keys();
            
            $plan = new Plan(Input::get('plan'));
            $plan_id = strtolower($plan->get_name());
            $result_arr = array();

            
            // create braintree customer account.
            $result = \Braintree_Customer::create(array(
                'firstName' => Input::get('first_name'),
                'lastName' => Input::get('last_name'),
                'email' => Input::get('email'),
                'company' => Input::get('company'),
                'website' => 'www.' . Input::get('site_name') . '.com',
                'creditCard' => array(
                    'number' => Input::get('card_number'),
                    'expirationMonth' => Input::get('expiration_month'),
                    'expirationYear' => Input::get('expiration_year'),
                    'cvv' => Input::get('cvv'),
                    'billingAddress' => array(
                        'firstName' => Input::get('billing_first_name'),
                        'lastName' => Input::get('billing_last_name'),
                        'streetAddress' => Input::get('billing_address'),
                        'locality' => Input::get('billing_city'),
                        'region' => Input::get('billing_state'),
                        'countryName' => Input::get('billing_country'),
                        'postalCode' => Input::get('billing_zip')
                    )
                )
            ));


            // if account creation fails, store only the status and error message.
            if( ! $result->success ){
                
                $result_arr['success'] = $result->success;
                $result_arr['message'] = $result->message;

                return $result_arr;

            }


            // if account creation succeeds, store status, customer_id, token.
            $result_arr['success'] = $result->success;
            $result_arr['customer_id'] = $result->customer->id;
            $result_arr['token'] = $result->customer->creditCards[0]->token;


            // create subscription.
            $result = \Braintree_Subscription::create(array(
                'paymentMethodToken' => $result_arr['token'],
                'planId' => $plan_id
            ));

            // store result from subscription creation.
            $result_arr['subscription_id'] = $result->subscription->id;

            
            // return all the shit from account and subscription creation.
            return $result_arr;
            
        }



        // update subscription.
        function update_subscription($plan_id){
            
            self::set_keys();
            

            // cancel current subscription.
            $result = \Braintree_Subscription::cancel($this->subscription_id);


            // create new subscription.
            $result = \Braintree_Subscription::create(array(
                'paymentMethodToken' => $this->token,
                'planId' => $plan_id
            ));


            // update subscription_id.
            $this->subscription_id = $result->subscription->id;

            DB::table('Company')->where('companyId', '=', $this->company_id)->update(array('bt_subscription_id' => $this->subscription_id));

        }



        // get next billing info of the subscription.
        function get_next_billing_info(){
            
            self::set_keys();
            $result_arr = array();

            $result = \Braintree_Subscription::find($this->subscription_id);
            $result_arr['amount'] = $result->nextBillAmount;
            $result_arr['date'] = $result->nextBillingDate;

            return $result_arr;

        }



        // get billing history.
        function get_billing_history(){
            
            self::set_keys();
            $result_arr = array();
            $i = 0;
            
            $result = \Braintree_Customer::find($this->customer_id);

            foreach( $result->creditCards[0]->subscriptions as $subs ){
                
                // don't store anything if there are transactions yet.
                if( count($subs->transactions) ){

                    $result_arr[$i]['plan_id'] = $subs->planId;

                    foreach( $subs->transactions as $trans ){
                        
                        $result_arr[$i]['amount'] = $trans->amount;
                        $result_arr[$i++]['date'] = $trans->createdAt;

                    }

                }

            }

            return $result_arr;

        }

    }

?>
