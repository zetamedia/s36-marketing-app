<?php
    
    namespace S36Braintree;
    use Input;
    
    class S36Braintree{
        
        // make a server-to-server transaction with braintree.
        static function transact(){
            
            // get first the price of the selected plan.
            $plan = new \Plan( Input::get('plan') );
            $amount = $plan->get_price();


            // set the braintree's config keys.
            \Braintree_Configuration::environment('sandbox');
            \Braintree_Configuration::merchantId('nq9jcgbqntjg9ktd');
            \Braintree_Configuration::publicKey('2y99t792gdwy8bqz');
            \Braintree_Configuration::privateKey('0c410ba21ac3498d755c9fd6ad5cd491');


            // do the server-to-server braintree transaction.
            $result = \Braintree_Transaction::sale(array(
                'amount' => $amount,
                'options' => array(
                    'submitForSettlement' => true
                ),
                'customer' => array(
                    'firstName' => Input::get('first_name'),
                    'lastName' => Input::get('last_name'),
                    'email' => Input::get('email'),
                    'company' => Input::get('company'),
                    'website' => 'www.' . Input::get('site_name') . '.com'
                ),
                'billing' => array(
                    'firstName' => Input::get('billing_first_name'),
                    'lastName' => Input::get('billing_last_name'),
                    'streetAddress' => Input::get('billing_address'),
                    'locality' => Input::get('billing_city'),
                    'region' => Input::get('billing_state'),
                    'countryName' => Input::get('billing_country'),
                    'postalCode' => Input::get('billing_zip')
                ),
                'creditCard' => array(
                    'number' => Input::get('card_number'),
                    'expirationMonth' => Input::get('expiration_month'),
                    'expirationYear' => Input::get('expiration_year'),
                    'cvv' => Input::get('cvv')
                )
            ));

            return $result;

        }

    }

?>
