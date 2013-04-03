<?php
    
    class Login_Controller extends Base_Controller{
        
        // validate user login and return error.
        function action_validate(){
            
            // set validation rules and messages.
            Validator::register('valid_username', function($attr, $val, $param){
                
                // inputted username should exist in username or email field.
                $result = DB::table('User')
                    ->where('username', '=', $val)
                    ->or_where('email', '=', $val)
                    ->get('username');
                
                return ( ! empty($result) );
                
            });
            
            $rules['username'] = 'required|valid_username';
            $rules['password'] = 'required';
            $msg['username_valid_username'] = 'The username/email is invalid.';
            
            
            $error_msg = '';
            $validation = Validator::make(Input::get(), $rules, $msg);
            
            // if validation fails, collect the error msg.
            if( $validation->fails() ){
                
                foreach( $validation->errors->messages as $name => $msg ){
                    $error_msg .= $msg[0] . '<br/>';
                }
                
                return $error_msg;
                
            }
            
        }
        
        
        
        // build and return the application login url of the user using his inputted username.
        function action_get_app_login_url(){
            
            $company = DB::table('User')
                ->join('Company', 'User.companyid', '=', 'Company.companyid')
                ->where('User.username', '=', Input::get('username'))
                ->or_where('User.email', '=', Input::get('username'))
                ->get('Company.name');
            
            return 'https://' . $company[0]->name . '.fdback.com/login';
            
        }
        
    }
    
?>