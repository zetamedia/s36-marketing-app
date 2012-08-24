<?php
    
    use PostMark\PostMark;


    class S36Email{
        
        private $key = '11c0c3be-3d0c-47b2-99a6-02fb1c4eed71';
        private $sender = 'news@36stories.com';
        //private $bcc = 'ryanchua6@gmail.com,wrm932@gmail.com';
        private $bcc = 'kennwel.labarda@microsourcing.ph'; // for testing.
        private $receiver;
        private $subject;
        private $body;



        function __construct($type, $key = null, $sender = null, $bcc = null){
            
            // reset the key, sender, bcc if given.
            $this->key = (is_null($key) ? $this->key : $key);
            $this->sender = (is_null($sender) ? $this->sender : $sender);
            $this->bcc = (is_null($bcc) ? $this->bcc : $bcc);


            // create email content for registration success.
            if( $type == 'registration' ){
                
                $this->subject = '36Stories Account';
                $this->body = 'Username: ' . HTML::entities(Input::get('username')) . '<br/> Password: ' . HTML::entities(Input::get('password1'));

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
