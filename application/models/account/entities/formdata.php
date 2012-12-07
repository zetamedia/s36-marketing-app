<?php
    
    namespace Account\Entities;
    use DBPlan;
    
    class FormData{
        
        private $data;
        
        
        function __construct($input){
            
            $this->data = $input;
            
        }
        
        
        
        function get(){
            
            return $this->data;
            
        }
        
        
        
        // get the valid plans.
        function get_valid_plans(){
            
            // get the valid plans.
            $valid_plans = array_map('strtolower', DBPlan::get_all_names());

            // add "secret" to valid plans.
            $valid_plans[] = 'secret';
            
            // remove "basic" to valid plans.
            unset( $valid_plans[array_search('basic', $valid_plans)] );
            
            return $valid_plans;
            
        }
        
    }
    
?>