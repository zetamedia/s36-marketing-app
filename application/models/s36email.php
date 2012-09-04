<?php
    
    use PostMark\PostMark;

    class S36Email{
        
        private $key = '11c0c3be-3d0c-47b2-99a6-02fb1c4eed71';
        private $sender = 'news@36stories.com';
        //private $bcc = 'ryanchua6@gmail.com,wrm932@gmail.com';
        private $bcc = 'kennwel.labarda@microsourcing.ph';
        private $receiver;
        private $subject;
        private $body;



        function __construct($key = null, $sender = null, $bcc = null){
            
            // reset the key, sender, bcc if given.
            $this->key = (is_null($key) ? $this->key : $key);
            $this->sender = (is_null($sender) ? $this->sender : $sender);
            $this->bcc = (is_null($bcc) ? $this->bcc : $bcc);

        }



        // create new account email.
        function create_new_account_email(){

            $data['firstname'] = HTML::entities( Input::get('first_name') );
            $data['username'] = HTML::entities( Input::get('username') );
            $data['password'] = HTML::entities( Input::get('password') );
            $data['customer_email'] = HTML::entities( Input::get('email') );
            $site = URL::base();
            $site = str_replace('http://', 'https://' . Input::get('site_name') . '.', $site);
            $site .= '/login';
            $data['account_login_url'] = HTML::entities( $site );

            $this->subject = '36Stories New Account';
            $this->body = View::make('emails.new-account', $data);

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
