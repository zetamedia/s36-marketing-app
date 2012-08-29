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
            
            // get the inputs.
            $input = Input::get('transaction');
            $account_input = Input::get('account');
            $customer_input = $input['customer'];
            $billing_input = $input['billing'];
            $credit_card_input = $input['credit_card'];

            $data['firstname'] = HTML::entities( $customer_input['first_name'] );
            $data['username'] = HTML::entities( $account_input['username'] );
            $data['password'] = HTML::entities( $account_input['password1'] );
            $data['customer_email'] = HTML::entities( $customer_input['email'] );
            $site = URL::base();
            $site = str_replace('http://', 'https://' . $customer_input['website'] . '.', $site);
            $site = $site . '/login';
            $data['account_login_url'] = HTML::entities( $site );
            //$data['account_login_url'] = 'https://' . HTML::entities( $customer_input['website'] ) . '.36storiesapp.com/login';

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
