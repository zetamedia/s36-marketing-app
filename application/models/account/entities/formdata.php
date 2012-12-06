<?php
    
    namespace Account\Entities;
    
    class FormData{
        
        private $data;
        
        
        function __construct($input){
            
            $this->data = $input;
            
        }
        
        
        function get(){
            
            return $this->data;
            
        }
        
    }
    
?>