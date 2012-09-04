<?php
    
    // class to easily access the form fields. 
    // this is intended not to have a namespace so it can be accessed globally
    // just like Input class.
    class FormData{
        
        // contains form fields in registration.
        static function reg($key = null){

            $data['account'] = self::get('account');
            $data['transaction[customer]'] = self::get('transaction', 'customer');
            $data['transaction[billing]'] = self::get('transaction', 'billing');
            $data['transaction[credit_card]'] = self::get('transaction', 'credit_card');
            
            $data['account[username]'] = self::get('account', 'username');
            $data['account[password1]'] = self::get('account', 'password1');
            $data['account[password2]'] = self::get('account', 'password2');
            $data['account[plan]'] = self::get('account', 'plan');
            
            $data['transaction[customer][first_name]'] = self::get('transaction', 'customer', 'first_name');
            $data['transaction[customer][last_name]'] = self::get('transaction', 'customer', 'last_name');
            $data['transaction[customer][email]'] = self::get('transaction', 'customer', 'email');
            $data['transaction[customer][company]'] = self::get('transaction', 'customer', 'company');
            $data['transaction[customer][website]'] = self::get('transaction', 'customer', 'website');
            
            $data['transaction[billing][first_name]'] = self::get('transaction', 'billing', 'first_name');
            $data['transaction[billing][last_name]'] = self::get('transaction', 'billing', 'last_name');
            $data['transaction[billing][street_address]'] = self::get('transaction', 'billing', 'street_address');
            $data['transaction[billing][locality]'] = self::get('transaction', 'billing', 'locality');
            $data['transaction[billing][region]'] = self::get('transaction', 'billing', 'region');
            $data['transaction[billing][country_name]'] = self::get('transaction', 'billing', 'country_name');
            $data['transaction[billing][postal_code]'] = self::get('transaction', 'billing', 'postal_code');
            
            $data['transaction[credit_card][number]'] = self::get('transaction', 'credit_card', 'number');
            $data['transaction[credit_card][expiration_month]'] = self::get('transaction', 'credit_card', 'expiration_month');
            $data['transaction[credit_card][expiration_year]'] = self::get('transaction', 'credit_card', 'expiration_year');
            $data['transaction[credit_card][cvv]'] = self::get('transaction', 'credit_card', 'cvv');
            
            

            $data['plan'] = self::get('account', 'plan');
            $data['first_name'] = self::get('transaction', 'customer', 'first_name');
            $data['last_name'] = self::get('transaction', 'customer', 'last_name');
            $data['email'] = self::get('transaction', 'customer', 'email');
            $data['company'] = self::get('transaction', 'customer', 'company');
            $data['username'] = self::get('account', 'username');
            $data['password'] = self::get('account', 'password1');
            $data['password_confirmation'] = self::get('account', 'password2');
            $data['site_name'] = self::get('transaction', 'customer', 'website');
            $data['billing_first_name'] = self::get('transaction', 'billing', 'first_name');
            $data['billing_last_name'] = self::get('transaction', 'billing', 'last_name');
            $data['billing_address'] = self::get('transaction', 'billing', 'street_address');
            $data['billing_city'] = self::get('transaction', 'billing', 'locality');
            $data['billing_state'] = self::get('transaction', 'billing', 'region');
            $data['billing_country'] = self::get('transaction', 'billing', 'country_name');
            $data['billing_zip'] = self::get('transaction', 'billing', 'postal_code');
            $data['card_number'] = self::get('transaction', 'credit_card', 'number');
            $data['expiration_month'] = self::get('transaction', 'credit_card', 'expiration_month');
            $data['expiration_year'] = self::get('transaction', 'credit_card', 'expiration_year');
            $data['cvv'] = self::get('transaction', 'credit_card', 'cvv');
            

            
            $data['plan'] = Input::get('plan');
            $data['first_name'] = Input::get('first_name');
            $data['last_name'] = Input::get('last_name');
            $data['email'] = Input::get('email');
            $data['company'] = Input::get('company');
            $data['username'] = Input::get('username');
            $data['password'] = Input::get('password');
            $data['password_confirmation'] = Input::get('password_confirmation');
            $data['site_name'] = Input::get('site_name');
            $data['billing_first_name'] = Input::get('billing_first_name');
            $data['billing_last_name'] = Input::get('billing_last_name');
            $data['billing_address'] = Input::get('billing_address');
            $data['billing_city'] = Input::get('billing_city');
            $data['billing_state'] = Input::get('billing_state');
            $data['billing_country'] = Input::get('billing_country');
            $data['billing_zip'] = Input::get('billing_zip');
            $data['card_number'] = Input::get('card_number');
            $data['expiration_month'] = Input::get('expiration_month');
            $data['expiration_year'] = Input::get('expiration_year');
            $data['cvv'] = Input::get('cvv');
            

            return $data[$key];

        }



        // get the value of form input. return null if form field doesn't exist.
        private static function get($k1, $k2 = null, $k3 = null){
            
            $a = Input::get();

            $v = ( array_key_exists($k1, $a) ? $a[$k1] : null );
            if( is_null($v) ) return $v;

            if( ! is_null($k2) ) $v = ( array_key_exists($k2, $a[$k1]) ? $a[$k1][$k2] : null );
            if( is_null($v) ) return $v;
            
            if( ! is_null($k3) ) $v = ( array_key_exists($k3, $a[$k1][$k2]) ? $a[$k1][$k2][$k3] : null );
            if( is_null($v) ) return $v;
            
            return $v;

        }

    }

?>
