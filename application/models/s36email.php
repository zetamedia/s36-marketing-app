<?php
    
    use PostMark\PostMark;


    class S36Email{
        
        private $key = '11c0c3be-3d0c-47b2-99a6-02fb1c4eed71';
        private $sender = 'news@36stories.com';
        private $bcc = 'ryanchua6@gmail.com,wrm932@gmail.com';
        //private $bcc = 'kennwel.labarda@microsourcing.ph';
        private $receiver;
        private $subject;
        private $body;
        private $email_dir = 'public/36Stories - eDM';
        private $email_uri = '36Stories - eDM';
        private $codes = array(
            'base_url' => '[_BASE_URL_]',
            'email_uri' => '[_EMAIL_URI_]',
            'firstname' => '[_FIRSTNAME_]',
            'username' => '[_USERNAME_]',
            'password' => '[_PASSWORD_]',
            'customer_email' => '[_CUSTOMER_EMAIL_]',
            'account_login_url' => '[_ACCOUNT_LOGIN_URL_]'
        );



        function __construct($type, $key = null, $sender = null, $bcc = null){
            
            // reset the key, sender, bcc if given.
            $this->key = (is_null($key) ? $this->key : $key);
            $this->sender = (is_null($sender) ? $this->sender : $sender);
            $this->bcc = (is_null($bcc) ? $this->bcc : $bcc);


            // create email content for new account.
            if( $type == 'new-account' ){
                
                $subject = '36Stories New Account';
                $body = file_get_contents($this->email_dir . '/new-account.html');

                $firstname = HTML::entities(Input::get('firstname'));
                $username = HTML::entities(Input::get('username'));
                $password = HTML::entities(Input::get('password1'));
                $customer_email = HTML::entities(Input::get('email'));
                $account_login_url = 'https://' . HTML::entities(Input::get('website')) . '.36storiesapp.com/login';

                $body = str_replace($this->codes['firstname'], $firstname, $body);
                $body = str_replace($this->codes['username'], $username, $body);
                $body = str_replace($this->codes['password'], $password, $body);
                $body = str_replace($this->codes['customer_email'], $customer_email, $body);
                $body = str_replace($this->codes['account_login_url'], $account_login_url, $body);
                $body = str_replace($this->codes['base_url'], URL::base(), $body);
                $body = str_replace($this->codes['email_uri'], $this->email_uri, $body);

                $this->subject = $subject;
                $this->body = $body;

            }

        }



        // set email receiver.
        function to($receiver){
            
            $this->receiver = $receiver;
            return $this;

        }



        // send the email! yaaah!
        function send(){
            
            $postmark = new PostMark($this->key, $this->sender, $this->bcc);
            $postmark->to($this->receiver)->subject($this->subject)->html_message($this->body)->send(); 

        }

    }

?>
