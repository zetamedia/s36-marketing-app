<?php
    
    class S36Braintree{
        
        private $customer_id;
        private $token;
        private $subscriptions;
        private $transactions = array();
        private $next_billing_info;
        private $subscription_id;
        private $credit_card_info;
        private $exists = true;
        private $existence_err = '';



        // set the braintree's config keys.
        private static function set_keys(){
            
            \Braintree_Configuration::environment('sandbox');
            \Braintree_Configuration::merchantId('nq9jcgbqntjg9ktd');
            \Braintree_Configuration::publicKey('2y99t792gdwy8bqz');
            \Braintree_Configuration::privateKey('0c410ba21ac3498d755c9fd6ad5cd491');

        }



        // create new braintree object using company id.
        function __construct($customer_id){
            
            self::set_keys();
            $result_arr = array('success' => true, 'message' => array());


            // get data of company from braintree server.
            try{
                
                $customer = \Braintree_Customer::find($customer_id);

            // if company is not found, stop execution and store existence status and error.
            }catch(Exception $e){
                
                $this->exists = false;
                $this->existence_err = 'Customer with id ' . $customer_id . ' not found';
                return;

            }


            // store customer_id and payment method token.
            $this->customer_id = $customer_id;
            $this->token = $customer->creditCards[0]->token;


            $a = 0;  // index of subscriptions.
            $b = 0;  // index of transactions.

            // loop through subscriptions to get its friends.
            foreach( $customer->creditCards[0]->subscriptions as $subs ){
                
                // store the subscriptions data.
                $this->subscriptions[$a]['subscription_id'] =  $subs->id;
                $this->subscriptions[$a]['plan_id'] = $subs->planId;
                $this->subscriptions[$a]['amount'] = $subs->price;
                $this->subscriptions[$a]['status'] = $subs->status;
                $this->subscriptions[$a]['transactions'] = array();  // if no transactions, it will be empty array.

                // loop transactions.
                if( count($subs->transactions) ){
                    
                    foreach( $subs->transactions as $trans ){
                        
                        // store the transactions data of the subscription.
                        $this->subscriptions[$a]['transactions'][$b]['transaction_id'] =  $trans->id;
                        $this->subscriptions[$a]['transactions'][$b]['card_type'] =  $trans->creditCard['cardType'];
                        $this->subscriptions[$a]['transactions'][$b]['plan_id'] =  $trans->planId;
                        $this->subscriptions[$a]['transactions'][$b]['amount'] =  $trans->amount;
                        $this->subscriptions[$a]['transactions'][$b]['date'] =  $trans->createdAt;
                        
                        // store the transactions in its own variable.
                        $this->transactions[] = $this->subscriptions[$a]['transactions'][$b];
                        
                        $b++;

                    }

                    $b = 0;

                }

                $a++;
            }


            // in the end of subscription loop, we can get the next billing info
            // because it comes from the last subscription. and also the current subscription id.
            $this->subscription_id = $subs->id;
            $this->next_billing_info['amount'] = $subs->nextBillAmount;
            $this->next_billing_info['date'] = $subs->nextBillingDate;

            // customer can update his credit card in s36 but he can not add.
            // he can only have one record of credit card and that will always be the default.
            // default credit card is always stored in $customer->creditCards[0].
            // if customer updated his credit card, transactions that he made with previous 
            // credit card is kept recorded.
            $this->next_billing_info['card_type'] = $customer->creditCards[0]->cardType;


            // store the default credit card's info.
            $this->credit_card_info['card_type'] = $customer->creditCards[0]->cardType;
            $this->credit_card_info['masked_number'] = $customer->creditCards[0]->maskedNumber;
            $this->credit_card_info['expiration_month'] = $customer->creditCards[0]->expirationMonth;
            $this->credit_card_info['expiration_year'] = $customer->creditCards[0]->expirationYear;
            $this->credit_card_info['expired'] = $customer->creditCards[0]->expired;

        }



        // return existence status of company.
        function exists(){
            
            return $this->exists;

        }



        // return existence error of the company.
        function get_existence_error(){
            
            return $this->existence_err;

        }



        // return existence result of the company.
        // this is to be used as returned result array in other functions
        // so this will follow the format of other result array.
        function get_existence_result(){
            
            $err['success'] = $this->exists;
            $err['message'] = array($this->existence_err);

            return $err;

        }


        
        // create account with braintree.
        static function create_account(){
            
            self::set_keys();
            
            $plan = new DBPlan(Input::get('plan'));
            $plan_id = strtolower($plan->get_name());
            $result_arr = array('success' => true, 'message' => array());

            
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
                $result_arr['message'] = explode("\n", $result->message);

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

            
            // return all the shit from account and subscription creation.
            return $result_arr;
            
        }



        // update subscription.
        function update_subscription($plan_id){
            
            // say something if company doesn't exist.
            if( ! $this->exists() ) return $this->get_existence_result();

            
            self::set_keys();
            $result_arr = array('success' => true, 'message' => array());
            

            // create new subscription.
            $result = \Braintree_Subscription::create(array(
                'paymentMethodToken' => $this->token,
                'planId' => strtolower($plan_id)
            ));


            // if new subscription creation didn't succeed, don't continue below.
            // return status and error msg.
            if( ! $result->success ){

                $result_arr['success'] = $result->success;
                $result_arr['message'] = explode("\n", $result->message);

                return $result_arr;
                
            }


            // cancel the previous subscription.
            \Braintree_Subscription::cancel($this->subscription_id);

            // update subscription_id.
            $this->subscription_id = $result->subscription->id;


            return $result_arr;

        }



        // get next billing info of the subscription.
        function get_next_billing_info(){
            
            // say something if company doesn't exist.
            if( ! $this->exists() ) return $this->get_existence_result();


            return $this->next_billing_info;
            
        }



        // get billing history.
        function get_billing_history(){
            
            // say something if company doesn't exist.
            if( ! $this->exists() ) return $this->get_existence_result();


            return $this->transactions;
            
        }



        // update credit card info.
        function update_credit_card($number, $cvv, $exp_month, $exp_year, $zip){
            
            // say something if company doesn't exist.
            if( ! $this->exists() ) return $this->get_existence_result();


            self::set_keys();
            $result_arr = array('success' => true, 'message' => array());


            $result = \Braintree_CreditCard::update(
                $this->token,
                array(
                    'number' => $number,
                    'cvv' => $cvv,
                    'expirationMonth' => $exp_month,
                    'expirationYear' => $exp_year,
                    'billingAddress' => array(
                        'postalCode' => $zip,
                        'options' => array(
                            'updateExisting' => true
                        )
                    )
                    
                )
            );


            // return the status of the update. also the error msg is there is.
            if( ! $result->success ){
                $result_arr['success'] = $result->success;
                $result_arr['message'] = explode("\n", $result->message);
            }


            return $result_arr;

        }



        // get current credit card info.
        function get_credit_card_info(){
            
            // say something if company doesn't exist.
            if( ! $this->exists() ) return $this->get_existence_result();


            return $this->credit_card_info;

        }

    }

?>
