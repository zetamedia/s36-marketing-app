<?php
    
    namespace S36Braintree;
    use FormData;
    
    class S36Braintree{
        
        // make a server-to-server transaction with braintree.
        static function transact(){
            
            // get first the price of the selected plan.
            $plan = new \Plan( FormData::reg('plan') );
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
                    'firstName' => FormData::reg('first_name'),
                    'lastName' => FormData::reg('last_name'),
                    'email' => FormData::reg('email'),
                    'company' => FormData::reg('company'),
                    'website' => 'www.' . FormData::reg('site_name') . '.com'
                ),
                'billing' => array(
                    'firstName' => FormData::reg('billing_first_name'),
                    'lastName' => FormData::reg('billing_last_name'),
                    'streetAddress' => FormData::reg('billing_address'),
                    'locality' => FormData::reg('billing_city'),
                    'region' => FormData::reg('billing_state'),
                    'countryName' => FormData::reg('billing_country'),
                    'postalCode' => FormData::reg('billing_zip')
                ),
                'creditCard' => array(
                    'number' => FormData::reg('card_number'),
                    'expirationMonth' => FormData::reg('expiration_month'),
                    'expirationYear' => FormData::reg('expiration_year'),
                    'cvv' => FormData::reg('cvv')
                )
            ));

            return $result;

        }

    }

?>
